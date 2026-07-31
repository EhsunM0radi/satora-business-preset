<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class DigitalPreset extends AbstractBusinessPreset
{
    protected string $code = 'digital';

    protected string $name = 'Digital Products';

    protected ?string $description = 'Software, ebooks, courses, music, and digital downloads — instant delivery after purchase.';

    protected string $recommendedTheme = 'modern-dark';

    protected string $recommendedTemplate = 'electronics';

    protected array $defaultCategories = [
        ['name' => 'Software'],
        ['name' => 'Ebooks'],
        ['name' => 'Online Courses'],
        ['name' => 'Music'],
        ['name' => 'Templates'],
        ['name' => 'Graphics'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'modern-dark',
        'general.design.shop.template' => 'electronics',
        'catalog.products.review.enable' => '1',
        'catalog.products.homepage.out_of_stock_items' => '0',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'How It Works', 'slug' => 'how-it-works'],
        ['title' => 'License Info', 'slug' => 'licenses'],
    ];

    protected array $navigation = [
        ['label' => 'Software', 'url' => '/software', 'position' => 'header'],
        ['label' => 'Courses', 'url' => '/courses', 'position' => 'header'],
        ['label' => 'Books', 'url' => '/ebooks', 'position' => 'header'],
        ['label' => 'Freebies', 'url' => '/free', 'position' => 'header', 'highlight' => true],
    ];
}
