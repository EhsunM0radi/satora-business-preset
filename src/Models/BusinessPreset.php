<?php

namespace Webkul\BusinessPreset\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\BusinessPreset\Contracts\BusinessPresetModel;

class BusinessPreset extends Model implements BusinessPresetContract, BusinessPresetModel
{
    /**
     * The table associated with the model.
     */
    protected $table = 'satora_business_presets';

    /**
     * The attributes that are mass assignable.
     */
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
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

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
        ];
    }
}
