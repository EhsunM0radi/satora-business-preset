<?php

use Webkul\BusinessPreset\Database\Seeders\BusinessPresetSeeder;
use Webkul\ThemeManager\Database\Seeders\ThemeAndTemplateSeeder;

// ── Installer API Integration Tests ──
// Note: These routes sit behind installer middleware. We bypass it for testing.

beforeEach(function () {
    $this->seed(ThemeAndTemplateSeeder::class);
    $this->seed(BusinessPresetSeeder::class);

    // Bypass installer middleware — app is already "installed" in testing
    $this->withoutMiddleware();
});

test('GET /install/api/satora/presets returns all presets', function () {
    $response = $this->getJson('/install/api/satora/presets');
    $response->assertOk();
    $response->assertJsonCount(9, 'data');
});

test('GET /install/api/satora/presets returns localized names', function () {
    $response = $this->getJson('/install/api/satora/presets?locale=fa');
    $response->assertOk();

    $data = $response->json('data');
    $fashion = collect($data)->firstWhere('code', 'fashion');
    expect($fashion['name'])->not->toBeEmpty();
});

test('GET /install/api/satora/themes returns all themes', function () {
    $response = $this->getJson('/install/api/satora/themes');
    $response->assertOk();
    $response->assertJsonCount(3, 'data');
});

test('GET /install/api/satora/themes returns theme colors', function () {
    $response = $this->getJson('/install/api/satora/themes');
    $response->assertOk();

    $data = $response->json('data');
    $first = $data[0];
    expect($first)->toHaveKeys(['code', 'name', 'colors', 'typography']);
    expect($first['colors'])->toBeArray();
});

test('GET /install/api/satora/templates returns all templates', function () {
    $response = $this->getJson('/install/api/satora/templates');
    $response->assertOk();
    $response->assertJsonCount(4, 'data');
});

test('GET /install/api/satora/templates returns sections', function () {
    $response = $this->getJson('/install/api/satora/templates');
    $response->assertOk();

    $data = $response->json('data');
    $fashion = collect($data)->firstWhere('code', 'fashion');
    expect($fashion)->toHaveKeys(['code', 'name', 'sections', 'navigation', 'homepage_layout']);
});

test('GET compatible themes returns all since universal', function () {
    $response = $this->getJson('/install/api/satora/themes/compatible/fashion');
    $response->assertOk();
    $response->assertJsonCount(3, 'data');
});

test('GET compatible templates returns all since universal', function () {
    $response = $this->getJson('/install/api/satora/templates/compatible/minimal-luxury');
    $response->assertOk();
    $response->assertJsonCount(4, 'data');
});

test('API returns valid JSON structure for presets', function () {
    $response = $this->getJson('/install/api/satora/presets');
    $response->assertOk();

    $preset = $response->json('data.0');
    expect($preset)->toHaveKeys([
        'code', 'name', 'description',
        'recommended_theme', 'recommended_template',
        'default_categories', 'default_pages', 'navigation',
    ]);
});

test('all preset codes match between registry and API', function () {
    $response = $this->getJson('/install/api/satora/presets');
    $response->assertOk();

    $apiCodes = collect($response->json('data'))->pluck('code')->toArray();

    $registry = app(\Webkul\BusinessPreset\Helpers\PresetRegistry::class);
    $registryCodes = array_keys($registry->all());

    sort($apiCodes);
    sort($registryCodes);

    expect($apiCodes)->toBe($registryCodes);
});
