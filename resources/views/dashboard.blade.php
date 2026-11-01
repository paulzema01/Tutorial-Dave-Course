@php
    // Bootstrap badge style + icon for each order status (icon and label, never colour alone).
    $statusStyles = [
        'Paid' => ['text-bg-success', 'bi-check-circle-fill'],
        'Pending' => ['text-bg-warning', 'bi-hourglass-split'],
        'Refunded' => ['text-bg-secondary', 'bi-arrow-counterclockwise'],
        'Failed' => ['text-bg-danger', 'bi-x-circle-fill'],
    ];
    $trafficColors = ['#2a78d6', '#eb6834', '#1baf7a', '#eda100'];
    $initials = fn (string $name) => collect(explode(' ', $name))->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->join('');
@endphp

<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

        {{-- Welcome banner --}}
        <section class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-600 to-violet-600 px-6 py-7 text-white shadow-sm sm:px-8 sm:py-8">
            <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full bg-white/10" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-24 right-40 h-48 w-48 rounded-full bg-white/5" aria-hidden="true"></div>

            <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-indigo-100">{{ __('Dashboard') }}</p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        {{ __('Welcome back, :name', ['name' => $user->name]) }}
                    </h1>
                    <p class="mt-2 max-w-xl text-sm text-indigo-100 sm:text-base">
                        {{ __('Here’s how the demo store is performing for :period.', ['period' => $demo['period']]) }}
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-2 text-xs font-medium">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 ring-1 ring-inset ring-white/25">
                            <i class="bi bi-calendar3" aria-hidden="true"></i>{{ $demo['period'] }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 ring-1 ring-inset ring-white/25">
                            <i class="bi bi-flask" aria-hidden="true"></i>{{ __('Sample data') }}
                        </span>
                    </div>
                </div>

                {{-- Decorative illustration --}}
                <svg class="hidden h-32 w-56 shrink-0 md:block" viewBox="0 0 224 128" fill="none" aria-hidden="true">
                    <rect x="8" y="8" width="208" height="112" rx="14" fill="white" fill-opacity=".12" />
                    <rect x="28" y="72" width="16" height="32" rx="4" fill="white" fill-opacity=".45" />
                    <rect x="54" y="58" width="16" height="46" rx="4" fill="white" fill-opacity=".55" />
                    <rect x="80" y="64" width="16" height="40" rx="4" fill="white" fill-opacity=".45" />
                    <rect x="106" y="46" width="16" height="58" rx="4" fill="white" fill-opacity=".65" />
                    <rect x="132" y="38" width="16" height="66" rx="4" fill="white" fill-opacity=".75" />
                    <rect x="158" y="26" width="16" height="78" rx="4" fill="white" fill-opacity=".9" />
                    <path d="M30 60 62 46l26 6 26-18 26-8 26-12 20-4" stroke="#fde68a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="192" cy="10" r="6" fill="#fde68a" stroke="white" stroke-width="2" />
                </svg>
            </div>
        </section>

        {{-- Sample data notice --}}
        <div class="alert alert-warning !mb-0 !flex items-start gap-3 text-sm" role="note">
            <i class="bi bi-info-circle mt-0.5 text-base" aria-hidden="true"></i>
            <p class="mb-0">
                <strong>{{ __('Demo dashboard.') }}</strong>
                {{ __('The figures, charts and orders on this page are made-up sample data to show the design. They are not from your account. Your real account details are in the “Your profile” panel.') }}
            </p>
        </div>

        {{-- Headline figures --}}
        <section aria-labelledby="kpi-heading">
            <h2 id="kpi-heading" class="sr-only">{{ __('Key figures') }}</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($demo['stats'] as $stat)
                    <x-stat-tile :label="$stat['label']" :value="$stat['value']" :delta="$stat['delta']" :delta-unit="$stat['deltaUnit']" :icon="$stat['icon']" :comparison="$demo['comparison']" />
                @endforeach
            </div>
        </section>

        {{-- Revenue chart + traffic --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <x-card class="lg:col-span-2" :title="__('Monthly revenue')" :description="__('Revenue per month, in thousands of US dollars.')">
                <x-slot name="actions">
                    <div class="btn-group btn-group-sm" role="group" aria-label="{{ __('Choose year') }}">
                        @foreach ($demo['revenue']['years'] as $entry)
                            <input type="radio" class="btn-check" name="revenue-year" id="revenue-{{ $entry['year'] }}" value="{{ $entry['year'] }}" autocomplete="off" @checked($loop->first)>
                            <label class="btn btn-outline-primary" for="revenue-{{ $entry['year'] }}">{{ $entry['year'] }}</label>
                        @endforeach
                    </div>
                </x-slot>

                <div class="relative h-72">
                    <canvas data-chart="revenue" role="img" aria-label="{{ __('Bar chart of monthly revenue. The data is also available in the table below.') }}"></canvas>
                </div>

                <details class="group mt-4 text-sm">
                    <summary class="cursor-pointer select-none rounded font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">{{ __('Show data as a table') }}</summary>
                    <div class="mt-3 overflow-x-auto">
                        <table class="table table-sm table-striped !mb-0">
                            <thead><tr><th scope="col">{{ __('Month') }}</th>@foreach ($demo['revenue']['years'] as $entry)<th scope="col" class="text-right">{{ $entry['year'] }}</th>@endforeach</tr></thead>
                            <tbody>
                                @foreach ($demo['revenue']['labels'] as $i => $month)
                                    <tr>
                                        <th scope="row" class="font-normal">{{ $month }}</th>
                                        @foreach ($demo['revenue']['years'] as $entry)
                                            <td class="text-right tabular-nums">{{ is_null($entry['data'][$i]) ? '—' : '$'.number_format($entry['data'][$i], 1).'K' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>

                <x-slot name="footer">
                    <x-sample-badge />
                </x-slot>
            </x-card>

            <x-card :title="__('Traffic sources')" :description="__('Where store visitors came from.')">
                <div class="progress-stacked h-3" role="img" aria-label="{{ collect($demo['traffic'])->map(fn ($s) => $s['label'].' '.$s['percent'].'%')->join(', ') }}">
                    @foreach ($demo['traffic'] as $i => $source)
                        <div class="progress border-r-2 border-white last:border-r-0" style="width: {{ $source['percent'] }}%">
                            <div class="progress-bar" style="background-color: {{ $trafficColors[$i] }}"></div>
                        </div>
                    @endforeach
                </div>

                <ul class="mt-5 space-y-3 text-sm" role="list">
                    @foreach ($demo['traffic'] as $i => $source)
                        <li class="flex items-center justify-between gap-3">
                            <span class="flex items-center gap-2 text-gray-700">
                                <span class="h-2.5 w-2.5 rounded-sm" style="background-color: {{ $trafficColors[$i] }}" aria-hidden="true"></span>
                                {{ $source['label'] }}
                            </span>
                            <span class="font-semibold tabular-nums text-gray-900">{{ $source['percent'] }}%</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 rounded-lg bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">{{ __('Average order value') }}</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">{{ $demo['averageOrderValue'] }}</p>
                </div>

                <x-slot name="footer">
                    <x-sample-badge />
                </x-slot>
            </x-card>
        </div>

        {{-- Category chart + top products --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <x-card class="lg:col-span-2" :title="__('Sales by category')" :description="__('Quarter-on-quarter sales, in thousands of US dollars.')">
                <div class="relative h-72">
                    <canvas data-chart="categories" role="img" aria-label="{{ __('Bar chart comparing sales by category for two quarters. The data is also available in the table below.') }}"></canvas>
                </div>

                <details class="mt-4 text-sm">
                    <summary class="cursor-pointer select-none rounded font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">{{ __('Show data as a table') }}</summary>
                    <div class="mt-3 overflow-x-auto">
                        <table class="table table-sm table-striped !mb-0">
                            <thead><tr><th scope="col">{{ __('Category') }}</th>@foreach ($demo['categories']['series'] as $series)<th scope="col" class="text-right">{{ $series['label'] }}</th>@endforeach</tr></thead>
                            <tbody>
                                @foreach ($demo['categories']['labels'] as $i => $category)
                                    <tr>
                                        <th scope="row" class="font-normal">{{ $category }}</th>
                                        @foreach ($demo['categories']['series'] as $series)
                                            <td class="text-right tabular-nums">${{ number_format($series['data'][$i], 1) }}K</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>

                <x-slot name="footer">
                    <x-sample-badge />
                </x-slot>
            </x-card>

            <x-card :title="__('Top products')" :description="__('Units sold against this year’s target.')">
                <ul class="space-y-5" role="list">
                    @foreach ($demo['topProducts'] as $product)
                        @php $percent = (int) round($product['units'] / $product['target'] * 100); @endphp
                        <li>
                            <div class="flex items-baseline justify-between gap-3 text-sm">
                                <span class="font-medium text-gray-900">{{ $product['name'] }}</span>
                                <span class="tabular-nums text-gray-500">{{ number_format($product['units']) }} / {{ number_format($product['target']) }}</span>
                            </div>
                            <div class="progress mt-2 h-2" style="--bs-progress-bg: #cde2fb" role="progressbar" aria-label="{{ $product['name'] }}" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-full" style="width: {{ $percent }}%; background-color: #2a78d6"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <x-slot name="footer">
                    <x-sample-badge />
                </x-slot>
            </x-card>
        </div>

        {{-- Orders table + account side column --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 lg:items-start">
            <x-card class="lg:col-span-2" :title="__('Recent orders')" :description="__('The latest orders placed in the demo store.')">
                <div class="-mx-5 -my-5 overflow-x-auto sm:-mx-6">
                    <table class="table table-hover !mb-0 min-w-[640px] text-sm">
                        <thead>
                            <tr class="text-xs uppercase tracking-wide text-gray-500">
                                <th scope="col" class="!pl-5 font-medium sm:!pl-6">{{ __('Order') }}</th>
                                <th scope="col" class="font-medium">{{ __('Customer') }}</th>
                                <th scope="col" class="font-medium">{{ __('Product') }}</th>
                                <th scope="col" class="font-medium">{{ __('Date') }}</th>
                                <th scope="col" class="text-right font-medium">{{ __('Amount') }}</th>
                                <th scope="col" class="!pr-5 font-medium sm:!pr-6">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demo['orders'] as $order)
                                @php [$badgeClass, $badgeIcon] = $statusStyles[$order['status']]; @endphp
                                <tr>
                                    <td class="!pl-5 align-middle font-medium text-gray-900 sm:!pl-6">{{ $order['id'] }}</td>
                                    <td class="align-middle">
                                        <span class="flex items-center gap-2">
                                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-600" aria-hidden="true">{{ $initials($order['customer']) }}</span>
                                            <span class="whitespace-nowrap text-gray-900">{{ $order['customer'] }}</span>
                                        </span>
                                    </td>
                                    <td class="align-middle whitespace-nowrap text-gray-600">{{ $order['product'] }}</td>
                                    <td class="align-middle whitespace-nowrap text-gray-600">
                                        <time datetime="{{ $order['date'] }}">{{ \Illuminate\Support\Carbon::parse($order['date'])->format('M j, Y') }}</time>
                                    </td>
                                    <td class="align-middle text-right font-medium tabular-nums text-gray-900">${{ number_format($order['amount'], 2) }}</td>
                                    <td class="!pr-5 align-middle sm:!pr-6">
                                        <span class="badge {{ $badgeClass }} !inline-flex items-center gap-1 !rounded-full font-medium">
                                            <i class="bi {{ $badgeIcon }}" aria-hidden="true"></i>{{ $order['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <x-slot name="footer">
                    <x-sample-badge />
                </x-slot>
            </x-card>

            <div class="space-y-6">
                {{-- Real account data --}}
                <x-card :title="__('Your profile')" :description="__('The details on your account.')">
                    <div class="flex items-center gap-4">
                        <x-user-avatar :user="$user" size="lg" />
                        <div class="min-w-0">
                            <p class="truncate text-lg font-semibold text-gray-900" data-testid="profile-name">{{ $user->name }}</p>
                            <p class="truncate text-sm text-gray-600" data-testid="profile-email">{{ $user->email }}</p>
                        </div>
                    </div>

                    @if ($user->created_at)
                        <p class="mt-4 flex items-center gap-2 text-sm text-gray-600">
                            <i class="bi bi-calendar3 text-gray-400" aria-hidden="true"></i>
                            {{ __('Member since') }}
                            <time class="font-medium text-gray-900" datetime="{{ $user->created_at->toDateString() }}">{{ $user->created_at->format('F j, Y') }}</time>
                        </p>
                    @endif

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary !inline-flex items-center gap-1.5">
                            <i class="bi bi-pencil-square" aria-hidden="true"></i>{{ __('Edit profile') }}
                        </a>
                        <a href="{{ route('profile.edit') }}#update-password" class="btn btn-sm btn-outline-secondary !inline-flex items-center gap-1.5">
                            <i class="bi bi-shield-lock" aria-hidden="true"></i>{{ __('Change password') }}
                        </a>
                    </div>
                </x-card>

                <x-card :title="__('Recent activity')">
                    <ul class="list-group list-group-flush -mx-5 -my-5 sm:-mx-6" role="list">
                        @foreach ($demo['activity'] as $item)
                            <li class="list-group-item !flex items-start gap-3 !px-5 !py-3 sm:!px-6">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-indigo-600" aria-hidden="true">
                                    <i class="bi {{ $item['icon'] }}"></i>
                                </span>
                                <div class="min-w-0 text-sm">
                                    <p class="mb-0 text-gray-900">{{ $item['text'] }}</p>
                                    <p class="mb-0 text-xs text-gray-500">{{ $item['time'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <x-slot name="footer">
                        <x-sample-badge />
                    </x-slot>
                </x-card>
            </div>
        </div>
    </div>

    {{-- Chart data for resources/js/dashboard-charts.js --}}
    <script type="application/json" id="dashboard-chart-data">@json(['revenue' => $demo['revenue'], 'categories' => $demo['categories']])</script>
</x-app-layout>
