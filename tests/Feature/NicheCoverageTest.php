<?php

use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\BusinessPreset\Helpers\PresetRegistry;

/**
 * NicheCoverageTest — comprehensive tests for ALL 8 BusinessPreset niches.
 *
 * Niches: Fashion, Electronics, Grocery, Beauty, Digital, Furniture, Generic (diverse), Custom
 */

// ─── Registry-level tests ──────────────────────────────────────────

beforeEach(function () {
    $this->registry = app(PresetRegistry::class);
});

test('PresetRegistry lists all 8 niches', function () {
    expect($this->registry->count())->toBe(8);

    $all = $this->registry->all();
    expect($all)->toBeArray()->toHaveCount(8);

    $codes = array_keys($all);
    expect($codes)->toContain('fashion');
    expect($codes)->toContain('electronics');
    expect($codes)->toContain('grocery');
    expect($codes)->toContain('beauty');
    expect($codes)->toContain('digital');
    expect($codes)->toContain('furniture');
    expect($codes)->toContain('diverse');
    expect($codes)->toContain('custom');
});

test('PresetRegistry filtering by code works', function () {
    expect($this->registry->has('fashion'))->toBeTrue();
    expect($this->registry->has('custom'))->toBeTrue();
    expect($this->registry->has('nonexistent'))->toBeFalse();
});

test('PresetRegistry getting unknown code returns null', function () {
    expect($this->registry->get('nonexistent'))->toBeNull();
    expect($this->registry->get('fake_preset'))->toBeNull();
    expect($this->registry->get(''))->toBeNull();
});

test('PresetRegistry returns BusinessPresetContract instances', function () {
    foreach ($this->registry->all() as $code => $preset) {
        expect($preset)->toBeInstanceOf(BusinessPresetContract::class);
    }
});

// ─── Universal tests for each niche ─────────────────────────────────

$validThemes = ['minimal-luxury', 'modern-dark', 'colorful'];
$validTemplates = ['fashion', 'electronics', 'grocery', 'general', 'furniture'];

$requiredToArrayKeys = [
    'code', 'name', 'description', 'icon', 'preview_image',
    'recommended_theme', 'recommended_template', 'default_categories',
    'recommended_settings', 'default_pages', 'navigation',
    'product_attributes', 'attribute_family', 'product_types',
];

$allNicheCodes = ['fashion', 'electronics', 'grocery', 'beauty', 'digital', 'furniture', 'diverse', 'custom'];

foreach ($allNicheCodes as $nicheCode) {
    // 1. Preset can be loaded from PresetRegistry
    test("{$nicheCode}: preset loads from PresetRegistry", function () use ($nicheCode) {
        $preset = $this->registry->get($nicheCode);
        expect($preset)->not->toBeNull();
        expect($preset)->toBeInstanceOf(BusinessPresetContract::class);
    });

    // 2. getCode() returns correct code
    test("{$nicheCode}: getCode() returns correct code", function () use ($nicheCode) {
        $preset = $this->registry->get($nicheCode);
        expect($preset->getCode())->toBe($nicheCode);
    });

    // 3. getName() returns non-empty string
    test("{$nicheCode}: getName() returns non-empty string", function () use ($nicheCode) {
        $preset = $this->registry->get($nicheCode);
        expect($preset->getName())->toBeString()->not->toBeEmpty();
    });

    // 4. getRecommendedTheme() returns valid theme code
    test("{$nicheCode}: getRecommendedTheme() returns valid theme", function () use ($nicheCode, $validThemes) {
        $preset = $this->registry->get($nicheCode);
        expect($preset->getRecommendedTheme())->toBeString()->not->toBeEmpty();
        expect($preset->getRecommendedTheme())->toBeIn($validThemes);
    });

    // 5. getRecommendedTemplate() returns valid template code
    test("{$nicheCode}: getRecommendedTemplate() returns valid template", function () use ($nicheCode, $validTemplates) {
        $preset = $this->registry->get($nicheCode);
        expect($preset->getRecommendedTemplate())->toBeString()->not->toBeEmpty();
        expect($preset->getRecommendedTemplate())->toBeIn($validTemplates);
    });

    // 6. getDefaultCategories() has at least 2 items
    test("{$nicheCode}: getDefaultCategories() has at least 2 items", function () use ($nicheCode) {
        $preset = $this->registry->get($nicheCode);
        $categories = $preset->getDefaultCategories();
        expect($categories)->toBeArray();
        expect(count($categories))->toBeGreaterThanOrEqual(2);
    });

    // 7. getDefaultPages() has at least 1 item
    test("{$nicheCode}: getDefaultPages() has at least 1 item", function () use ($nicheCode) {
        $preset = $this->registry->get($nicheCode);
        $pages = $preset->getDefaultPages();
        expect($pages)->toBeArray();
        expect(count($pages))->toBeGreaterThanOrEqual(1);
    });

    // 8. getNavigation() has at least 3 items
    test("{$nicheCode}: getNavigation() has at least 3 items", function () use ($nicheCode) {
        $preset = $this->registry->get($nicheCode);
        $nav = $preset->getNavigation();
        expect($nav)->toBeArray();
        expect(count($nav))->toBeGreaterThanOrEqual(3);
    });

    // 9. getRecommendedSettings() is non-empty array
    test("{$nicheCode}: getRecommendedSettings() is non-empty array", function () use ($nicheCode) {
        $preset = $this->registry->get($nicheCode);
        $settings = $preset->getRecommendedSettings();
        expect($settings)->toBeArray()->not->toBeEmpty();
    });

    // 10. toArray() has all required keys
    test("{$nicheCode}: toArray() has all required keys", function () use ($nicheCode, $requiredToArrayKeys) {
        $preset = $this->registry->get($nicheCode);
        $array = $preset->toArray();
        expect($array)->toBeArray();
        foreach ($requiredToArrayKeys as $key) {
            expect($array)->toHaveKey($key);
        }
    });
}

