<?php

namespace Webkul\BusinessPreset\Helpers;

use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;

/**
 * Preset Registry — resolves and provides all available business presets.
 */
class PresetRegistry
{
    protected array $presets = [];

    /**
     * Register a preset class.
     */
    public function register(string $presetClass): void
    {
        $preset = app($presetClass);

        if ($preset instanceof BusinessPresetContract) {
            $this->presets[$preset->getCode()] = $preset;
        }
    }

    /**
     * Register multiple presets.
     */
    public function registerMany(array $presetClasses): void
    {
        foreach ($presetClasses as $class) {
            $this->register($class);
        }
    }

    /**
     * Get all registered presets.
     */
    public function all(): array
    {
        return $this->presets;
    }

    /**
     * Get a preset by code.
     */
    public function get(string $code): ?BusinessPresetContract
    {
        return $this->presets[$code] ?? null;
    }

    /**
     * Check if a preset exists.
     */
    public function has(string $code): bool
    {
        return isset($this->presets[$code]);
    }

    /**
     * Get all presets as arrays.
     */
    public function toArray(): array
    {
        return array_map(fn ($preset) => $preset->toArray(), $this->presets);
    }

    /**
     * Get count of registered presets.
     */
    public function count(): int
    {
        return count($this->presets);
    }
}
