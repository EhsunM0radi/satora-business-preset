@extends('admin::layouts.master')

@section('page_title', __('business_preset::app.admin.presets'))

@section('content')
<div class="flex gap-2.5 mt-3.5 max-sm:flex-wrap">
    <div class="flex w-full flex-col gap-2 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold dark:text-white">{{ __('business_preset::app.admin.presets') }}</h2>
        </div>

        @if(session('success'))
            <div class="rounded bg-green-100 p-3 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('business_preset::app.installer.business-type-description') }}
        </p>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($presets as $code => $preset)
                <div class="rounded-xl border p-4 {{ $code === $activeCode ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-500 dark:bg-blue-950' : 'border-gray-200 dark:border-gray-700' }}">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-lg font-semibold dark:text-white">
                            {{ config('business_presets.icons.' . $code, '✨') }} 
                            {{ $preset['name'] ?? $code }}
                        </h3>
                        @if($code === $activeCode)
                            <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-bold text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                {{ __('business_preset::app.admin.current') }}
                            </span>
                        @endif
                    </div>

                    <p class="mb-3 text-sm text-gray-600 dark:text-gray-400">{{ $preset['description'] ?? '' }}</p>

                    <div class="mb-3 space-y-1 text-xs text-gray-500">
                        <div>{{ __('business_preset::app.admin.recommended_theme') }}: <strong class="text-gray-700 dark:text-gray-300">{{ $preset['recommended_theme'] ?? '—' }}</strong></div>
                        <div>{{ __('business_preset::app.admin.recommended_template') }}: <strong class="text-gray-700 dark:text-gray-300">{{ $preset['recommended_template'] ?? '—' }}</strong></div>
                        <div>{{ __('business_preset::app.installer.categories-included') }}: <strong class="text-gray-700 dark:text-gray-300">{{ count($preset['default_categories'] ?? []) }}</strong></div>
                        <div>{{ __('business_preset::app.installer.pages-included') }}: <strong class="text-gray-700 dark:text-gray-300">{{ count($preset['default_pages'] ?? []) }}</strong></div>
                    </div>

                    <form method="POST" action="{{ route('admin.satora.presets.apply') }}">
                        @csrf
                        <input type="hidden" name="code" value="{{ $code }}">
                        <button type="submit"
                                onclick="return confirm('{{ __('business_preset::app.admin.reapply_confirm') }}')"
                                class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            {{ $code === $activeCode ? __('business_preset::app.admin.reapply') : __('business_preset::app.admin.apply') }}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
