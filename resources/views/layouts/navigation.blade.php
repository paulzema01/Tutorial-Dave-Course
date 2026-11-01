{{-- Sidebar contents. Included twice by layouts.app (desktop sidebar and mobile drawer), so it must not use element IDs. --}}
<div class="flex h-full flex-col gap-y-6 overflow-y-auto border-e border-gray-200 bg-white px-4 py-5">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
        <x-application-logo class="h-8 w-8 fill-current text-indigo-600" />
        <span class="truncate text-base font-semibold text-gray-900">{{ config('app.name') }}</span>
    </a>

    <nav aria-label="{{ __('Main') }}" class="flex flex-1 flex-col">
        <ul role="list" class="space-y-1">
            <li>
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                    </x-slot>
                    {{ __('Dashboard') }}
                </x-sidebar-link>
            </li>
        </ul>

        <p class="mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Account') }}</p>
        <ul role="list" class="mt-2 space-y-1">
            <li>
                <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                    </x-slot>
                    {{ __('Profile') }}
                </x-sidebar-link>
            </li>
            <li>
                <x-sidebar-link :href="route('profile.edit').'#update-password'">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>
                    </x-slot>
                    {{ __('Change password') }}
                </x-sidebar-link>
            </li>
        </ul>

        <div class="mt-auto border-t border-gray-200 pt-4">
            <div class="flex items-center gap-3 px-2">
                <x-user-avatar :user="Auth::user()" size="sm" />
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="group flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                    <svg class="h-5 w-5 shrink-0 text-gray-400 group-hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </nav>
</div>
