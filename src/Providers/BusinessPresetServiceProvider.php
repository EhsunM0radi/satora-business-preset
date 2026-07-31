<?php

namespace Webkul\BusinessPreset\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\BusinessPreset\Helpers\PresetRegistry;
use Webkul\BusinessPreset\Http\Controllers\InstallerApiController;
use Webkul\BusinessPreset\Presets\BeautyPreset;
use Webkul\BusinessPreset\Presets\CustomPreset;
use Webkul\BusinessPreset\Presets\DigitalPreset;
use Webkul\BusinessPreset\Presets\ElectronicsPreset;
use Webkul\BusinessPreset\Presets\FashionPreset;
use Webkul\BusinessPreset\Presets\GroceryPreset;
use Webkul\BusinessPreset\Presets\MarketplacePreset;
use Webkul\BusinessPreset\Presets\RestaurantPreset;
use Webkul\BusinessPreset\Presets\ServicesPreset;

class BusinessPresetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/presets.php', 'business_presets'
        );

        $this->app->singleton(PresetRegistry::class, function () {
            $registry = new PresetRegistry;

            $registry->registerMany([
                FashionPreset::class,
                ElectronicsPreset::class,
                GroceryPreset::class,
                BeautyPreset::class,
                RestaurantPreset::class,
                DigitalPreset::class,
                MarketplacePreset::class,
                ServicesPreset::class,
                CustomPreset::class,
            ]);

            return $registry;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(dirname(__DIR__).'/Database/Migrations');

        $this->loadTranslationsFrom(
            dirname(__DIR__).'/Resources/lang', 'business_preset'
        );

        $this->publishes([
            dirname(__DIR__).'/Config/presets.php' => config_path('business_presets.php'),
        ], 'business-preset-config');

        $this->publishes([
            dirname(__DIR__).'/Resources/lang' => resource_path('lang/vendor/business_preset'),
        ], 'business-preset-lang');

        $this->registerInstallerApiRoutes();
    }

    /**
     * Register installer API routes for preset/theme/template selection.
     */
    protected function registerInstallerApiRoutes(): void
    {
        Route::prefix('install/api/satora')
            ->middleware(['web', 'installer_file_session', 'installer_locale'])
            ->group(function () {
                Route::get('presets', [InstallerApiController::class, 'presets']);
                Route::get('themes', [InstallerApiController::class, 'themes']);
                Route::get('templates', [InstallerApiController::class, 'templates']);
                Route::get('themes/compatible/{templateCode}', [InstallerApiController::class, 'compatibleThemes']);
                Route::get('templates/compatible/{themeCode}', [InstallerApiController::class, 'compatibleTemplates']);
            });
    }
}
