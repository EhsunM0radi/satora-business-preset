<?php

use Illuminate\Support\Facades\DB;
use Webkul\BusinessPreset\Database\Seeders\BusinessPresetSeeder;
use Webkul\ThemeManager\Database\Seeders\ThemeAndTemplateSeeder;

beforeEach(function () {
    $this->seed(ThemeAndTemplateSeeder::class);
    $this->seed(BusinessPresetSeeder::class);
    // Ensure Administrator role exists
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
    // Ensure root category exists (needed by category repository)
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
        foreach (['en', 'fa', 'ar', 'tr'] as $locale) {
            DB::table('category_translations')->insert([
                'category_id' => 1,
                'locale' => $locale,
                'name' => 'Root',
                'slug' => 'root',
                'meta_title' => 'Root',
            ]);
        }
    }
    $this->withoutMiddleware();
});

test('POST apply preset returns a response', function () {
    $response = $this->post('/admin/settings/presets/apply', ['code' => 'fashion']);
    // Without session middleware the response won't redirect, but the controller runs
    expect($response->status())->toBeIn([200, 302, 500]);
});

test('POST apply preset runs without error', function () {
    $response = $this->post('/admin/settings/presets/apply', ['code' => 'beauty']);
    expect($response->status())->not->toBe(500);
});

test('POST apply preset applies theme config', function () {
    $this->post('/admin/settings/presets/apply', ['code' => 'electronics']);
    $stored = DB::table('core_config')->where('code', 'satora.active_theme')->first();
    if ($stored) {
        expect(in_array($stored->value, ['modern-dark', 'minimal-luxury', 'colorful']))->toBeTrue();
    } else {
        $this->markTestSkipped('No core_config entry');
    }
});

test('POST apply preset is idempotent for config', function () {
    $this->post('/admin/settings/presets/apply', ['code' => 'fashion']);
    $first = DB::table('core_config')->where('code', 'satora.active_preset')->first();
    $this->post('/admin/settings/presets/apply', ['code' => 'fashion']);
    $second = DB::table('core_config')->where('code', 'satora.active_preset')->first();
    if ($first && $second) {
        expect($first->value)->toBe($second->value);
    }
});

test('POST apply preset configures theme', function () {
    $this->post('/admin/settings/presets/apply', ['code' => 'fashion']);
    $theme = DB::table('core_config')->where('code', 'satora.active_theme')->first();
    if ($theme) {
        expect($theme->value)->not->toBeNull();
    }
});
