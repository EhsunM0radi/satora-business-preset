<?php

namespace Webkul\BusinessPreset\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\BusinessPreset\Helpers\PresetApplier;
use Webkul\BusinessPreset\Helpers\PresetRegistry;

class PresetController extends Controller
{
    public function __construct(
        protected PresetRegistry $registry,
        protected PresetApplier $applier,
    ) {}

    /**
     * Display all presets with current active highlighted.
     */
    public function index(): View
    {
        $presets = $this->registry->toArray();
        $activeCode = \DB::table('core_config')->where('code', 'satora.active_preset')->value('value')
            ?? config('business_presets.default_preset', 'custom');

        return view('business_preset::admin.presets.index', compact('presets', 'activeCode'));
    }

    /**
     * Re-apply a preset.
     */
    public function apply(): RedirectResponse
    {
        $code = request()->input('code');
        $preset = $this->registry->get($code);

        if ($preset) {
            $this->applier->apply($preset);
            session()->flash('success', trans('business_preset::app.admin.preset_applied'));
        }

        return redirect()->route('admin.satora.presets.index');
    }
}
