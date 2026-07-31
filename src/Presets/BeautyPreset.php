<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class BeautyPreset extends AbstractBusinessPreset
{
    protected string $code = 'beauty';

    protected string $name = 'Beauty & Cosmetics';

    protected ?string $description = 'Skincare, makeup, fragrance, and wellness — a luxurious beauty destination.';

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'fashion';

    protected array $defaultCategories = [
        ['name' => 'Skincare', 'children' => [
            ['name' => 'Cleansers'],
            ['name' => 'Moisturizers'],
            ['name' => 'Serums'],
            ['name' => 'Sunscreen'],
        ]],
        ['name' => 'Makeup', 'children' => [
            ['name' => 'Face'],
            ['name' => 'Eyes'],
            ['name' => 'Lips'],
        ]],
        ['name' => 'Fragrance'],
        ['name' => 'Hair Care'],
        ['name' => 'Bath & Body'],
        ['name' => 'New Arrivals'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'minimal-luxury',
        'general.design.shop.template' => 'fashion',
        'catalog.products.review.enable' => '1',
        'customer.settings.wishlist.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Beauty Blog', 'slug' => 'blog'],
        ['title' => 'Ingredients Guide', 'slug' => 'ingredients'],
    ];

    protected array $navigation = [
        ['label' => 'Skincare', 'url' => '/skincare', 'position' => 'header'],
        ['label' => 'Makeup', 'url' => '/makeup', 'position' => 'header'],
        ['label' => 'Fragrance', 'url' => '/fragrance', 'position' => 'header'],
        ['label' => 'Hair', 'url' => '/hair-care', 'position' => 'header'],
        ['label' => 'New', 'url' => '/new', 'position' => 'header', 'highlight' => true],
    ];
}
