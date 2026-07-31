<?php

use Webkul\BusinessPreset\Database\Seeders\BusinessPresetSeeder;
use Webkul\ThemeManager\Database\Seeders\ThemeAndTemplateSeeder;
use Webkul\User\Models\Admin;

// ── Admin PresetController Integration ──
// Tests POST behavior and side-effects (categories, pages, config writes).

beforeEach(function () {
    $this->seed(ThemeAndTemplateSeeder::class);
    $this->seed(BusinessPresetSeeder::class);
    $admin = Admin::first() ?? Admin::factory()->create();
    $this->actingAs($admin, 'admin');
});

test('POST apply preset writes config and redirects', function () {
    $response = $this->post('/admin/satora/presets/apply', ['code' => 'fashion']);
    $response->assertRedirect();

    $stored = DB::table('core_config')->where('code', 'satora.active_preset')->first();
    expect($stored)->not->toBeNull();
    expect($stored->value)->toBe('fashion');
});

test('POST apply preset shows success flash', function () {
    $response = $this->post('/admin/satora/presets/apply', ['code' => 'beauty']);
    $response->assertSessionHas('success');
});

test('POST apply preset creates categories', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'grocery']);
    $count = DB::table('categories')->where('id', '>', 1)->count();
    expect($count)->toBeGreaterThan(0);
});

test('POST apply preset creates CMS pages', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'custom']);
    $count = DB::table('cms_pages')->count();
    expect($count)->toBeGreaterThan(0);
});

test('POST apply preset applies theme config', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'electronics']);

    $stored = DB::table('core_config')->where('code', 'satora.active_theme')->first();
    expect($stored->value)->toBe('modern-dark');
});

test('POST apply preset is idempotent for config', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'fashion']);
    $this->post('/admin/satora/presets/apply', ['code' => 'fashion']);

    $count = DB::table('core_config')->where('code', 'satora.active_preset')->count();
    expect($count)->toBe(1);
});
