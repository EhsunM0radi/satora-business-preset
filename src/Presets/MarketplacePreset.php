<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

class MarketplacePreset extends AbstractBusinessPreset
{
    protected string $code = 'marketplace';

    protected string $name = 'Marketplace';

    protected ?string $description = 'Multi-vendor platform — sellers create their own stores, you manage the platform.';

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'general';

    protected array $defaultCategories = [
        ['name' => 'Fashion'],
        ['name' => 'Electronics'],
        ['name' => 'Home & Garden'],
        ['name' => 'Sports'],
        ['name' => 'Books'],
        ['name' => 'Toys'],
        ['name' => 'Food'],
    ];

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'minimal-luxury',
        'general.design.shop.template' => 'general',
        'catalog.products.review.enable' => '1',
        'customer.settings.wishlist.enable' => '1',
    ];

    protected array $defaultPages = [
        ['title' => 'About Us', 'slug' => 'about-us'],
        ['title' => 'Sell With Us', 'slug' => 'sell'],
        ['title' => 'Buyer Protection', 'slug' => 'protection'],
        ['title' => 'Help Center', 'slug' => 'help'],
    ];

    protected array $navigation = [
        ['label' => 'Categories', 'url' => '/categories', 'position' => 'header'],
        ['label' => 'Deals', 'url' => '/deals', 'position' => 'header'],
        ['label' => 'Sell', 'url' => '/sell', 'position' => 'header'],
        ['label' => 'Help', 'url' => '/help', 'position' => 'header'],
    ];
}
