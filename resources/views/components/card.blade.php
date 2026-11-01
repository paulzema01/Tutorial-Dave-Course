@props(['title' => null, 'description' => null])

{{-- Panel used for dashboard sections. Optional slots: "actions" (top right) and "footer". --}}
<section {{ $attributes->merge(['class' => 'flex flex-col rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5']) }}>
    @if ($title || isset($actions))
        <header class="flex items-start justify-between gap-4 border-b border-gray-100 px-5 py-4 sm:px-6">
            <div class="min-w-0">
                @if ($title)
                    <h2 class="text-base font-semibold text-gray-900">{{ $title }}</h2>
                @endif
                @if ($description)
                    <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="shrink-0">{{ $actions }}</div>
            @endisset
        </header>
    @endif

    <div class="flex-1 px-5 py-5 sm:px-6">
        {{ $slot }}
    </div>

    @isset($footer)
        <footer class="rounded-b-xl border-t border-gray-100 bg-gray-50 px-5 py-3 sm:px-6">
            {{ $footer }}
        </footer>
    @endisset
</section>
