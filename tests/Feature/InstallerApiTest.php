<?php

use Webkul\BusinessPreset\Database\Seeders\BusinessPresetSeeder;
use Webkul\BusinessPreset\Helpers\PresetRegistry;
use Webkul\ThemeManager\Database\Seeders\ThemeAndTemplateSeeder;

beforeEach(function () {
    $this->seed(ThemeAndTemplateSeeder::class);
    $this->seed(BusinessPresetSeeder::class);
    $this->withoutMiddleware();
});

test('GET /install/api/satora/presets returns all presets', function () {
    $response = $this->getJson('/install/api/satora/presets');
    $response->assertOk();
    $response->assertJsonCount(8, 'data');
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

test('GET templates/{code}/themes returns compatible themes', function () {
    $response = $this->getJson('/install/api/satora/templates/fashion/themes');
    $response->assertOk();
    $this->assertNotEmpty($response->json('data'));
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
    $registry = app(PresetRegistry::class);
    $registryCodes = array_keys($registry->all());
    sort($apiCodes);
    sort($registryCodes);
    expect($apiCodes)->toBe($registryCodes);
});
