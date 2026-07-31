<?php

use Webkul\BusinessPreset\Presets\BeautyPreset;
use Webkul\BusinessPreset\Presets\CustomPreset;
use Webkul\BusinessPreset\Presets\DigitalPreset;
use Webkul\BusinessPreset\Presets\ElectronicsPreset;
use Webkul\BusinessPreset\Presets\FashionPreset;
use Webkul\BusinessPreset\Presets\GroceryPreset;
use Webkul\BusinessPreset\Presets\MarketplacePreset;
use Webkul\BusinessPreset\Presets\RestaurantPreset;
use Webkul\BusinessPreset\Presets\ServicesPreset;

return [

    /*
    |--------------------------------------------------------------------------
    | Business Presets Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Satora Business Preset system.
    | Presets define a complete store setup including default categories,
    | pages, navigation, recommended theme/template, and settings.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    */
    'default_preset' => env('SATORA_DEFAULT_PRESET', 'custom'),

    /*
    |--------------------------------------------------------------------------
    | Available Presets
    |--------------------------------------------------------------------------
    |
    | List of preset classes that will be registered. You can add custom
    | presets here. Each class must extend AbstractBusinessPreset.
    |
    */
    'presets' => [
        FashionPreset::class,
        ElectronicsPreset::class,
        GroceryPreset::class,
        BeautyPreset::class,
        RestaurantPreset::class,
        DigitalPreset::class,
        MarketplacePreset::class,
        ServicesPreset::class,
        CustomPreset::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Preset Icons
    |--------------------------------------------------------------------------
    |
    | Icon mapping for presets (used in the installer UI).
    | Values can be emoji, SVG paths, or icon class names.
    |
    */
    'icons' => [
        'fashion' => '👗',
        'electronics' => '📱',
        'grocery' => '🛒',
        'beauty' => '💄',
        'restaurant' => '🍽️',
        'digital' => '💻',
        'marketplace' => '🏪',
        'services' => '🛠️',
        'custom' => '✨',
    ],
];