// ─── Niche-specific assertions ─────────────────────────────────────

// Fashion
test('Fashion: has getProductAttributes() with size and color', function () {
    $preset = $this->registry->get('fashion');
    $attrs = $preset->getProductAttributes();

    expect($attrs)->toBeArray()->not->toBeEmpty();

    $attrCodes = array_column($attrs, 'code');
    expect($attrCodes)->toContain('size');
    expect($attrCodes)->toContain('color');
});

test('Fashion: has attribute family', function () {
    $preset = $this->registry->get('fashion');
    $family = $preset->getAttributeFamily();

    expect($family)->toBeArray()->not->toBeEmpty();
    expect($family)->toHaveKey('code');
    expect($family)->toHaveKey('name');
    expect($family)->toHaveKey('groups');
    expect($family['code'])->toBe('fashion');
    expect($family['groups'])->toBeArray()->not->toBeEmpty();
});

test('Fashion: productTypes includes configurable', function () {
    $preset = $this->registry->get('fashion');
    $types = $preset->getProductTypes();

    expect($types)->toBeArray()->not->toBeEmpty();
    expect($types)->toContain('configurable');
});

// Electronics
test('Electronics: recommendedTheme is modern-dark or minimal-luxury', function () {
    $preset = $this->registry->get('electronics');
    $theme = $preset->getRecommendedTheme();

    expect($theme)->toBeIn(['modern-dark', 'minimal-luxury']);
});

test('Electronics: has correct niche code', function () {
    $preset = $this->registry->get('electronics');
    expect($preset->getCode())->toBe('electronics');
});

test('Electronics: has tech-related categories', function () {
    $preset = $this->registry->get('electronics');
    $categories = $preset->getDefaultCategories();
    $names = array_column($categories, 'name');
    expect($names)->toContain('Smartphones');
    expect($names)->toContain('Laptops');
});

// Grocery
test('Grocery: has categories like Fruits & Vegetables or Dairy & Eggs', function () {
    $preset = $this->registry->get('grocery');
    $categories = $preset->getDefaultCategories();
    $names = array_column($categories, 'name');

    // At least one of the expected grocery categories should exist
    $groceryCategories = ['Fruits & Vegetables', 'Dairy & Eggs', 'Bakery', 'Beverages', 'Meat & Seafood'];
    $found = array_intersect($groceryCategories, $names);
    expect($found)->not->toBeEmpty();
});

test('Grocery: has at least 6 categories', function () {
    $preset = $this->registry->get('grocery');
    expect(count($preset->getDefaultCategories()))->toBeGreaterThanOrEqual(6);
});

// Beauty
test('Beauty: has skincare and makeup categories', function () {
    $preset = $this->registry->get('beauty');
    $categories = $preset->getDefaultCategories();
    $names = array_column($categories, 'name');

    expect($names)->toContain('Skincare');
    expect($names)->toContain('Makeup');
});

test('Beauty: product attributes are defined (or empty gracefully)', function () {
    $preset = $this->registry->get('beauty');
    $attrs = $preset->getProductAttributes();
    // Beauty preset may not define product attributes; verify it returns array
    expect($attrs)->toBeArray();
    // If attributes are defined, they should follow the expected structure
    if (! empty($attrs)) {
        foreach ($attrs as $attr) {
            expect($attr)->toHaveKey('code');
            expect($attr)->toHaveKey('admin_name');
        }
    }
});

