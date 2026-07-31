<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class GroceryPreset extends AbstractBusinessPreset
{
    protected string $code = 'grocery';

    protected string $name = 'Grocery Store';

    protected ?string $description = 'Fresh produce, dairy, bakery, and pantry essentials — your neighborhood supermarket online.';

    protected string $recommendedTheme = 'colorful';

    protected string $recommendedTemplate = 'grocery';

    protected array $defaultCategories = [
        ['name' => 'Fruits & Vegetables'],
        ['name' => 'Dairy & Eggs'],
        ['name' => 'Meat & Seafood'],
        ['name' => 'Bakery'],
        ['name' => 'Beverages'],
        ['name' => 'Pantry'],
        ['name' => 'Snacks'],
        ['name' => 'Household'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'colorful',
        'general.design.shop.template' => 'grocery',
        'catalog.products.homepage.out_of_stock_items' => '1',
        'customer.settings.wishlist.enable' => '1',
        'catalog.products.review.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Delivery Info', 'slug' => 'delivery'],
        ['title' => 'Recipes', 'slug' => 'recipes'],
        ['title' => 'Weekly Deals', 'slug' => 'deals'],
    ];

    protected array $navigation = [
        ['label' => 'Fruits & Veg', 'url' => '/fruits-vegetables', 'position' => 'header'],
        ['label' => 'Dairy', 'url' => '/dairy-eggs', 'position' => 'header'],
        ['label' => 'Meat', 'url' => '/meat-seafood', 'position' => 'header'],
        ['label' => 'Bakery', 'url' => '/bakery', 'position' => 'header'],
        ['label' => 'Offers', 'url' => '/offers', 'position' => 'header', 'highlight' => true],
    ];
}
