<?php

namespace Tests\Unit;

use App\Support\DemoDashboardData;
use PHPUnit\Framework\TestCase;

class DemoDashboardDataTest extends TestCase
{
    public function test_revenue_total_and_change_are_calculated_from_the_monthly_figures(): void
    {
        $data = DemoDashboardData::make();
        $revenue = $data['stats'][0];

        // Jan–Oct 2026 = 311.8K; Jan–Oct 2025 = 231.0K → +35.0%.
        $this->assertSame('Revenue', $revenue['label']);
        $this->assertSame('$311,800', $revenue['value']);
        $this->assertSame(35.0, $revenue['delta']);
        $this->assertSame('Jan–Oct 2026', $data['period']);
    }

    public function test_a_falling_figure_has_a_negative_change(): void
    {
        $conversion = DemoDashboardData::make()['stats'][3];

        $this->assertSame(-0.3, $conversion['delta']);
        $this->assertSame(' pts', $conversion['deltaUnit']);
    }

    public function test_traffic_shares_add_up_to_one_hundred_percent(): void
    {
        $this->assertSame(100, array_sum(array_column(DemoDashboardData::make()['traffic'], 'percent')));
    }

    public function test_every_chart_series_matches_its_labels(): void
    {
        $data = DemoDashboardData::make();

        foreach ($data['revenue']['years'] as $entry) {
            $this->assertCount(count($data['revenue']['labels']), $entry['data']);
        }
        foreach ($data['categories']['series'] as $series) {
            $this->assertCount(count($data['categories']['labels']), $series['data']);
        }
    }
}
