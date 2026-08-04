<?php

namespace Webkul\BusinessPreset\Presets;

use Webkul\BusinessPreset\AbstractBusinessPreset;

/**
 * Fashion Store Preset — complete reference implementation.
 *
 * Clothing, accessories, footwear, and jewelry.
 * Attributes: Size, Color, Material, Brand, Season, Fit, Gender
 * Product types: Simple, Configurable, Bundle, Gift Card
 */
class FashionPreset extends AbstractBusinessPreset
{
    protected string $code = 'fashion';

    protected string $name = 'Fashion Store';

    protected ?string $description = 'Clothing, accessories, footwear, and jewelry — a complete fashion retail experience.';

    protected string $recommendedTheme = 'minimal-luxury';

    protected string $recommendedTemplate = 'fashion';

    protected array $productTypes = ['simple', 'configurable', 'bundle'];

    // ─── Categories ──────────────────────────────────────────────

    protected array $defaultCategories = [
        ['name' => 'Women', 'children' => [
            ['name' => 'Dresses'],
            ['name' => 'Tops'],
            ['name' => 'Bottoms'],
            ['name' => 'Outerwear'],
            ['name' => 'Activewear'],
        ]],
        ['name' => 'Men', 'children' => [
            ['name' => 'Shirts'],
            ['name' => 'Pants'],
            ['name' => 'Jackets'],
            ['name' => 'Activewear'],
        ]],
        ['name' => 'Accessories', 'children' => [
            ['name' => 'Bags'],
            ['name' => 'Jewelry'],
            ['name' => 'Watches'],
            ['name' => 'Belts'],
            ['name' => 'Scarves'],
        ]],
        ['name' => 'Shoes', 'children' => [
            ['name' => 'Sneakers'],
            ['name' => 'Boots'],
            ['name' => 'Sandals'],
            ['name' => 'Heels'],
            ['name' => 'Flats'],
        ]],
        ['name' => 'New Arrivals'],
        ['name' => 'Sale'],
    ];

    // ─── Attributes ──────────────────────────────────────────────

