<?php

namespace Webkul\BusinessPreset\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\BusinessPreset\Contracts\BusinessPresetModel;

class BusinessPreset extends Model implements BusinessPresetContract, BusinessPresetModel
{
    protected $table = 'satora_business_presets';

    protected $fillable = [
        'code',
        'name',
        'description',
        'recommended_theme',
        'recommended_template',
        'default_categories',
        'recommended_settings',
        'sample_products',
        'default_pages',
        'navigation',
        'attributes',
        'attribute_family',
        'email_templates',
        'widgets',
        'banners',
        'roles',
        'product_types',
        'icon',
        'preview_image',
        'is_active',
        'sort_order',
        'metadata',
    ];

    protected $casts = [
        'default_categories' => 'array',
        'recommended_settings' => 'array',
        'sample_products' => 'array',
        'default_pages' => 'array',
        'navigation' => 'array',
        'attributes' => 'array',
        'attribute_family' => 'array',
        'email_templates' => 'array',
        'widgets' => 'array',
        'banners' => 'array',
        'roles' => 'array',
        'product_types' => 'array',
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    // ─── Standard methods ────────────────────────────────────

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getRecommendedTheme(): string
    {
        return $this->recommended_theme ?? 'minimal-luxury';
    }

    public function getRecommendedTemplate(): string
    {
        return $this->recommended_template ?? 'general';
    }

    public function getDefaultCategories(): array
    {
        return $this->default_categories ?? [];
    }

    public function getRecommendedSettings(): array
    {
        return $this->recommended_settings ?? [];
    }

    public function getSampleProducts(): array
    {
        return $this->sample_products ?? [];
    }

    public function getDefaultPages(): array
    {
        return $this->default_pages ?? [];
    }

    public function getNavigation(): array
    {
        return $this->navigation ?? [];
    }

    // ─── Extended methods (Phase 1) ──────────────────────────

    public function getProductAttributes(): array
    {
        return $this->attributes ?? [];
    }

    public function getAttributeFamily(): array
    {
        return $this->attribute_family ?? [];
    }

    public function getEmailTemplates(): array
    {
        return $this->email_templates ?? [];
    }

    public function getWidgets(): array
    {
        return $this->widgets ?? [];
    }

    public function getBanners(): array
    {
        return $this->banners ?? [];
    }

    public function getRoles(): array
    {
        return $this->roles ?? [];
    }

    public function getPermissions(): array
    {
        return $this->metadata['permissions'] ?? [];
    }

    public function getProductTypes(): array
    {
        return $this->product_types ?? ['simple'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'preview_image' => $this->preview_image,
            'recommended_theme' => $this->recommended_theme,
            'recommended_template' => $this->recommended_template,
            'default_categories' => $this->default_categories,
            'recommended_settings' => $this->recommended_settings,
            'default_pages' => $this->default_pages,
            'navigation' => $this->navigation,
            'product_attributes' => $this->attributes,
            'attribute_family' => $this->attribute_family,
            'product_types' => $this->product_types,
        ];
    }
}
