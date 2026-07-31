<?php

namespace Webkul\BusinessPreset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\BusinessPreset\Helpers\PresetRegistry;

class BusinessPresetSeeder extends Seeder
{
    public function run(): void
    {
        $registry = app(PresetRegistry::class);

        $index = 1;
        foreach ($registry->all() as $preset) {
            DB::table('satora_business_presets')->updateOrInsert(
                ['code' => $preset->getCode()],
                [
                    'name' => $preset->getName(),
                    'description' => $preset->getDescription(),
                    'recommended_theme' => $preset->getRecommendedTheme(),
                    'recommended_template' => $preset->getRecommendedTemplate(),
                    'default_categories' => json_encode($preset->getDefaultCategories()),
                    'recommended_settings' => json_encode($preset->getRecommendedSettings()),
                    'default_pages' => json_encode($preset->getDefaultPages()),
                    'navigation' => json_encode($preset->getNavigation()),
                    'is_active' => true,
                    'sort_order' => $index,
                    'updated_at' => now(),
                ]
            );
            $index++;
        }
    }
}
