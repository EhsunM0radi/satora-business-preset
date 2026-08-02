<?php

use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\BusinessPreset\Helpers\PresetRegistry;

// ── PresetRegistry Tests ──

beforeEach(function () {
    $this->registry = app(PresetRegistry::class);
});

test('registry contains all 8 presets', function () {
    expect($this->registry->count())->toBe(8);
});

test('registry returns preset by code', function () {
    $fashion = $this->registry->get('fashion');
    expect($fashion)->not->toBeNull();
    expect($fashion)->toBeInstanceOf(BusinessPresetContract::class);
    expect($fashion->getCode())->toBe('fashion');
});

test('registry returns null for unknown code', function () {
    expect($this->registry->get('nonexistent'))->toBeNull();
});

test('registry has method works', function () {
    expect($this->registry->has('fashion'))->toBeTrue();
    expect($this->registry->has('electronics'))->toBeTrue();
    expect($this->registry->has('nonexistent'))->toBeFalse();
});

test('registry all returns array of presets', function () {
    $all = $this->registry->all();
    expect($all)->toBeArray();
    expect(count($all))->toBe(8);
    foreach ($all as $preset) {
        expect($preset)->toBeInstanceOf(BusinessPresetContract::class);
    }
});

test('registry toArray returns array of arrays', function () {
    $array = $this->registry->toArray();
    expect($array)->toBeArray();
    expect(count($array))->toBe(8);
    // toArray returns associative array keyed by preset code
    expect($array['fashion'])->toHaveKeys(['code', 'name']);
});

test('each registry preset returns valid theme and template', function () {
    $validThemes = ['minimal-luxury', 'modern-dark', 'colorful'];
    $validTemplates = ['fashion', 'electronics', 'grocery', 'general', 'furniture'];

    foreach ($this->registry->all() as $preset) {
        expect($preset->getRecommendedTheme())->toBeIn($validThemes);
        expect($preset->getRecommendedTemplate())->toBeIn($validTemplates);
    }
});
