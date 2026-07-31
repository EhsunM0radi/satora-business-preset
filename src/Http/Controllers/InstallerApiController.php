<?php

namespace Webkul\BusinessPreset\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Webkul\BusinessPreset\Helpers\PresetRegistry;
use Webkul\ThemeManager\Repositories\TemplateRepository;
use Webkul\ThemeManager\Repositories\ThemeRepository;

class InstallerApiController
{
    /**
     * Get all available business presets.
     */
    public function presets(PresetRegistry $registry): JsonResponse
    {
        $locale = request()->get('locale', 'en');

        $presets = array_map(function ($preset) use ($locale) {
            $data = $preset->toArray();

            // Try to get localized name/description
            $data['name'] = trans("business_preset::app.presets.{$preset->getCode()}", [], $locale) ?: $preset->getName();
            $data['description'] = trans("business_preset::app.descriptions.{$preset->getCode()}", [], $locale) ?: $preset->getDescription();
            $data['icon'] = config("business_presets.icons.{$preset->getCode()}", '✨');

            return $data;
        }, $registry->all());

        return response()->json(['data' => array_values($presets)]);
    }

    /**
     * Get all available themes.
     */
    public function themes(ThemeRepository $themeRepository): JsonResponse
    {
        $themes = $themeRepository->getActiveThemes();

        $data = $themes->map(fn ($theme) => $theme->toArray());

        return response()->json(['data' => $data]);
    }

    /**
     * Get all available templates.
     */
    public function templates(TemplateRepository $templateRepository): JsonResponse
    {
        $templates = $templateRepository->getActiveTemplates();

        $data = $templates->map(fn ($template) => $template->toArray());

        return response()->json(['data' => $data]);
    }

    /**
     * Get compatible themes for a template.
     */
    public function compatibleThemes(string $templateCode, ThemeRepository $themeRepository): JsonResponse
    {
        $themes = $themeRepository->getCompatibleWithTemplate($templateCode);

        return response()->json(['data' => $themes->map(fn ($t) => $t->toArray())]);
    }

    /**
     * Get compatible templates for a theme.
     */
    public function compatibleTemplates(string $themeCode, TemplateRepository $templateRepository): JsonResponse
    {
        $templates = $templateRepository->getCompatibleWithTheme($themeCode);

        return response()->json(['data' => $templates->map(fn ($t) => $t->toArray())]);
    }
}
