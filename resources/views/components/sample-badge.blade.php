{{-- Marks a panel whose figures are made-up demo data, not the user's real data. --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20']) }}>
    <i class="bi bi-flask" aria-hidden="true"></i>{{ __('Sample data') }}
</span>
