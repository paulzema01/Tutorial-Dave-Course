<x-guest-layout wide>
    <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-gray-900/5 lg:grid lg:grid-cols-5">

        {{-- Brand panel (large screens) --}}
        <aside class="relative hidden overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800 p-10 text-white lg:col-span-2 lg:flex lg:flex-col">
            <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-violet-400/20 blur-3xl" aria-hidden="true"></div>

            <a href="/" class="relative inline-flex w-fit items-center gap-3 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                <x-application-logo class="h-10 w-10 fill-current text-white" />
                <span class="text-lg font-semibold tracking-tight">{{ config('app.name') }}</span>
            </a>

            <div class="relative mt-16">
                <h2 class="text-3xl font-bold leading-tight tracking-tight">{{ __('Create your account') }}</h2>
                <p class="mt-3 text-indigo-100">{{ __('Set up your account in a few steps and get started.') }}</p>
            </div>

            <ul class="relative mt-10 space-y-6">
                <li class="flex gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/20" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                    </span>
                    <div>
                        <p class="font-semibold">{{ __('Secure by design') }}</p>
                        <p class="text-sm text-indigo-100">{{ __('Your password is stored as a secure hash, never as plain text.') }}</p>
                    </div>
                </li>
                <li class="flex gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/20" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    </span>
                    <div>
                        <p class="font-semibold">{{ __('Protected sessions') }}</p>
                        <p class="text-sm text-indigo-100">{{ __('Sessions are secured and expire after a period of inactivity.') }}</p>
                    </div>
                </li>
                <li class="flex gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/20" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                    </span>
                    <div>
                        <p class="font-semibold">{{ __('Works on every screen') }}</p>
                        <p class="text-sm text-indigo-100">{{ __('Designed for desktop, tablet and mobile.') }}</p>
                    </div>
                </li>
            </ul>
        </aside>

        {{-- Form --}}
        <div class="px-6 py-10 sm:px-12 lg:col-span-3 lg:py-14">
            <a href="/" class="mb-8 inline-flex items-center gap-2 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 lg:hidden">
                <x-application-logo class="h-9 w-9 fill-current text-indigo-600" />
                <span class="text-base font-semibold text-gray-900">{{ config('app.name') }}</span>
            </a>

            <div class="mx-auto max-w-md">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ __('Create an account') }}</h1>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('login') }}" class="rounded font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">{{ __('Log in') }}</a>
                </p>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5" x-data="registerForm({ minLength: 8 })">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <x-input-label for="name" :value="__('Full name')" />
                        <div class="relative mt-1">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-gray-400" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                            </span>
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                placeholder="{{ __('Jane Doe') }}"
                                @class(['block w-full ps-10', '!border-red-500' => $errors->has('name')])
                                :aria-invalid="$errors->has('name') ? 'true' : 'false'"
                                aria-describedby="name-error" />
                        </div>
                        <x-input-error id="name-error" :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email address')" />
                        <div class="relative mt-1">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-gray-400" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                            </span>
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                                placeholder="{{ __('you@example.com') }}"
                                @class(['block w-full ps-10', '!border-red-500' => $errors->has('email')])
                                :aria-invalid="$errors->has('email') ? 'true' : 'false'"
                                aria-describedby="email-error" />
                        </div>
                        <x-input-error id="email-error" :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="mt-1">
                            <x-password-input id="password" name="password" required
                                x-model="password"
                                x-bind:class="{
                                    '!border-emerald-500 focus:!border-emerald-500 focus:!ring-emerald-500': matchState === 'match',
                                    '!border-red-500 focus:!border-red-500 focus:!ring-red-500': matchState === 'mismatch',
                                }"
                                @class(['!border-red-500' => $errors->has('password')])
                                aria-describedby="password-hint password-error" />
                        </div>

                        {{-- Strength meter and requirement (live, shown once typing starts) --}}
                        <div id="password-hint" class="mt-3" x-cloak x-show="password.length > 0" x-transition.opacity>
                            <div class="flex gap-1.5" aria-hidden="true">
                                <template x-for="segment in 4" :key="segment">
                                    <span class="h-1.5 flex-1 rounded-full transition-colors duration-300"
                                          x-bind:class="segment <= strength ? strengthColor : 'bg-gray-200'"></span>
                                </template>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-xs">
                                <span class="flex items-center gap-1.5" x-bind:class="meetsMinLength ? 'text-emerald-700' : 'text-gray-500'">
                                    <svg x-show="meetsMinLength" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                    <svg x-show="! meetsMinLength" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="8" /></svg>
                                    {{ __('At least 8 characters') }}
                                </span>
                                <span class="font-medium" x-bind:class="strengthTextColor" aria-live="polite">
                                    <span class="sr-only">{{ __('Password strength:') }}</span>
                                    <span x-text="strengthLabel"></span>
                                </span>
                            </div>
                        </div>

                        <x-input-error id="password-error" :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Confirm password --}}
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm password')" />
                        <div class="mt-1">
                            <x-password-input id="password_confirmation" name="password_confirmation" required
                                x-model="confirmation"
                                x-bind:class="{
                                    '!border-emerald-500 focus:!border-emerald-500 focus:!ring-emerald-500': matchState === 'match',
                                    '!border-red-500 focus:!border-red-500 focus:!ring-red-500': matchState === 'mismatch',
                                }"
                                x-bind:aria-invalid="matchState === 'mismatch' ? 'true' : 'false'"
                                aria-describedby="password-match password_confirmation-error" />
                        </div>

                        {{-- Live match status --}}
                        <p id="password-match" class="mt-2 min-h-[1.25rem] text-sm" aria-live="polite">
                            <span x-cloak x-show="matchState === 'match'" class="inline-flex items-center gap-1.5 font-medium text-emerald-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                {{ __('Passwords match') }}
                            </span>
                            <span x-cloak x-show="matchState === 'mismatch'" class="inline-flex items-center gap-1.5 font-medium text-red-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                {{ __("Passwords don't match") }}
                            </span>
                        </p>

                        <x-input-error id="password_confirmation-error" :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-md bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 active:bg-indigo-700">
                        {{ __('Create account') }}
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
