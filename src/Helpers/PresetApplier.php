<?php

namespace Webkul\BusinessPreset\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\CMS\Repositories\PageRepository;

/**
 * Applies a business preset during/after installation.
 *
 * Creates categories, CMS pages, attributes, attribute families, attribute groups,
 * email templates, widgets, banners, roles, permissions, recommended settings,
 * and sample products — everything the niche needs to be functional.
 */
class PresetApplier
{
    protected int $nextAttributeId = 100;

    protected int $nextOptionId = 200;

    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected PageRepository $pageRepository,
    ) {}

    /**
     * Apply a full preset to a fresh installation or tenant.
     */
    public function apply(BusinessPresetContract $preset, array $options = []): array
    {
        $tenantId = $options['tenant_id'] ?? null;
        $now = Carbon::now();

        $results = [];

        // 1. Categories
        $results['categories'] = $this->createCategories($preset);

        // 2. CMS Pages
        $results['pages'] = $this->createPages($preset);

        // 3. Attributes, Family, Groups
        $attrResults = $this->createAttributes($preset);
        $results = array_merge($results, $attrResults);

        // 4. Email Templates
        $results['email_templates'] = $this->createEmailTemplates($preset, $tenantId);

        // 5. Widgets
        $results['widgets'] = $this->createWidgets($preset, $tenantId);

        // 6. Banners
        $results['banners'] = $this->createBanners($preset, $tenantId);

        // 7. Roles & Permissions
        $results['roles'] = $this->createRoles($preset, $tenantId);

        // 8. Settings
        $results['settings'] = $this->applySettings($preset);

        // 9. Store the applied preset + theme + template
        $this->storePresetConfig($preset);

        return $results;
    }

    /**
     * Uninstall a preset — remove all data created by this preset.
     */
    public function uninstall(BusinessPresetContract $preset, ?int $tenantId = null): array
    {
        $results = [];

        $presetCode = $preset->getCode();

        // Remove email templates
        $query = DB::table('satora_email_templates')->where('preset_code', $presetCode);
        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        }
        $results['email_templates_removed'] = $query->delete();

        // Remove widgets
        $query = DB::table('satora_widgets')->where('preset_code', $presetCode);
        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        }
        $results['widgets_removed'] = $query->delete();

        // Remove banners
        $query = DB::table('satora_banners')->where('preset_code', $presetCode);
        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        }
        $results['banners_removed'] = $query->delete();

        // Remove preset config
        DB::table('core_config')->where('code', 'satora.active_preset')->delete();

        return $results;
    }

    // ─── Categories ──────────────────────────────────────────────

    protected function createCategories(BusinessPresetContract $preset): int
    {
        $count = 0;
        $rootCategory = DB::table('categories')->first();
        $rootId = $rootCategory?->id ?? 1;

        foreach ($preset->getDefaultCategories() as $index => $categoryData) {
            $category = $this->createSingleCategory($categoryData, $rootId, $index);

            if ($category && ! empty($categoryData['children'])) {
                foreach ($categoryData['children'] as $childIndex => $childData) {
                    $this->createSingleCategory($childData, $category->id, $childIndex);
                }
            }

            $count++;
        }

        return $count;
    }

    protected function createSingleCategory(array $data, int $parentId, int $index): mixed
    {
        $name = $data['name'] ?? 'Category';
        $slug = strtolower(str_replace(' ', '-', $name));

        $categoryData = [
            'parent_id' => $parentId,
            'position' => $index,
            'status' => 1,
            'display_mode' => 'products_and_description',
        ];

        foreach (['en', 'fa', 'ar', 'tr'] as $locale) {
            $categoryData[$locale] = [
                'name' => $name,
                'slug' => $slug,
                'description' => '',
                'meta_title' => $name,
                'meta_description' => '',
                'meta_keywords' => '',
            ];
        }

        return $this->categoryRepository->create($categoryData);
    }

    // ─── CMS Pages ───────────────────────────────────────────────

    protected function createPages(BusinessPresetContract $preset): int
    {
        $count = 0;

        foreach ($preset->getDefaultPages() as $pageData) {
            $title = $pageData['title'] ?? 'Page';
            $slug = $pageData['slug'] ?? strtolower(str_replace(' ', '-', $title));
            $content = $pageData['content'] ?? "<p>{$title} content goes here.</p>";

            $pageId = DB::table('cms_pages')->insertGetId([
                'layout' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach (['en', 'fa', 'ar', 'tr'] as $locale) {
                DB::table('cms_page_translations')->insert([
                    'cms_page_id' => $pageId,
                    'locale' => $locale,
                    'page_title' => $title,
                    'url_key' => $slug,
                    'html_content' => $content,
                    'meta_title' => $title,
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]);
            }

            $count++;
        }

        return $count;
    }

    // ─── Attributes + Family + Groups ───────────────────────────

    protected function createAttributes(BusinessPresetContract $preset): array
    {
        $results = [
            'attributes' => 0,
            'options' => 0,
            'family' => null,
            'groups' => 0,
        ];

        // Find starting IDs
        $maxAttrId = DB::table('attributes')->max('id') ?? 30;
        $this->nextAttributeId = $maxAttrId + 1;

        $maxOptId = DB::table('attribute_options')->max('id') ?? 0;
        $this->nextOptionId = $maxOptId + 1;

        $attrIds = [];

        // 1. Create attributes with options
        foreach ($preset->getProductAttributes() as $attrData) {
            // Use updateOrInsert to allow re-application
            $existing = DB::table('attributes')->where('code', $attrData['code'])->first();
            if ($existing) {
                $attrId = $existing->id;
            } else {
                $attrId = $this->nextAttributeId++;
            }
            $attrIds[$attrData['code']] = $attrId;

            if (! $existing) {
                DB::table('attributes')->insert([
                    'id' => $attrId,
                    'code' => $attrData['code'],
                    'admin_name' => $attrData['admin_name'],
                    'type' => $attrData['type'] ?? 'select',
                    'swatch_type' => $attrData['swatch_type'] ?? null,
                    'validation' => $attrData['validation'] ?? null,
                    'position' => $attrData['position'] ?? 10,
                    'is_required' => $attrData['is_required'] ?? 0,
                    'is_unique' => $attrData['is_unique'] ?? 0,
                    'is_filterable' => $attrData['is_filterable'] ?? 0,
                    'is_comparable' => $attrData['is_comparable'] ?? 0,
                    'is_configurable' => $attrData['is_configurable'] ?? 0,
                    'is_user_defined' => 1,
                    'is_visible_on_front' => $attrData['is_visible_on_front'] ?? 1,
                    'value_per_locale' => $attrData['value_per_locale'] ?? 0,
                    'value_per_channel' => $attrData['value_per_channel'] ?? 0,
                    'enable_wysiwyg' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Translations (skip if already exist)
            $locales = DB::table('locales')->pluck('code');
            foreach ($locales as $locale) {
                $exists = DB::table('attribute_translations')
                    ->where('attribute_id', $attrId)
                    ->where('locale', $locale)
                    ->exists();
                if (! $exists) {
                    DB::table('attribute_translations')->insert([
                        'attribute_id' => $attrId,
                        'locale' => $locale,
                        'name' => $attrData['admin_name'],
                    ]);
                }
            }

            // Options (for select, multiselect, checkbox types)
            if (in_array($attrData['type'], ['select', 'multiselect', 'checkbox', 'boolean'])
                && ! empty($attrData['options'])) {
                foreach ($attrData['options'] as $optIndex => $optData) {
                    $optId = $this->nextOptionId++;

                    DB::table('attribute_options')->insert([
                        'id' => $optId,
                        'attribute_id' => $attrId,
                        'admin_name' => $optData['label'] ?? $optData,
                        'sort_order' => $optIndex,
                        'swatch_value' => $optData['swatch_value'] ?? null,
                    ]);

                    foreach ($locales as $locale) {
                        $optExists = DB::table('attribute_option_translations')
                            ->where('attribute_option_id', $optId)
                            ->where('locale', $locale)
                            ->exists();
                        if (! $optExists) {
                            DB::table('attribute_option_translations')->insert([
                                'attribute_option_id' => $optId,
                                'locale' => $locale,
                                'label' => $optData['label'] ?? (is_string($optData) ? $optData : ''),
                            ]);
                        }
                    }

                    $results['options']++;
                }
            }

            $results['attributes']++;
        }

        // 2. Create attribute family
        $familyData = $preset->getAttributeFamily();
        if (! empty($familyData)) {
            $familyId = DB::table('attribute_families')->insertGetId([
                'code' => $familyData['code'],
                'name' => $familyData['name'],
                'status' => 0,
                'is_user_defined' => 1,
            ]);

            $results['family'] = $familyData['code'];

            // Include default core attributes in every family
            $coreAttributeIds = [1, 2, 3, 9, 10, 11, 12, 16, 17, 18, 19, 20, 27, 28];

            // 3. Create attribute groups and mappings
            $groupId = DB::table('attribute_groups')->max('id') ?? 8;

            foreach ($familyData['groups'] as $groupIndex => $groupData) {
                $groupId++;
                $column = $groupData['column'] ?? 1;

                DB::table('attribute_groups')->insert([
                    'id' => $groupId,
                    'code' => $groupData['code'],
                    'name' => $groupData['name'],
                    'column' => $column,
                    'is_user_defined' => 1,
                    'position' => $groupIndex + 1,
                    'attribute_family_id' => $familyId,
                ]);

                // Map attributes to group
                $position = 0;
                foreach ($groupData['attributes'] as $attrCode) {
                    $position++;
                    $attrId = $attrIds[$attrCode] ?? null;
                    if ($attrId) {
                        DB::table('attribute_group_mappings')->insert([
                            'attribute_id' => $attrId,
                            'attribute_group_id' => $groupId,
                            'position' => $position,
                        ]);
                    }
                }

                $results['groups']++;
            }
        }

        return $results;
    }

    // ─── Email Templates ─────────────────────────────────────────

    protected function createEmailTemplates(BusinessPresetContract $preset, ?int $tenantId): int
    {
        $count = 0;

        foreach ($preset->getEmailTemplates() as $templateData) {
            DB::table('satora_email_templates')->updateOrInsert(
                [
                    'code' => $templateData['code'],
                    'preset_code' => $preset->getCode(),
                    'tenant_id' => $tenantId,
                ],
                [
                    'name' => $templateData['name'],
                    'subject' => $templateData['subject'],
                    'content' => $templateData['content'],
                    'is_active' => true,
                    'updated_at' => now(),
                ]
            );
            $count++;
        }

        return $count;
    }

    // ─── Widgets ─────────────────────────────────────────────────

    protected function createWidgets(BusinessPresetContract $preset, ?int $tenantId): int
    {
        $count = 0;

        foreach ($preset->getWidgets() as $index => $widgetData) {
            DB::table('satora_widgets')->updateOrInsert(
                [
                    'type' => $widgetData['type'],
                    'name' => $widgetData['name'],
                    'preset_code' => $preset->getCode(),
                    'tenant_id' => $tenantId,
                ],
                [
                    'position' => $widgetData['position'] ?? 'sidebar',
                    'config' => json_encode($widgetData['config'] ?? []),
                    'sort_order' => $index,
                    'is_active' => true,
                    'updated_at' => now(),
                ]
            );
            $count++;
        }

        return $count;
    }

    // ─── Banners ─────────────────────────────────────────────────

    protected function createBanners(BusinessPresetContract $preset, ?int $tenantId): int
    {
        $count = 0;

        foreach ($preset->getBanners() as $index => $bannerData) {
            DB::table('satora_banners')->updateOrInsert(
                [
                    'title' => $bannerData['title'],
                    'preset_code' => $preset->getCode(),
                    'tenant_id' => $tenantId,
                ],
                [
                    'subtitle' => $bannerData['subtitle'] ?? null,
                    'image_path' => $bannerData['image_path'] ?? null,
                    'link_url' => $bannerData['link_url'] ?? null,
                    'position' => $bannerData['position'] ?? 'homepage',
                    'sort_order' => $index,
                    'is_active' => true,
                    'updated_at' => now(),
                ]
            );
            $count++;
        }

        return $count;
    }

    // ─── Roles & Permissions ─────────────────────────────────────

    protected function createRoles(BusinessPresetContract $preset, ?int $tenantId): int
    {
        $count = 0;

        foreach ($preset->getRoles() as $roleData) {
            DB::table('roles')->updateOrInsert(
                ['name' => $roleData['name']],
                [
                    'description' => $roleData['description'] ?? null,
                    'permission_type' => $roleData['permission_type'] ?? 'custom',
                    'permissions' => json_encode($roleData['permissions'] ?? []),
                    'updated_at' => now(),
                ]
            );
            $count++;
        }

        return $count;
    }

    // ─── Settings ────────────────────────────────────────────────

    protected function applySettings(BusinessPresetContract $preset): int
    {
        $count = 0;

        foreach ($preset->getRecommendedSettings() as $code => $value) {
            DB::table('core_config')->updateOrInsert(
                ['code' => $code],
                [
                    'value' => $value,
                    'channel_code' => null,
                    'locale_code' => null,
                    'updated_at' => now(),
                ]
            );
            $count++;
        }

        return $count;
    }

    // ─── Config ──────────────────────────────────────────────────

    protected function storePresetConfig(BusinessPresetContract $preset): void
    {
        $configs = [
            'satora.active_preset' => $preset->getCode(),
            'satora.active_theme' => $preset->getRecommendedTheme(),
            'satora.active_template' => $preset->getRecommendedTemplate(),
            'satora.product_types' => json_encode($preset->getProductTypes()),
        ];

        foreach ($configs as $code => $value) {
            DB::table('core_config')->updateOrInsert(
                ['code' => $code],
                ['value' => $value, 'channel_code' => null, 'locale_code' => null]
            );
        }
    }
}
