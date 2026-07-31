<?php

namespace Webkul\BusinessPreset\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\BusinessPreset\Helpers\PresetRegistry;
use Webkul\BusinessPreset\Http\Controllers\Admin\PresetController;
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

        $this->loadViewsFrom(
            dirname(__DIR__).'/Resources/views', 'business_preset'
        );

        $this->publishes([
            dirname(__DIR__).'/Config/presets.php' => config_path('business_presets.php'),
        ], 'business-preset-config');

        $this->publishes([
            dirname(__DIR__).'/Resources/lang' => resource_path('lang/vendor/business_preset'),
        ], 'business-preset-lang');

        $this->registerInstallerApiRoutes();
        $this->registerAdminRoutes();
    }

    /**
     * Register admin routes for preset management.
     */
    protected function registerAdminRoutes(): void
    {
        Route::group([
            'prefix' => config('app.admin_url'),
            'middleware' => ['web', 'admin'],
        ], function () {
            Route::prefix('satora')->group(function () {
                Route::get('presets', [PresetController::class, 'index'])
                    ->name('admin.satora.presets.index');
                Route::post('presets/apply', [PresetController::class, 'apply'])
                    ->name('admin.satora.presets.apply');
            });
        });
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
