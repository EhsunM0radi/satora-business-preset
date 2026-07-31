<?php

namespace Webkul\BusinessPreset\Contracts;

interface BusinessPreset
{
    /**
     * Get the preset code.
     */
    public function getCode(): string;

    /**
     * Get the preset name.
     */
    public function getName(): string;

    /**
     * Get the preset description.
     */
    public function getDescription(): ?string;

    /**
     * Get the recommended theme code.
     */
    public function getRecommendedTheme(): string;

    /**
     * Get the recommended template code.
     */
    public function getRecommendedTemplate(): string;

    /**
     * Get the default categories to create.
     */
    public function getDefaultCategories(): array;

    /**
     * Get the recommended settings.
     */
    public function getRecommendedSettings(): array;

    /**
     * Get the sample product IDs or URLs (optional).
     */
    public function getSampleProducts(): array;

    /**
     * Get the default CMS pages.
     */
    public function getDefaultPages(): array;

    /**
     * Get the navigation structure.
     */
    public function getNavigation(): array;

    /**
     * Get the preset as array.
     */
    public function toArray(): array;
}
