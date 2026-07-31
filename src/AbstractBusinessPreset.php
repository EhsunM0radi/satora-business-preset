<?php

namespace Webkul\BusinessPreset;

use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;

abstract class AbstractBusinessPreset implements BusinessPresetContract
{
    protected string $code;

    protected string $name;

    protected ?string $description = null;

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'general';

    protected array $defaultCategories = [];

    protected array $recommendedSettings = [];

    protected array $sampleProducts = [];

    protected array $defaultPages = [];

    protected array $navigation = [];

    protected ?string $icon = null;

    protected ?string $previewImage = null;

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
        return $this->recommendedTheme;
    }

    public function getRecommendedTemplate(): string
    {
        return $this->recommendedTemplate;
    }

    public function getDefaultCategories(): array
    {
        return $this->defaultCategories;
    }

    public function getRecommendedSettings(): array
    {
        return $this->recommendedSettings;
    }

    public function getSampleProducts(): array
    {
        return $this->sampleProducts;
    }

    public function getDefaultPages(): array
    {
        return $this->defaultPages;
    }

    public function getNavigation(): array
    {
        return $this->navigation;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'preview_image' => $this->previewImage,
            'recommended_theme' => $this->recommendedTheme,
            'recommended_template' => $this->recommendedTemplate,
            'default_categories' => $this->defaultCategories,
            'recommended_settings' => $this->recommendedSettings,
            'default_pages' => $this->defaultPages,
            'navigation' => $this->navigation,
        ];
    }
}
