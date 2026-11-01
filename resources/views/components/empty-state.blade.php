@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-200 px-6 py-10 text-center']) }}>
    @isset($icon)
        <span class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400" aria-hidden="true">{{ $icon }}</span>
    @endisset
    <p class="text-sm font-semibold text-gray-900">{{ $title }}</p>
    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-gray-500">{{ $description }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
