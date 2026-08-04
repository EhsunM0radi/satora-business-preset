<?php

use Illuminate\Support\Facades\DB;
use Webkul\BusinessPreset\Database\Seeders\BusinessPresetSeeder;
use Webkul\BusinessPreset\Helpers\PresetApplier;
use Webkul\BusinessPreset\Helpers\PresetRegistry;
use Webkul\ThemeManager\Database\Seeders\ThemeAndTemplateSeeder;

// ── PresetApplier Integration Tests ──

beforeEach(function () {
    $this->seed(ThemeAndTemplateSeeder::class);
    $this->seed(BusinessPresetSeeder::class);
    // Ensure root category and roles exist
    if (! DB::table('categories')->where('id', 1)->exists()) {
        DB::table('categories')->insert([
            'id' => 1,
            'parent_id' => null,
            'position' => 0,
            'status' => 1,
            'display_mode' => 'products_and_description',
            '_lft' => 1,
            '_rgt' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('category_translations')->insert([
            'category_id' => 1,
            'locale' => 'en',
            'name' => 'Root',
            'slug' => 'root',
            'meta_title' => 'Root',
        ]);
    }
    if (! DB::table('roles')->where('id', 1)->exists()) {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Administrator',
            'description' => 'Administrator role',
            'permission_type' => 'all',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    $this->applier = app(PresetApplier::class);
    $this->registry = app(PresetRegistry::class);
});

test('applier successfully applies Fashion preset', function () {
    $preset = $this->registry->get('fashion');
    $result = $this->applier->apply($preset);

    expect($result)->toHaveKeys(['categories', 'pages', 'settings']);
    expect($result['categories'])->toBeGreaterThan(0);
    expect($result['pages'])->toBeGreaterThan(0);
    expect($result['settings'])->toBeGreaterThan(0);
});

test('applier stores preset code in core_config', function () {
    $preset = $this->registry->get('electronics');
    $this->applier->apply($preset);

    $stored = DB::table('core_config')->where('code', 'satora.active_preset')->first();
    expect($stored)->not->toBeNull();
    expect($stored->value)->toBe('electronics');
});

test('applier stores theme in core_config', function () {
    $preset = $this->registry->get('beauty');
    $this->applier->apply($preset);

    $stored = DB::table('core_config')->where('code', 'satora.active_theme')->first();
    expect($stored)->not->toBeNull();
    expect($stored->value)->toBe('minimal-luxury');
});

test('applier creates categories under root', function () {
    $preset = $this->registry->get('grocery');
    $result = $this->applier->apply($preset);

    $categories = DB::table('categories')->where('id', '>', 1)->get();
    expect($categories)->not->toBeEmpty();
});

test('applier creates cms pages', function () {
    $preset = $this->registry->get('custom');
    $result = $this->applier->apply($preset);

    $pages = DB::table('cms_pages')->get();
    expect($pages)->not->toBeEmpty();
});

test('applier applies recommended settings', function () {
    $preset = $this->registry->get('digital');
    $result = $this->applier->apply($preset);

    // At least one setting should have been written
    expect($result['settings'])->toBeGreaterThan(0);

    // Check a specific setting
    $setting = DB::table('core_config')
        ->where('code', 'general.design.admin_logo.theme')
        ->first();
    expect($setting->value)->toBe('modern-dark');
});

test('applier handles multiple presets without conflicts', function () {
    // Apply Fashion
    $fashion = $this->registry->get('fashion');
    $this->applier->apply($fashion);

    // Then apply Grocery — should overwrite config keys
    $grocery = $this->registry->get('grocery');
    $this->applier->apply($grocery);

    $presetCode = DB::table('core_config')->where('code', 'satora.active_preset')->first();
    expect($presetCode->value)->toBe('grocery');
});
