<?php

namespace Webkul\BusinessPreset\Contracts;

interface BusinessPreset
{
    /** Get the preset code. */
    public function getCode(): string;

    /** Get the preset name. */
    public function getName(): string;

    /** Get the preset description. */
    public function getDescription(): ?string;

    /** Get the recommended theme code. */
    public function getRecommendedTheme(): string;

    /** Get the recommended template code. */
    public function getRecommendedTemplate(): string;

    /** Get the default categories to create. */
    public function getDefaultCategories(): array;

    /** Get the recommended settings (core_config key => value). */
    public function getRecommendedSettings(): array;

    /** Get sample product definitions. */
    public function getSampleProducts(): array;

    /** Get default CMS pages. */
    public function getDefaultPages(): array;

    /** Get navigation structure. */
    public function getNavigation(): array;

    /**
     * Get product attributes to create for this niche.
     * Returns array of attribute definitions with options.
     */
    public function getProductAttributes(): array;

    /**
     * Get the attribute family configuration.
     * Returns ['code' => 'fashion', 'name' => 'Fashion', 'groups' => [...]]
     */
    public function getAttributeFamily(): array;

    /**
     * Get email templates for this niche.
     * Returns array of ['code' => ..., 'subject' => ..., 'content' => ...]
     */
    public function getEmailTemplates(): array;

    /**
     * Get widget definitions for this niche.
     * Returns array of ['type' => ..., 'name' => ..., 'position' => ..., 'config' => ...]
     */
    public function getWidgets(): array;

    /**
     * Get banner definitions for this niche.
     * Returns array of ['title' => ..., 'image' => ..., 'link' => ..., 'position' => ...]
     */
    public function getBanners(): array;

    /**
     * Get roles to create for this niche.
     * Returns array of ['name' => ..., 'slug' => ..., 'description' => ..., 'permissions' => [...]]
     */
    public function getRoles(): array;

    /**
     * Get permissions to create for this niche.
     * Returns array of ['name' => ..., 'slug' => ..., 'group' => ..., 'description' => ...]
     */
    public function getPermissions(): array;

    /**
     * Get the product types enabled for this niche.
     * Returns array of product type codes.
     */
    public function getProductTypes(): array;

    /** Get the preset as array. */
    public function toArray(): array;
}
