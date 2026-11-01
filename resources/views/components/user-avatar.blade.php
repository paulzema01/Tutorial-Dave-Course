@props(['user', 'size' => 'md'])

@php
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->join('');

    $sizeClasses = match ($size) {
        'sm' => 'h-8 w-8 text-xs',
        'lg' => 'h-16 w-16 text-xl',
        default => 'h-10 w-10 text-sm',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex shrink-0 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-700 ring-1 ring-indigo-200 {$sizeClasses}"]) }} aria-hidden="true">{{ $initials ?: '?' }}</span>