    protected array $productAttributes = [
        [
            'code' => 'size',
            'admin_name' => 'Size',
            'type' => 'select',
            'position' => 1,
            'is_required' => 1,
            'is_filterable' => 1,
            'is_configurable' => 1,
            'is_visible_on_front' => 1,
            'options' => [
                ['label' => 'XS'],
                ['label' => 'S'],
                ['label' => 'M'],
                ['label' => 'L'],
                ['label' => 'XL'],
                ['label' => 'XXL'],
                ['label' => '2'],
                ['label' => '4'],
                ['label' => '6'],
                ['label' => '8'],
                ['label' => '10'],
                ['label' => '12'],
                ['label' => '14'],
                ['label' => '16'],
                ['label' => 'One Size'],
            ],
        ],
        [
            'code' => 'color',
            'admin_name' => 'Color',
            'type' => 'select',
            'swatch_type' => 'color',
            'position' => 2,
            'is_required' => 0,
            'is_filterable' => 1,
            'is_configurable' => 1,
            'is_visible_on_front' => 1,
            'options' => [
                ['label' => 'Black', 'swatch_value' => '#000000'],
                ['label' => 'White', 'swatch_value' => '#FFFFFF'],
                ['label' => 'Red', 'swatch_value' => '#FF0000'],
                ['label' => 'Blue', 'swatch_value' => '#0000FF'],
                ['label' => 'Green', 'swatch_value' => '#00AA00'],
                ['label' => 'Yellow', 'swatch_value' => '#FFD700'],
                ['label' => 'Pink', 'swatch_value' => '#FFC0CB'],
                ['label' => 'Purple', 'swatch_value' => '#800080'],
                ['label' => 'Navy', 'swatch_value' => '#000080'],
                ['label' => 'Beige', 'swatch_value' => '#F5F5DC'],
                ['label' => 'Gray', 'swatch_value' => '#808080'],
                ['label' => 'Brown', 'swatch_value' => '#8B4513'],
            ],
        ],
        [
            'code' => 'material',
            'admin_name' => 'Material',
            'type' => 'multiselect',
            'position' => 3,
            'is_required' => 0,
            'is_filterable' => 1,
            'is_visible_on_front' => 1,
            'options' => [
                ['label' => 'Cotton'],
                ['label' => 'Silk'],
                ['label' => 'Leather'],
                ['label' => 'Polyester'],
                ['label' => 'Wool'],
                ['label' => 'Linen'],
                ['label' => 'Cashmere'],
                ['label' => 'Denim'],
                ['label' => 'Velvet'],
                ['label' => 'Lace'],
                ['label' => 'Suede'],
                ['label' => 'Nylon'],
            ],
        ],
        [
            'code' => 'brand',
            'admin_name' => 'Brand',
            'type' => 'select',
            'position' => 4,
            'is_required' => 0,
            'is_filterable' => 1,
            'is_visible_on_front' => 1,
            'options' => [
                ['label' => 'Nike'],
                ['label' => 'Zara'],
                ['label' => 'H&M'],
                ['label' => 'Gucci'],
                ['label' => 'Adidas'],
                ['label' => 'Levi\'s'],
                ['label' => 'Calvin Klein'],
                ['label' => 'Tommy Hilfiger'],
            ],
        ],
        [
            'code' => 'season',
            'admin_name' => 'Season',
            'type' => 'select',
            'position' => 5,
            'is_required' => 0,
            'is_filterable' => 1,
            'is_visible_on_front' => 0,
            'options' => [
                ['label' => 'Spring/Summer'],
                ['label' => 'Autumn/Winter'],
                ['label' => 'Resort'],
                ['label' => 'Year-Round'],
            ],
        ],
        [
            'code' => 'fit',
            'admin_name' => 'Fit',
            'type' => 'select',
            'position' => 6,
            'is_required' => 0,
            'is_filterable' => 0,
            'is_visible_on_front' => 1,
            'options' => [
                ['label' => 'Slim'],
                ['label' => 'Regular'],
                ['label' => 'Oversized'],
                ['label' => 'Petite'],
                ['label' => 'Tall'],
            ],
        ],
        [
            'code' => 'gender',
            'admin_name' => 'Gender',
            'type' => 'select',
            'position' => 7,
            'is_required' => 0,
            'is_filterable' => 1,
            'is_visible_on_front' => 1,
            'options' => [
                ['label' => 'Women'],
                ['label' => 'Men'],
                ['label' => 'Unisex'],
                ['label' => 'Kids'],
            ],
        ],
        [
            'code' => 'care_instructions',
            'admin_name' => 'Care Instructions',
            'type' => 'textarea',
            'position' => 8,
            'is_required' => 0,
            'is_filterable' => 0,
            'is_visible_on_front' => 1,
            'enable_wysiwyg' => 0,
            'options' => [],
        ],
    ];

    // ─── Attribute Family ────────────────────────────────────────

    protected array $attributeFamily = [
        'code' => 'fashion',
        'name' => 'Fashion',
        'groups' => [
            [
                'code' => 'fashion_general',
                'name' => 'General',
                'column' => 1,
                'attributes' => ['sku', 'name', 'url_key', 'brand'],
            ],
            [
                'code' => 'fashion_sizing',
                'name' => 'Size & Fit',
                'column' => 1,
                'attributes' => ['size', 'color', 'fit', 'gender'],
            ],
            [
                'code' => 'fashion_details',
                'name' => 'Product Details',
                'column' => 1,
                'attributes' => ['material', 'season', 'care_instructions'],
            ],
            [
                'code' => 'fashion_description',
                'name' => 'Description',
                'column' => 2,
                'attributes' => ['description', 'short_description'],
            ],
            [
                'code' => 'fashion_price',
                'name' => 'Price',
                'column' => 2,
                'attributes' => ['price', 'cost', 'special_price'],
            ],
            [
                'code' => 'fashion_shipping',
                'name' => 'Shipping',
                'column' => 2,
                'attributes' => ['weight', 'width', 'height', 'depth'],
            ],
        ],
    ];

    // ─── Email Templates ─────────────────────────────────────────

