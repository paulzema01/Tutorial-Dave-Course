<?php

namespace App\Support;

/**
 * Fixed sample figures for the dashboard's demo panels.
 *
 * None of this comes from the database: it exists to show what the dashboard
 * looks like with data, and the page labels it as sample data. Totals and
 * averages are calculated from the monthly figures so the numbers agree.
 */
class DemoDashboardData
{
    public const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    /** Monthly revenue in thousands of dollars. Null = month not reached yet. */
    private const REVENUE = [
        2025 => [18.2, 19.5, 21.0, 20.4, 22.8, 24.1, 23.5, 25.9, 27.2, 28.4, 31.6, 35.2],
        2026 => [24.6, 25.8, 28.3, 27.9, 30.4, 32.7, 31.9, 34.8, 36.5, 38.9, null, null],
    ];

    private const ORDERS = ['current' => 4382, 'previous' => 3899];

    private const NEW_CUSTOMERS = ['current' => 1126, 'previous' => 1042];

    private const CONVERSION_RATE = ['current' => 3.2, 'previous' => 3.5];

    public static function make(): array
    {
        $currentYear = 2026;
        $monthsSoFar = count(array_filter(self::REVENUE[$currentYear], fn ($value) => $value !== null));

        $revenue = array_sum(array_slice(self::REVENUE[$currentYear], 0, $monthsSoFar)) * 1000;
        $previousRevenue = array_sum(array_slice(self::REVENUE[$currentYear - 1], 0, $monthsSoFar)) * 1000;

        return [
            'period' => 'Jan–'.self::MONTHS[$monthsSoFar - 1].' '.$currentYear,
            'comparison' => 'vs same period last year',
            'stats' => [
                self::stat('Revenue', '$'.number_format($revenue), $revenue, $previousRevenue, 'bi-currency-dollar'),
                self::stat('Orders', number_format(self::ORDERS['current']), self::ORDERS['current'], self::ORDERS['previous'], 'bi-bag-check'),
                self::stat('New customers', number_format(self::NEW_CUSTOMERS['current']), self::NEW_CUSTOMERS['current'], self::NEW_CUSTOMERS['previous'], 'bi-people'),
                [
                    'label' => 'Conversion rate',
                    'value' => self::CONVERSION_RATE['current'].'%',
                    'delta' => round(self::CONVERSION_RATE['current'] - self::CONVERSION_RATE['previous'], 1),
                    'deltaUnit' => ' pts',
                    'icon' => 'bi-graph-up-arrow',
                ],
            ],
            'averageOrderValue' => '$'.number_format($revenue / self::ORDERS['current'], 2),
            'revenue' => [
                'labels' => self::MONTHS,
                // A list, not a year-keyed map: JavaScript reorders numeric keys ascending.
                'years' => [
                    ['year' => (string) $currentYear, 'data' => self::REVENUE[$currentYear]],
                    ['year' => (string) ($currentYear - 1), 'data' => self::REVENUE[$currentYear - 1]],
                ],
            ],
            'categories' => [
                'labels' => ['Electronics', 'Home & garden', 'Clothing', 'Sports', 'Books'],
                'series' => [
                    ['label' => 'Q2 2026', 'data' => [42.1, 28.4, 24.9, 15.3, 9.6]],
                    ['label' => 'Q3 2026', 'data' => [48.6, 31.2, 22.7, 19.8, 10.4]],
                ],
            ],
            'traffic' => [
                ['label' => 'Organic search', 'percent' => 42],
                ['label' => 'Social media', 'percent' => 27],
                ['label' => 'Direct', 'percent' => 19],
                ['label' => 'Email', 'percent' => 12],
            ],
            'topProducts' => [
                ['name' => 'Wireless headphones', 'units' => 842, 'target' => 1000],
                ['name' => 'Smart watch', 'units' => 615, 'target' => 800],
                ['name' => 'Garden hose kit', 'units' => 431, 'target' => 500],
                ['name' => 'Running shoes', 'units' => 388, 'target' => 600],
            ],
            'orders' => [
                ['id' => '#10487', 'customer' => 'Maya Okafor', 'product' => 'Smart watch', 'date' => '2026-10-31', 'amount' => 249.00, 'status' => 'Paid'],
                ['id' => '#10486', 'customer' => 'Liam Brennan', 'product' => 'Running shoes', 'date' => '2026-10-31', 'amount' => 119.50, 'status' => 'Pending'],
                ['id' => '#10485', 'customer' => 'Sofia Marquez', 'product' => 'Wireless headphones', 'date' => '2026-10-30', 'amount' => 189.99, 'status' => 'Paid'],
                ['id' => '#10484', 'customer' => 'Kenji Tanaka', 'product' => 'Garden hose kit', 'date' => '2026-10-30', 'amount' => 64.00, 'status' => 'Refunded'],
                ['id' => '#10483', 'customer' => 'Amara Diallo', 'product' => 'Desk lamp', 'date' => '2026-10-29', 'amount' => 45.25, 'status' => 'Failed'],
                ['id' => '#10482', 'customer' => 'Noah Fischer', 'product' => 'Yoga mat', 'date' => '2026-10-29', 'amount' => 38.00, 'status' => 'Paid'],
            ],
            'activity' => [
                ['icon' => 'bi-bag-plus', 'text' => 'New order #10487 from Maya Okafor', 'time' => '2 hours ago'],
                ['icon' => 'bi-arrow-counterclockwise', 'text' => 'Refund issued for order #10484', 'time' => '5 hours ago'],
                ['icon' => 'bi-person-plus', 'text' => '18 new customers signed up', 'time' => 'Yesterday'],
                ['icon' => 'bi-box-seam', 'text' => 'Smart watch restocked (120 units)', 'time' => '2 days ago'],
            ],
        ];
    }

    private static function stat(string $label, string $value, float $current, float $previous, string $icon): array
    {
        return [
            'label' => $label,
            'value' => $value,
            'delta' => round(($current - $previous) / $previous * 100, 1),
            'deltaUnit' => '%',
            'icon' => $icon,
        ];
    }
}
