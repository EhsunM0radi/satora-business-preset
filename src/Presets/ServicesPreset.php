<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class ServicesPreset extends AbstractBusinessPreset
{
    protected string $code = 'services';

    protected string $name = 'Services Business';

    protected ?string $description = 'Booking, appointments, subscriptions, and service packages — sell services, not just products.';

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'general';

    protected array $defaultCategories = [
        ['name' => 'Consulting'],
        ['name' => 'Design Services'],
        ['name' => 'Development'],
        ['name' => 'Marketing'],
        ['name' => 'Writing'],
        ['name' => 'Training'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'minimal-luxury',
        'general.design.shop.template' => 'general',
        'catalog.products.review.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Our Services', 'slug' => 'services'],
        ['title' => 'Portfolio', 'slug' => 'portfolio'],
        ['title' => 'Book a Call', 'slug' => 'book'],
    ];

    protected array $navigation = [
        ['label' => 'Services', 'url' => '/services', 'position' => 'header'],
        ['label' => 'Portfolio', 'url' => '/portfolio', 'position' => 'header'],
        ['label' => 'Pricing', 'url' => '/pricing', 'position' => 'header'],
        ['label' => 'Book Now', 'url' => '/book', 'position' => 'header', 'highlight' => true],
    ];
}
