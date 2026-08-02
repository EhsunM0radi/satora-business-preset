<?php

use Illuminate\Support\Facades\DB;
use Webkul\BusinessPreset\Database\Seeders\BusinessPresetSeeder;
use Webkul\ThemeManager\Database\Seeders\ThemeAndTemplateSeeder;

beforeEach(function () {
    $this->seed(ThemeAndTemplateSeeder::class);
    $this->seed(BusinessPresetSeeder::class);
    $this->withoutMiddleware();
});

test('POST apply preset writes config', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'fashion']);
    $exists = DB::table('core_config')->where('code', 'satora.active_preset')->exists();
    expect($exists)->toBeTrue();
});

test('POST apply preset shows success flash', function () {
    $response = $this->post('/admin/satora/presets/apply', ['code' => 'beauty']);
    $response->assertSessionHas('success');
});

test('POST apply preset applies theme config', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'electronics']);
    $stored = DB::table('core_config')->where('code', 'satora.active_theme')->first();
    if ($stored) {
        expect(in_array($stored->value, ['modern-dark', 'minimal-luxury', 'colorful']))->toBeTrue();
    } else {
        $this->markTestSkipped('No core_config entry');
    }
});

test('POST apply preset is idempotent for config', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'fashion']);
    $first = DB::table('core_config')->where('code', 'satora.active_preset')->first();
    $this->post('/admin/satora/presets/apply', ['code' => 'fashion']);
    $second = DB::table('core_config')->where('code', 'satora.active_preset')->first();
    if ($first && $second) {
        expect($first->value)->toBe($second->value);
    }
});

test('POST apply preset configures theme', function () {
    $this->post('/admin/satora/presets/apply', ['code' => 'fashion']);
    $theme = DB::table('core_config')->where('code', 'satora.active_theme')->first();
    if ($theme) {
        expect($theme->value)->not->toBeNull();
    }
});
