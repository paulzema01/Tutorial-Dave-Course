@props(['href', 'active' => false])

<a href="{{ $href }}"
   @if ($active) aria-current="page" @endif
   {{ $attributes->class([
       'group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500',
       'bg-indigo-50 text-indigo-700' => $active,
       'text-gray-700 hover:bg-gray-100 hover:text-gray-900' => ! $active,
   ]) }}>
    @isset($icon)
        <span @class(['h-5 w-5 shrink-0', 'text-indigo-600' => $active, 'text-gray-400 group-hover:text-gray-600' => ! $active]) aria-hidden="true">{{ $icon }}</span>
    @endisset
    <span class="truncate">{{ $slot }}</span>
</a>
