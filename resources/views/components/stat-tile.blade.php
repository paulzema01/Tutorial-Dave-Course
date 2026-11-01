@props(['label', 'value', 'delta' => null, 'deltaUnit' => '%', 'comparison' => null, 'icon' => null])

{{-- Headline number with an optional change versus a named period. Direction is shown by arrow and sign, not colour alone. --}}
<div {{ $attributes->merge(['class' => 'rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-900/5']) }}>
    <div class="flex items-start justify-between gap-3">
        <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
        @if ($icon)
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600" aria-hidden="true">
                <i class="bi {{ $icon }} text-lg leading-none"></i>
            </span>
        @endif
    </div>

    <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">{{ $value }}</p>

    @if (! is_null($delta))
        <p class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm">
            <span @class([
                'inline-flex items-center gap-1 rounded-md px-1.5 py-0.5 font-semibold',
                'bg-emerald-50 text-emerald-700' => $delta >= 0,
                'bg-red-50 text-red-700' => $delta < 0,
            ])>
                <i class="bi {{ $delta >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}" aria-hidden="true"></i>
                <span class="sr-only">{{ $delta >= 0 ? __('Up') : __('Down') }}</span>
                {{ ($delta > 0 ? '+' : '').$delta.$deltaUnit }}
            </span>
            @if ($comparison)
                <span class="text-gray-500">{{ $comparison }}</span>
            @endif
        </p>
    @endif
</div>
