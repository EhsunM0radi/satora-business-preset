<?php

use Webkul\BusinessPreset\Database\Seeders\BusinessPresetSeeder;
use Webkul\BusinessPreset\Services\WebsiteBuilderService;
use Webkul\ThemeManager\Database\Seeders\ThemeAndTemplateSeeder;

// ── WebsiteBuilderService Unit Tests ──

beforeEach(function () {
    $this->seed(ThemeAndTemplateSeeder::class);
    $this->seed(BusinessPresetSeeder::class);
    $this->builder = app(WebsiteBuilderService::class);
});

// ── Recommendation structure ──

test('recommend returns all expected top-level keys', function () {
    $result = $this->builder->recommend([
        'business_type' => 'fashion',
        'brand_name' => 'Moda',
        'industry' => 'fashion',
    ]);

    expect($result)->toHaveKeys([
        'preset',
        'recommended_theme',
        'recommended_template',
        'homepage_sections',
        'color_suggestions',
        'content_structure',
    ]);
});

test('recommend returns valid theme', function () {
    $result = $this->builder->recommend(['business_type' => 'fashion']);
    expect($result['recommended_theme'])->toBeIn(['minimal-luxury', 'modern-dark', 'colorful']);
});

test('recommend returns valid template', function () {
    $result = $this->builder->recommend(['business_type' => 'electronics']);
    expect($result['recommended_template'])->toBeIn(['fashion', 'electronics', 'grocery', 'general']);
});

test('recommend has at least 4 homepage sections', function () {
    $result = $this->builder->recommend(['business_type' => 'grocery']);
    expect(count($result['homepage_sections']))->toBeGreaterThanOrEqual(4);
});

test('homepage sections always include hero and newsletter', function () {
    $result = $this->builder->recommend(['business_type' => 'custom']);
    expect($result['homepage_sections'])->toContain('hero-banner');
    expect($result['homepage_sections'])->toContain('newsletter');
});

test('color suggestions have primary and accent', function () {
    $result = $this->builder->recommend([]);
    expect($result['color_suggestions'])->toHaveKeys(['primary', 'accent']);
    expect($result['color_suggestions']['primary'])->toStartWith('#');
});

test('content structure has hero section', function () {
    $result = $this->builder->recommend(['brand_name' => 'MyBrand']);
    expect($result['content_structure']['hero'])->toHaveKeys(['title', 'subtitle', 'cta_text', 'cta_url']);
    expect($result['content_structure']['hero']['title'])->toContain('MyBrand');
});

test('content structure has about section', function () {
    $result = $this->builder->recommend(['brand_name' => 'Acme']);
    expect($result['content_structure']['about'])->toHaveKeys(['title', 'body']);
    expect($result['content_structure']['about']['title'])->toContain('Acme');
});

test('content structure has pages', function () {
    $result = $this->builder->recommend([]);
    expect(count($result['content_structure']['pages']))->toBeGreaterThanOrEqual(3);
    expect($result['content_structure']['pages'][0])->toHaveKeys(['title', 'slug']);
});

// ── Industry-specific recommendations ──

test('fashion preset returns minimal-luxury theme', function () {
    $result = $this->builder->recommend(['business_type' => 'fashion']);
    expect($result['recommended_theme'])->toBe('minimal-luxury');
    expect($result['recommended_template'])->toBe('fashion');
});

test('electronics preset returns modern-dark theme', function () {
    $result = $this->builder->recommend(['business_type' => 'electronics']);
    expect($result['recommended_theme'])->toBe('modern-dark');
    expect($result['recommended_template'])->toBe('electronics');
});

test('grocery preset returns colorful theme', function () {
    $result = $this->builder->recommend(['business_type' => 'grocery']);
    expect($result['recommended_theme'])->toBe('colorful');
    expect($result['recommended_template'])->toBe('grocery');
});

test('no business type falls back to minimal-luxury and general', function () {
    $result = $this->builder->recommend([]);
    expect($result['recommended_theme'])->toBe('minimal-luxury');
    expect($result['recommended_template'])->toBe('general');
});

// ── Style-based fallback ──

test('dark style preference recommends modern-dark', function () {
    $result = $this->builder->recommend(['preferred_style' => 'dark']);
    expect($result['recommended_theme'])->toBe('modern-dark');
});

test('vibrant style preference recommends colorful', function () {
    $result = $this->builder->recommend(['preferred_style' => 'vibrant']);
    expect($result['recommended_theme'])->toBe('colorful');
});

test('unknown style defaults to minimal-luxury', function () {
    $result = $this->builder->recommend(['preferred_style' => 'unknown']);
    expect($result['recommended_theme'])->toBe('minimal-luxury');
});

// ── Industry-based section additions ──

test('fashion industry adds lookbook and instagram sections', function () {
    $result = $this->builder->recommend(['industry' => 'fashion retail']);
    expect($result['homepage_sections'])->toContain('lookbook');
    expect($result['homepage_sections'])->toContain('instagram-gallery');
});

test('tech industry adds comparison and brand sections', function () {
    $result = $this->builder->recommend(['industry' => 'electronics tech']);
    expect($result['homepage_sections'])->toContain('comparison-section');
    expect($result['homepage_sections'])->toContain('brand-showcase');
});

test('food industry adds deals and recipes', function () {
    $result = $this->builder->recommend(['industry' => 'grocery food']);
    expect($result['homepage_sections'])->toContain('daily-deals');
    expect($result['homepage_sections'])->toContain('recipe-inspiration');
});
