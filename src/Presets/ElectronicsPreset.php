<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class ElectronicsPreset extends AbstractBusinessPreset
{
    protected string $code = 'electronics';

    protected string $name = 'Electronics Store';

    protected ?string $description = 'Smartphones, laptops, gadgets, and accessories — a modern tech retail store.';

    protected string $recommendedTheme = 'modern-dark';

    protected string $recommendedTemplate = 'electronics';

    protected array $defaultCategories = [
        ['name' => 'Smartphones', 'children' => [
            ['name' => 'Android'],
            ['name' => 'iPhone'],
            ['name' => 'Accessories'],
        ]],
        ['name' => 'Laptops', 'children' => [
            ['name' => 'Gaming'],
            ['name' => 'Ultrabooks'],
            ['name' => 'Business'],
        ]],
        ['name' => 'Audio', 'children' => [
            ['name' => 'Headphones'],
            ['name' => 'Speakers'],
            ['name' => 'Earbuds'],
        ]],
        ['name' => 'Wearables'],
        ['name' => 'Gaming'],
        ['name' => 'Deals'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'modern-dark',
        'general.design.shop.template' => 'electronics',
        'catalog.products.homepage.out_of_stock_items' => '0',
        'catalog.products.compare.enable' => '1',
        'catalog.products.review.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Tech Blog', 'slug' => 'blog'],
        ['title' => 'Compare Products', 'slug' => 'compare'],
        ['title' => 'Warranty Info', 'slug' => 'warranty'],
    ];

    protected array $navigation = [
        ['label' => 'Smartphones', 'url' => '/smartphones', 'position' => 'header'],
        ['label' => 'Laptops', 'url' => '/laptops', 'position' => 'header'],
        ['label' => 'Audio', 'url' => '/audio', 'position' => 'header'],
        ['label' => 'Gaming', 'url' => '/gaming', 'position' => 'header'],
        ['label' => 'Deals', 'url' => '/deals', 'position' => 'header', 'highlight' => true],
    ];
}
