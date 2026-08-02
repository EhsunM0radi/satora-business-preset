<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class DiversePreset extends AbstractBusinessPreset
{
    protected string $code = 'diverse';

    protected string $name = 'Diverse / Other';

    protected ?string $description = 'Something not listed above — start from scratch and customize everything.';

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'general';

    protected array $defaultCategories = [
        ['name' => 'Category 1'],
        ['name' => 'Category 2'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'minimal-luxury',
        'general.design.shop.template' => 'general',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Contact Us', 'slug' => 'contact-us'],
    ];

    protected array $navigation = [
        ['label' => 'Shop', 'url' => '/shop', 'position' => 'header'],
        ['label' => 'About', 'url' => '/about-us', 'position' => 'header'],
        ['label' => 'Contact', 'url' => '/contact-us', 'position' => 'header'],
    ];
}
