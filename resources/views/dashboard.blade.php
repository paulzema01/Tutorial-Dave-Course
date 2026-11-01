<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Heading --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ __('Dashboard') }}</h1>
            <p class="mt-1 text-sm text-gray-600 sm:text-base">
                {{ __('Welcome, :name. This is your personal dashboard.', ['name' => $user->name]) }}
            </p>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Profile summary --}}
            <x-card :title="__('Your profile')" :description="__('The details on your account.')">
                <div class="flex items-center gap-4">
                    <x-user-avatar :user="$user" size="lg" />
                    <div class="min-w-0">
                        <p class="truncate text-lg font-semibold text-gray-900" data-testid="profile-name">{{ $user->name }}</p>
                        <p class="truncate text-sm text-gray-600" data-testid="profile-email">{{ $user->email }}</p>
                    </div>
                </div>

                <dl class="mt-6 space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500">{{ __('Email') }}</dt>
                        <dd class="truncate font-medium text-gray-900">{{ $user->email }}</dd>
                    </div>
                    @if ($user->created_at)
                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-500">{{ __('Member since') }}</dt>
                            <dd class="font-medium text-gray-900">
                                <time datetime="{{ $user->created_at->toDateString() }}">{{ $user->created_at->format('F j, Y') }}</time>
                            </dd>
                        </div>
                    @endif
                </dl>

                <x-slot name="footer">
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1 rounded text-sm font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        {{ __('Edit profile') }}
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </a>
                </x-slot>
            </x-card>

            {{-- Account security --}}
            <x-card :title="__('Account security')" :description="__('Keep your account protected.')">
                <div class="flex items-start gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ __('Password') }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Use a long, unique password that you don’t use anywhere else.') }}</p>
                    </div>
                </div>

                <x-slot name="footer">
                    <a href="{{ route('profile.edit') }}#update-password" class="inline-flex items-center gap-1 rounded text-sm font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        {{ __('Change password') }}
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </a>
                </x-slot>
            </x-card>

            {{-- Placeholder for future features (no fabricated data) --}}
            <x-card :title="__('Your workspace')" :description="__('Features you use will appear here.')">
                <x-empty-state :title="__('Nothing here yet')" :description="__('New features will show up in this space as they are added to the site.')">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                    </x-slot>
                </x-empty-state>
            </x-card>
        </div>
    </div>
</x-app-layout>
