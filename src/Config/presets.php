<?php

use Webkul\BusinessPreset\Presets\BeautyPreset;
use Webkul\BusinessPreset\Presets\CustomPreset;
use Webkul\BusinessPreset\Presets\DigitalPreset;
use Webkul\BusinessPreset\Presets\ElectronicsPreset;
use Webkul\BusinessPreset\Presets\FashionPreset;
use Webkul\BusinessPreset\Presets\FurniturePreset;
use Webkul\BusinessPreset\Presets\GroceryPreset;
use Webkul\BusinessPreset\Presets\MarketplacePreset;

return [
    'default_preset' => env('SATORA_DEFAULT_PRESET', 'custom'),

    'presets' => [
        FashionPreset::class,
        ElectronicsPreset::class,
        GroceryPreset::class,
        BeautyPreset::class,
        DigitalPreset::class,
        FurniturePreset::class,
        MarketplacePreset::class,
        CustomPreset::class,
    ],

    'icons' => [
        'fashion' => '👗',
        'electronics' => '📱',
        'grocery' => '🛒',
        'beauty' => '💄',
        'digital' => '💻',
        'furniture' => '🪑',
        'marketplace' => '🏪',
        'custom' => '✨',
    ],
];
