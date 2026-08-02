<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class FurniturePreset extends AbstractBusinessPreset
{
    protected string $code = 'furniture';

    protected string $name = 'مبلمان و دکوراسیون';

    protected ?string $description = 'مبلمان، دکوراسیون داخلی، لوازم چوبی و وسایل خانه';

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'furniture';

    protected array $defaultCategories = [
        ['name' => 'مبلمان', 'children' => [
            ['name' => 'مبلمان راحتی'],
            ['name' => 'مبلمان اداری'],
            ['name' => 'مبلمان کلاسیک'],
        ]],
        ['name' => 'دکوراسیون', 'children' => [
            ['name' => 'لوستر و آباژور'],
            ['name' => 'تابلو و دیوارکوب'],
            ['name' => 'گلدان و دکوری'],
        ]],
        ['name' => 'اتاق خواب'],
        ['name' => 'آشپزخانه'],
        ['name' => 'محصولات چوبی'],
        ['name' => 'تخفیف‌ها'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'minimal-luxury',
        'general.design.shop.template' => 'furniture',
        'catalog.products.homepage.out_of_stock_items' => '0',
        'catalog.products.review.enable' => '1',
        'customer.settings.wishlist.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'درباره ما', 'slug' => 'about-us'],
        ['title' => 'راهنمای خرید', 'slug' => 'buying-guide'],
        ['title' => 'گالری طرح‌ها', 'slug' => 'gallery'],
        ['title' => 'مشاوره رایگان', 'slug' => 'consultation'],
    ];

    protected array $navigation = [
        ['label' => 'مبلمان', 'url' => '/furniture', 'position' => 'header'],
        ['label' => 'دکوراسیون', 'url' => '/decor', 'position' => 'header'],
        ['label' => 'اتاق خواب', 'url' => '/bedroom', 'position' => 'header'],
        ['label' => 'جدیدترین‌ها', 'url' => '/new', 'position' => 'header', 'highlight' => true],
    ];
}
