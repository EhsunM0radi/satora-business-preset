<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class RestaurantPreset extends AbstractBusinessPreset
{
    protected string $code = 'restaurant';

    protected string $name = 'Restaurant / Food Delivery';

    protected ?string $description = 'Online ordering, menu management, and delivery — everything for a food business.';

    protected string $recommendedTheme = 'colorful';

    protected string $recommendedTemplate = 'grocery';

    protected array $defaultCategories = [
        ['name' => 'Appetizers'],
        ['name' => 'Main Course'],
        ['name' => 'Desserts'],
        ['name' => 'Beverages'],
        ['name' => 'Combos'],
        ['name' => 'Specials'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'colorful',
        'general.design.shop.template' => 'grocery',
        'catalog.products.review.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Menu', 'slug' => 'menu'],
        ['title' => 'Delivery Areas', 'slug' => 'delivery'],
        ['title' => 'Catering', 'slug' => 'catering'],
    ];

    protected array $navigation = [
        ['label' => 'Menu', 'url' => '/menu', 'position' => 'header'],
        ['label' => 'Specials', 'url' => '/specials', 'position' => 'header'],
        ['label' => 'Combos', 'url' => '/combos', 'position' => 'header'],
        ['label' => 'Order Now', 'url' => '/order', 'position' => 'header', 'highlight' => true],
    ];
}
