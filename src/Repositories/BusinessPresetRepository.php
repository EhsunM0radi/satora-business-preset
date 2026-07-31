<?php

namespace Webkul\BusinessPreset\Repositories;

use Webkul\BusinessPreset\Contracts\BusinessPresetModel as BusinessPresetModelContract;
use Webkul\Core\Eloquent\Repository;

class BusinessPresetRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return BusinessPresetModelContract::class;
    }

    /**
     * Get all active presets sorted.
     */
    public function getActivePresets()
    {
        return $this->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find by code.
     */
    public function findByCode(string $code)
    {
        return $this->findOneByField('code', $code);
    }
}
