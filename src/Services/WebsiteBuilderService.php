<?php

namespace Webkul\BusinessPreset\Services;

use Webkul\BusinessPreset\Contracts\BusinessPreset as BusinessPresetContract;
use Webkul\BusinessPreset\Helpers\PresetRegistry;

/**
 * AI-ready service for recommending themes, templates, and homepage layouts
 * based on business characteristics.
 *
 * Input: business type, brand name, industry, preferred style, colors
 * Output: recommended theme, template, homepage sections, CMS content
 *
 * This is the architecture layer — LLM integration plugs in later.
 */
class WebsiteBuilderService
{
    public function __construct(protected PresetRegistry $registry) {}

    /**
     * Generate recommendations based on business profile.
     */
    public function recommend(array $profile): array
    {
        $businessType = $profile['business_type'] ?? null;
        $preferredStyle = $profile['preferred_style'] ?? null;

        // Get the matching preset
        $preset = $businessType ? $this->registry->get($businessType) : null;

        return [
            'preset' => $preset?->toArray(),
            'recommended_theme' => $this->recommendTheme($preset, $preferredStyle),
            'recommended_template' => $preset?->getRecommendedTemplate() ?? 'general',
            'homepage_sections' => $this->recommendSections($preset, $profile),
            'color_suggestions' => $this->recommendColors($profile),
            'content_structure' => $this->recommendContent($profile),
        ];
    }

    /**
     * Recommend a theme based on preset and style preference.
     */
    protected function recommendTheme(?BusinessPresetContract $preset, ?string $preferredStyle): string
    {
        if ($preset) {
            return $preset->getRecommendedTheme();
        }

        // Style-based fallback
        return match ($preferredStyle) {
            'dark', 'modern', 'tech' => 'modern-dark',
            'vibrant', 'playful', 'colorful' => 'colorful',
            default => 'minimal-luxury',
        };
    }

    /**
     * Recommend homepage sections based on business profile.
     */
    protected function recommendSections(?BusinessPresetContract $preset, array $profile): array
    {
        $base = [
            'hero-banner',
            'featured-products',
            'category-grid',
            'newsletter',
        ];

        $industry = $profile['industry'] ?? '';

        $industryAddons = match (true) {
            str_contains($industry, 'fashion') => ['lookbook', 'instagram-gallery', 'trending-now'],
            str_contains($industry, 'tech') || str_contains($industry, 'electronic') => ['comparison-section', 'brand-showcase'],
            str_contains($industry, 'food') || str_contains($industry, 'grocery') => ['daily-deals', 'recipe-inspiration'],
            default => ['testimonials', 'brand-showcase'],
        };

        return array_merge($base, $industryAddons);
    }

    /**
     * Suggest color palette based on profile.
     */
    protected function recommendColors(array $profile): array
    {
        $industry = $profile['industry'] ?? '';

        return match (true) {
            str_contains($industry, 'fashion') || str_contains($industry, 'beauty') => [
                'primary' => '#1a1a2e', 'accent' => '#e94560',
            ],
            str_contains($industry, 'tech') || str_contains($industry, 'electronic') => [
                'primary' => '#6366f1', 'accent' => '#06b6d4',
            ],
            str_contains($industry, 'food') || str_contains($industry, 'grocery') => [
                'primary' => '#ff6b6b', 'accent' => '#feca57',
            ],
            default => ['primary' => '#1a1a2e', 'accent' => '#0f3460'],
        };
    }

    /**
     * Recommend CMS content structure.
     */
    protected function recommendContent(array $profile): array
    {
        $brandName = $profile['brand_name'] ?? 'My Store';

        return [
            'hero' => [
                'title' => "Welcome to {$brandName}",
                'subtitle' => 'Discover our collection',
                'cta_text' => 'Shop Now',
                'cta_url' => '/shop',
            ],
            'about' => [
                'title' => "About {$brandName}",
                'body' => "{$brandName} is your destination for quality products and exceptional service.",
            ],
            'pages' => [
                ['title' => 'About Us', 'slug' => 'about-us'],
                ['title' => 'Contact', 'slug' => 'contact-us'],
                ['title' => 'FAQ', 'slug' => 'faq'],
            ],
        ];
    }
}