    protected array $emailTemplates = [
        [
            'code' => 'fashion_order_confirmation',
            'name' => 'Order Confirmation',
            'subject' => 'Your {store_name} Order #{order_id} is Confirmed!',
            'content' => '<h1>Thank You for Your Order!</h1><p>Your fashion order #{order_id} has been confirmed and is being prepared.</p>',
        ],
        [
            'code' => 'fashion_shipping_confirmation',
            'name' => 'Shipping Confirmation',
            'subject' => 'Your {store_name} Order #{order_id} is On Its Way!',
            'content' => '<h1>Your Style is On Its Way!</h1><p>Order #{order_id} has been shipped. Track it here: {tracking_url}</p>',
        ],
        [
            'code' => 'fashion_back_in_stock',
            'name' => 'Back in Stock',
            'subject' => '{product_name} is Back in Stock — {size}/{color}',
            'content' => '<h1>It\'s Back!</h1><p>{product_name} in {size}/{color} is back in stock. Get it before it\'s gone!</p>',
        ],
        [
            'code' => 'fashion_new_collection',
            'name' => 'New Collection Alert',
            'subject' => 'The New Collection Has Arrived at {store_name}',
            'content' => '<h1>New Season, New Style</h1><p>Explore our latest collection — handpicked just for you.</p>',
        ],
    ];

    // ─── Widgets ─────────────────────────────────────────────────

    protected array $widgets = [
        [
            'type' => 'category_filter',
            'name' => 'Size Filter',
            'position' => 'sidebar',
            'config' => ['attribute' => 'size', 'display' => 'checkboxes'],
        ],
        [
            'type' => 'category_filter',
            'name' => 'Color Filter',
            'position' => 'sidebar',
            'config' => ['attribute' => 'color', 'display' => 'swatches'],
        ],
        [
            'type' => 'category_filter',
            'name' => 'Price Range',
            'position' => 'sidebar',
            'config' => ['display' => 'range_slider'],
        ],
        [
            'type' => 'category_filter',
            'name' => 'Brand Filter',
            'position' => 'sidebar',
            'config' => ['attribute' => 'brand', 'display' => 'checkboxes'],
        ],
        [
            'type' => 'new_arrivals',
            'name' => 'New Arrivals',
            'position' => 'homepage',
            'config' => ['limit' => 8, 'auto_tag' => true],
        ],
        [
            'type' => 'trending',
            'name' => 'Trending Now',
            'position' => 'homepage',
            'config' => ['limit' => 6, 'based_on' => 'views'],
        ],
        [
            'type' => 'newsletter',
            'name' => 'Newsletter Signup',
            'position' => 'footer',
            'config' => ['incentive' => '10% off your first order'],
        ],
        [
            'type' => 'social_feed',
            'name' => 'Instagram Shop',
            'position' => 'homepage',
            'config' => ['platform' => 'instagram', 'limit' => 6],
        ],
    ];

    // ─── Banners ─────────────────────────────────────────────────

    protected array $banners = [
        [
            'title' => 'New Season Collection',
            'subtitle' => 'Discover the latest trends',
            'position' => 'homepage',
            'link_url' => '/new-arrivals',
        ],
        [
            'title' => 'Summer Sale',
            'subtitle' => 'Up to 50% off selected styles',
            'position' => 'homepage',
            'link_url' => '/sale',
        ],
        [
            'title' => 'Free Shipping',
            'subtitle' => 'On orders over $100',
            'position' => 'top_bar',
            'link_url' => null,
        ],
    ];

    // ─── Roles ───────────────────────────────────────────────────

    protected array $roles = [
        [
            'name' => 'Fashion Store Manager',
            'slug' => 'fashion_manager',
            'description' => 'Manages the fashion store: products, collections, and lookbook.',
            'permission_type' => 'custom',
            'permissions' => [
                'admin.catalog.products.create',
                'admin.catalog.products.edit',
                'admin.catalog.products.delete',
                'admin.catalog.categories.create',
                'admin.catalog.categories.edit',
                'admin.catalog.categories.delete',
                'admin.catalog.attributes.create',
                'admin.catalog.attributes.edit',
                'admin.marketing.promotions.create',
                'admin.marketing.promotions.edit',
                'admin.sales.orders.view',
                'admin.sales.invoices.view',
                'admin.sales.shipments.view',
                'admin.customers.customers.view',
                'admin.customers.reviews.view',
                'admin.cms.create',
                'admin.cms.edit',
                'admin.cms.delete',
                'admin.reporting.view',
            ],
        ],
        [
            'name' => 'Fashion Content Editor',
            'slug' => 'fashion_editor',
            'description' => 'Manages lookbook, style guides, and fashion content.',
            'permission_type' => 'custom',
            'permissions' => [
                'admin.cms.create',
                'admin.cms.edit',
                'admin.cms.delete',
                'admin.catalog.products.edit',
                'admin.catalog.categories.edit',
            ],
        ],
    ];

