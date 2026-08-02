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
use Webkul\BusinessPreset\Presets\FurniturePreset;
use Webkul\BusinessPreset\Presets\GroceryPreset;
use Webkul\BusinessPreset\Presets\MarketplacePreset;

class BusinessPresetServiceProvider extends ServiceProvider
{
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
                DigitalPreset::class,
                FurniturePreset::class,
                MarketplacePreset::class,
                CustomPreset::class,
            ]);

            return $registry;
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(dirname(__DIR__).'/Database/Migrations');
        $this->loadTranslationsFrom(dirname(__DIR__).'/Resources/lang', 'business_preset');
        $this->loadViewsFrom(dirname(__DIR__).'/Resources/views', 'business_preset');
        $this->publishes([dirname(__DIR__).'/Config/presets.php' => config_path('business_presets.php')]);

        $this->registerInstallerApiRoutes();
        $this->registerAdminRoutes();
    }

    protected function registerInstallerApiRoutes(): void
    {
        Route::group(['prefix' => 'install/api/satora', 'middleware' => 'web'], function () {
            Route::get('presets', [InstallerApiController::class, 'presets']);
            Route::get('themes', [InstallerApiController::class, 'themes']);
            Route::get('templates', [InstallerApiController::class, 'templates']);
            Route::get('templates/{templateCode}/themes', [InstallerApiController::class, 'compatibleThemes']);
        });
    }

    protected function registerAdminRoutes(): void
    {
        Route::group(['prefix' => config('app.admin_url'), 'middleware' => ['web', 'admin']], function () {
            Route::get('settings/presets', [PresetController::class, 'index'])
                ->name('admin.satora.presets.index');
            Route::post('settings/presets/apply', [PresetController::class, 'apply'])
                ->name('admin.satora.presets.apply');
        });
    }
}
