<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class FashionPreset extends AbstractBusinessPreset
{
    protected string $code = 'fashion';

    protected string $name = 'Fashion Store';

    protected ?string $description = 'Clothing, accessories, footwear, and jewelry — a complete fashion retail experience.';

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'fashion';

    protected array $defaultCategories = [
        ['name' => 'Women', 'children' => [
            ['name' => 'Dresses'],
            ['name' => 'Tops'],
            ['name' => 'Bottoms'],
            ['name' => 'Outerwear'],
        ]],
        ['name' => 'Men', 'children' => [
            ['name' => 'Shirts'],
            ['name' => 'Pants'],
            ['name' => 'Jackets'],
        ]],
        ['name' => 'Accessories', 'children' => [
            ['name' => 'Bags'],
            ['name' => 'Jewelry'],
            ['name' => 'Watches'],
        ]],
        ['name' => 'Shoes'],
        ['name' => 'New Arrivals'],
        ['name' => 'Sale'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'minimal-luxury',
        'general.design.shop.template' => 'fashion',
        'catalog.products.homepage.out_of_stock_items' => '0',
        'catalog.products.review.enable' => '1',
        'customer.settings.wishlist.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Size Guide', 'slug' => 'size-guide'],
        ['title' => 'Lookbook', 'slug' => 'lookbook'],
        ['title' => 'Sustainability', 'slug' => 'sustainability'],
    ];

    protected array $navigation = [
        ['label' => 'New In', 'url' => '/new', 'position' => 'header'],
        ['label' => 'Women', 'url' => '/women', 'position' => 'header'],
        ['label' => 'Men', 'url' => '/men', 'position' => 'header'],
        ['label' => 'Accessories', 'url' => '/accessories', 'position' => 'header'],
        ['label' => 'Sale', 'url' => '/sale', 'position' => 'header', 'highlight' => true],
    ];
}