// Digital
test('Digital: recommendedTheme is modern-dark', function () {
    $preset = $this->registry->get('digital');
    expect($preset->getRecommendedTheme())->toBe('modern-dark');
});

test('Digital: has digital-product categories', function () {
    $preset = $this->registry->get('digital');
    $categories = $preset->getDefaultCategories();
    $names = array_column($categories, 'name');

    expect($names)->toContain('Software');
    expect($names)->toContain('Ebooks');
});

// Furniture
test('Furniture: has categories', function () {
    $preset = $this->registry->get('furniture');
    $categories = $preset->getDefaultCategories();

    expect($categories)->toBeArray();
    expect(count($categories))->toBeGreaterThanOrEqual(4);
});

test('Furniture: has recommendedTemplate set to furniture', function () {
    $preset = $this->registry->get('furniture');
    expect($preset->getRecommendedTemplate())->toBe('furniture');
});

// Generic (diverse) — note: code is 'diverse', task calls it "Generic"
test('Generic (diverse): productTypes includes simple', function () {
    $preset = $this->registry->get('diverse');
    $types = $preset->getProductTypes();

    expect($types)->toBeArray();
    expect($types)->toContain('simple');
});

test('Generic (diverse): has minimal default configuration', function () {
    $preset = $this->registry->get('diverse');

    expect($preset->getCode())->toBe('diverse');
    expect($preset->getRecommendedTemplate())->toBe('general');
    expect(count($preset->getDefaultPages()))->toBeGreaterThanOrEqual(2);
    expect(count($preset->getNavigation()))->toBeGreaterThanOrEqual(3);
});

// Custom
test('Custom: code is custom', function () {
    $preset = $this->registry->get('custom');
    expect($preset->getCode())->toBe('custom');
});

test('Custom: has bare-bones setup', function () {
    $preset = $this->registry->get('custom');

    expect($preset->getName())->toBe('Custom Business');
    expect(count($preset->getDefaultCategories()))->toBe(2);
    expect(count($preset->getDefaultPages()))->toBe(2);
    expect(count($preset->getNavigation()))->toBe(3);
});

test('Custom: productTypes includes simple', function () {
    $preset = $this->registry->get('custom');
    $types = $preset->getProductTypes();

    expect($types)->toBeArray();
    expect($types)->toContain('simple');
});

// ─── Cross-niche uniqueness tests ─────────────────────────────────

test('All 8 niches have unique codes', function () {
    $codes = [];
    foreach ($this->registry->all() as $preset) {
        $codes[] = $preset->getCode();
    }
    expect(count($codes))->toBe(8);
    expect(count(array_unique($codes)))->toBe(8);
});

test('All 8 niches have unique names', function () {
    $names = [];
    foreach ($this->registry->all() as $preset) {
        $names[] = $preset->getName();
    }
    expect(count($names))->toBe(8);
    expect(count(array_unique($names)))->toBe(8);
});

test('All niches return non-empty description', function () {
    foreach ($this->registry->all() as $preset) {
        $desc = $preset->getDescription();
        if ($desc !== null) {
            expect($desc)->toBeString()->not->toBeEmpty();
        }
    }
});

test('All niches implement every required contract method', function () {
    foreach ($this->registry->all() as $preset) {
        // Call every method to verify no exceptions
        expect($preset->getCode())->toBeString();
        expect($preset->getName())->toBeString();
        $desc = $preset->getDescription();
        expect($desc === null || is_string($desc))->toBeTrue();
        expect($preset->getRecommendedTheme())->toBeString();
        expect($preset->getRecommendedTemplate())->toBeString();
        expect($preset->getDefaultCategories())->toBeArray();
        expect($preset->getRecommendedSettings())->toBeArray();
        expect($preset->getSampleProducts())->toBeArray();
        expect($preset->getDefaultPages())->toBeArray();
        expect($preset->getNavigation())->toBeArray();
        expect($preset->getProductAttributes())->toBeArray();
        expect($preset->getAttributeFamily())->toBeArray();
        expect($preset->getEmailTemplates())->toBeArray();
        expect($preset->getWidgets())->toBeArray();
        expect($preset->getBanners())->toBeArray();
        expect($preset->getRoles())->toBeArray();
        expect($preset->getPermissions())->toBeArray();
        expect($preset->getProductTypes())->toBeArray();
        expect($preset->toArray())->toBeArray();
    }
});
