<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="min-h-screen bg-gray-100 font-sans text-gray-900 antialiased"
        x-data="{ sidebarOpen: false }"
        x-bind:class="{ 'overflow-hidden': sidebarOpen }"
        x-on:keydown.escape.window="if (sidebarOpen) { sidebarOpen = false; $nextTick(() => $refs.openSidebar.focus()) }"
    >
        <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:start-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:shadow-lg focus:ring-2 focus:ring-indigo-500">
            {{ __('Skip to content') }}
        </a>

        {{-- Mobile / tablet navigation drawer --}}
        <div x-cloak x-show="sidebarOpen" class="relative z-40 lg:hidden" role="dialog" aria-modal="true" aria-label="{{ __('Navigation') }}">
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60"
                 x-on:click="sidebarOpen = false"
                 aria-hidden="true"></div>

            <div class="fixed inset-0 flex pointer-events-none">
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in duration-150 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                     class="pointer-events-auto relative flex w-full max-w-xs flex-1">
                    <button type="button" x-ref="closeSidebar"
                            x-on:click="sidebarOpen = false; $nextTick(() => $refs.openSidebar.focus())"
                            class="absolute end-0 top-3 -me-12 flex h-10 w-10 items-center justify-center rounded-full text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        <span class="sr-only">{{ __('Close navigation') }}</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                    </button>
                    <div class="w-full">
                        @include('layouts.navigation')
                    </div>
                </div>
            </div>
        </div>

        {{-- Desktop sidebar --}}
        <aside class="hidden lg:fixed lg:inset-y-0 lg:z-30 lg:flex lg:w-64 lg:flex-col">
            @include('layouts.navigation')
        </aside>

        <div class="lg:ps-64">
            {{-- Top bar --}}
            <header class="sticky top-0 z-20 flex h-16 items-center gap-x-4 border-b border-gray-200 bg-white/95 px-4 backdrop-blur sm:px-6 lg:px-8">
                <button type="button" x-ref="openSidebar"
                        x-on:click="sidebarOpen = true; $nextTick(() => $refs.closeSidebar.focus())"
                        x-bind:aria-expanded="sidebarOpen.toString()"
                        aria-expanded="false"
                        class="-m-2 rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 lg:hidden">
                    <span class="sr-only">{{ __('Open navigation') }}</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>

                <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 lg:hidden">
                    <x-application-logo class="h-7 w-7 shrink-0 fill-current text-indigo-600" />
                    <span class="truncate text-sm font-semibold text-gray-900">{{ config('app.name') }}</span>
                </a>

                <div class="ms-auto flex items-center">
                    {{-- Account menu --}}
                    <x-dropdown align="right" width="w-64">
                        <x-slot name="trigger">
                            <button type="button"
                                    x-bind:aria-expanded="open.toString()"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    class="flex items-center gap-2 rounded-full p-1 text-sm hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 sm:rounded-lg sm:pe-2">
                                <span class="sr-only">{{ __('Open account menu') }}</span>
                                <x-user-avatar :user="Auth::user()" size="sm" />
                                <span class="hidden max-w-[12rem] truncate font-medium text-gray-700 sm:block">{{ Auth::user()->name }}</span>
                                <svg class="hidden h-4 w-4 text-gray-400 sm:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="border-b border-gray-100 px-4 py-3">
                                <p class="truncate text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="truncate text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <x-dropdown-link :href="route('dashboard')">{{ __('Dashboard') }}</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit').'#update-password'">{{ __('Change password') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
                                    {{ __('Log out') }}
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            @isset($header)
                <div class="border-b border-gray-200 bg-white">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <main id="main-content" tabindex="-1" class="focus:outline-none">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
