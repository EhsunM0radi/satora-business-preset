<?php

namespace Webkul\BusinessPreset\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Webkul\BusinessPreset\Models\BusinessPreset;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        BusinessPreset::class,
    ];
}