    // ─── Settings ────────────────────────────────────────────────

    protected array $recommendedSettings = [
        'general.design.admin_logo.theme' => 'minimal-luxury',
        'general.design.shop.template' => 'fashion',
        'catalog.products.homepage.out_of_stock_items' => '0',
        'catalog.products.review.enable' => '1',
        'catalog.products.guest_checkout.wishlist' => '1',
        'customer.settings.wishlist.enable' => '1',
        'customer.settings.newsletter.subscription' => '1',
        'sales.checkout.shopping_cart.mini_cart' => '1',
        'general.content.shop.footer.toggle' => '1',
    ];

    // ─── Pages ───────────────────────────────────────────────────

    protected array $defaultPages = [
        [
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => '<h1>About Our Store</h1><p>We curate the finest fashion from around the world, bringing you timeless style and contemporary trends.</p>',
        ],
        [
            'title' => 'Size Guide',
            'slug' => 'size-guide',
            'content' => '<h1>Size Guide</h1><p>Find your perfect fit with our comprehensive size guide.</p><table><tr><th>Size</th><th>Bust (cm)</th><th>Waist (cm)</th><th>Hips (cm)</th></tr><tr><td>XS</td><td>80-84</td><td>62-66</td><td>88-92</td></tr><tr><td>S</td><td>84-88</td><td>66-70</td><td>92-96</td></tr><tr><td>M</td><td>88-92</td><td>70-74</td><td>96-100</td></tr><tr><td>L</td><td>92-96</td><td>74-78</td><td>100-104</td></tr><tr><td>XL</td><td>96-100</td><td>78-82</td><td>104-108</td></tr></table>',
        ],
        [
            'title' => 'Lookbook',
            'slug' => 'lookbook',
            'content' => '<h1>Lookbook</h1><p>Explore our seasonal lookbook — curated styles for every occasion.</p>',
        ],
        [
            'title' => 'Sustainability',
            'slug' => 'sustainability',
            'content' => '<h1>Our Commitment to Sustainability</h1><p>We believe fashion should be beautiful AND responsible. Learn about our sustainable practices, ethical sourcing, and commitment to reducing our environmental footprint.</p>',
        ],
        [
            'title' => 'Shipping & Returns',
            'slug' => 'shipping-returns',
            'content' => '<h1>Shipping & Returns</h1><h2>Shipping</h2><p>Free standard shipping on orders over $100. Express delivery available.</p><h2>Returns</h2><p>Free returns within 30 days. Items must be unworn with tags attached.</p>',
        ],
    ];

    // ─── Navigation ──────────────────────────────────────────────

    protected array $navigation = [
        ['label' => 'New In', 'url' => '/new', 'position' => 'header'],
        ['label' => 'Women', 'url' => '/women', 'position' => 'header'],
        ['label' => 'Men', 'url' => '/men', 'position' => 'header'],
        ['label' => 'Accessories', 'url' => '/accessories', 'position' => 'header'],
        ['label' => 'Shoes', 'url' => '/shoes', 'position' => 'header'],
        ['label' => 'Sale', 'url' => '/sale', 'position' => 'header', 'highlight' => true],
        ['label' => 'About', 'url' => '/about-us', 'position' => 'footer'],
        ['label' => 'Size Guide', 'url' => '/size-guide', 'position' => 'footer'],
        ['label' => 'Shipping & Returns', 'url' => '/shipping-returns', 'position' => 'footer'],
        ['label' => 'Sustainability', 'url' => '/sustainability', 'position' => 'footer'],
        ['label' => 'Contact', 'url' => '/contact-us', 'position' => 'footer'],
    ];
}
