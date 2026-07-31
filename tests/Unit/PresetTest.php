<?php

use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\BusinessPreset\Presets\BeautyPreset;
use Webkul\BusinessPreset\Presets\CustomPreset;
use Webkul\BusinessPreset\Presets\DigitalPreset;
use Webkul\BusinessPreset\Presets\ElectronicsPreset;
use Webkul\BusinessPreset\Presets\FashionPreset;
use Webkul\BusinessPreset\Presets\GroceryPreset;
use Webkul\BusinessPreset\Presets\MarketplacePreset;
use Webkul\BusinessPreset\Presets\RestaurantPreset;
use Webkul\BusinessPreset\Presets\ServicesPreset;

// ── All presets implement the contract ──

$allPresets = [
    FashionPreset::class,
    ElectronicsPreset::class,
    GroceryPreset::class,
    BeautyPreset::class,
    RestaurantPreset::class,
    DigitalPreset::class,
    MarketplacePreset::class,
    ServicesPreset::class,
    CustomPreset::class,
];

foreach ($allPresets as $presetClass) {
    $shortName = (new ReflectionClass($presetClass))->getShortName();

    test("{$shortName} implements BusinessPreset contract", function () use ($presetClass) {
        $preset = new $presetClass;
        expect($preset)->toBeInstanceOf(BusinessPresetContract::class);
    });

    test("{$shortName} has valid code", function () use ($presetClass) {
        $preset = new $presetClass;
        expect($preset->getCode())->toBeString()->not->toBeEmpty();
    });

    test("{$shortName} has valid name", function () use ($presetClass) {
        $preset = new $presetClass;
        expect($preset->getName())->toBeString()->not->toBeEmpty();
    });

    test("{$shortName} recommends a valid theme", function () use ($presetClass) {
        $preset = new $presetClass;
        $validThemes = ['minimal-luxury', 'modern-dark', 'colorful'];
        expect($preset->getRecommendedTheme())->toBeIn($validThemes);
    });

    test("{$shortName} recommends a valid template", function () use ($presetClass) {
        $preset = new $presetClass;
        $validTemplates = ['fashion', 'electronics', 'grocery', 'general'];
        expect($preset->getRecommendedTemplate())->toBeIn($validTemplates);
    });
}

// ── Specific preset tests ──

test('FashionPreset recommends fashion template', function () {
    $preset = new FashionPreset;
    expect($preset->getRecommendedTheme())->toBe('minimal-luxury');
    expect($preset->getRecommendedTemplate())->toBe('fashion');
    expect(count($preset->getDefaultCategories()))->toBe(6);
});

test('ElectronicsPreset has tech categories', function () {
    $preset = new ElectronicsPreset;
    $categories = $preset->getDefaultCategories();
    $names = array_column($categories, 'name');
    expect($names)->toContain('Smartphones');
    expect($names)->toContain('Laptops');
    expect($names)->toContain('Gaming');
});

test('GroceryPreset has appropriate categories', function () {
    $preset = new GroceryPreset;
    $categories = $preset->getDefaultCategories();
    $names = array_column($categories, 'name');
    expect($names)->toContain('Fruits & Vegetables');
    expect($names)->toContain('Dairy & Eggs');
});

test('CustomPreset has minimal setup', function () {
    $preset = new CustomPreset;
    expect(count($preset->getDefaultCategories()))->toBe(2);
    expect(count($preset->getDefaultPages()))->toBe(2);
});

test('All presets have default pages', function () use ($allPresets) {
    foreach ($allPresets as $class) {
        $preset = new $class;
        expect(count($preset->getDefaultPages()))->toBeGreaterThanOrEqual(2);
    }
});

test('All presets have navigation', function () use ($allPresets) {
    foreach ($allPresets as $class) {
        $preset = new $class;
        expect(count($preset->getNavigation()))->toBeGreaterThanOrEqual(2);
    }
});

test('All presets toArray returns required keys', function () use ($allPresets) {
    foreach ($allPresets as $class) {
        $preset = new $class;
        $array = $preset->toArray();
        expect($array)->toHaveKeys([
            'code', 'name', 'recommended_theme', 'recommended_template',
            'default_categories', 'recommended_settings', 'default_pages', 'navigation',
        ]);
    }
});

test('All 9 presets have unique codes', function () use ($allPresets) {
    $codes = array_map(fn ($c) => (new $c)->getCode(), $allPresets);
    expect(count(array_unique($codes)))->toBe(9);
});
