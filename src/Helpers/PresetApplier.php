<?php

namespace Webkul\BusinessPreset\Helpers;

use Illuminate\Support\Facades\DB;
use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\CMS\Repositories\PageRepository;

/**
 * Applies a business preset during/after installation.
 *
 * Creates default categories, CMS pages, applies recommended settings,
 * and configures the store with the selected theme and template.
 */
class PresetApplier
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected PageRepository $pageRepository,
    ) {}

    /**
     * Apply a preset to a fresh installation.
     */
    public function apply(BusinessPresetContract $preset, array $options = []): array
    {
        $results = [
            'categories' => $this->createCategories($preset),
            'pages' => $this->createPages($preset),
            'settings' => $this->applySettings($preset),
            'theme' => $preset->getRecommendedTheme(),
            'template' => $preset->getRecommendedTemplate(),
        ];

        // Store the applied preset code for reference
        DB::table('core_config')->updateOrInsert(
            ['code' => 'satora.active_preset'],
            ['value' => $preset->getCode(), 'channel_code' => null, 'locale_code' => null]
        );

        // Store the selected theme
        DB::table('core_config')->updateOrInsert(
            ['code' => 'satora.active_theme'],
            ['value' => $preset->getRecommendedTheme(), 'channel_code' => null, 'locale_code' => null]
        );

        // Store the selected template
        DB::table('core_config')->updateOrInsert(
            ['code' => 'satora.active_template'],
            ['value' => $preset->getRecommendedTemplate(), 'channel_code' => null, 'locale_code' => null]
        );

        return $results;
    }

    /**
     * Create default categories from preset configuration.
     */
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

    /**
     * Create a single category.
     */
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

        // Translational fields
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

    /**
     * Create default CMS pages from preset configuration.
     */
    protected function createPages(BusinessPresetContract $preset): int
    {
        $count = 0;

        foreach ($preset->getDefaultPages() as $pageData) {
            $title = $pageData['title'] ?? 'Page';
            $slug = $pageData['slug'] ?? strtolower(str_replace(' ', '-', $title));

            // CMS page core record
            $pageId = DB::table('cms_pages')->insertGetId([
                'layout' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert translations for en, fa, ar, tr
            foreach (['en', 'fa', 'ar', 'tr'] as $locale) {
                DB::table('cms_page_translations')->insert([
                    'cms_page_id' => $pageId,
                    'locale' => $locale,
                    'page_title' => $title,
                    'url_key' => $slug,
                    'html_content' => "<p>{$title} content goes here.</p>",
                    'meta_title' => $title,
                    'meta_description' => '',
                    'meta_keywords' => '',
                ]);
            }

            $count++;
        }

        return $count;
    }

    /**
     * Apply recommended settings to core_config.
     */
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
}
