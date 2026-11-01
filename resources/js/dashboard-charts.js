import { BarController, BarElement, CategoryScale, Chart, Legend, LinearScale, Tooltip } from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend);

// Colour-blind-safe categorical slots, always assigned in this order.
const SERIES = ['#2a78d6', '#eb6834'];
const TEXT_MUTED = '#6b7280';
const GRID = '#eef0f3';

Chart.defaults.font.family = "Figtree, ui-sans-serif, system-ui, sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.color = TEXT_MUTED;

const money = (value) => `$${Number(value).toFixed(1)}K`;

const tooltip = {
    backgroundColor: '#111827',
    padding: 10,
    cornerRadius: 8,
    titleFont: { weight: '600' },
    callbacks: {
        label: (ctx) => ` ${ctx.dataset.label}: ${money(ctx.parsed[ctx.chart.options.indexAxis === 'y' ? 'x' : 'y'])}`,
    },
};

// Thin bars with a 4px rounded end, square at the baseline.
const bar = { maxBarThickness: 24, borderRadius: 4, borderSkipped: 'start' };

function valueAxis(extra = {}) {
    return {
        beginAtZero: true,
        border: { display: false },
        grid: { color: GRID },
        ticks: { callback: (value) => `$${value}K`, maxTicksLimit: 6 },
        ...extra,
    };
}

const categoryAxis = { border: { display: false }, grid: { display: false } };

function revenueChart(canvas, data) {
    const [first] = data.years;

    const chart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{ label: `Revenue ${first.year}`, data: first.data, backgroundColor: SERIES[0], ...bar }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip },
            scales: { x: categoryAxis, y: valueAxis() },
        },
    });

    // Year switch (Bootstrap radio button group) above the chart.
    document.querySelectorAll('input[name="revenue-year"]').forEach((input) => {
        input.addEventListener('change', () => {
            chart.data.datasets[0].data = data.years.find((entry) => entry.year === input.value).data;
            chart.data.datasets[0].label = `Revenue ${input.value}`;
            chart.update();
        });
    });
}

function categoryChart(canvas, data) {
    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: data.series.map((series, i) => ({
                label: series.label,
                data: series.data,
                backgroundColor: SERIES[i],
                ...bar,
                maxBarThickness: 16,
                // Surface-coloured gap between the two bars of each pair.
                borderColor: '#ffffff',
                borderWidth: { right: 2, top: 1, bottom: 1 },
            })),
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false,
            interaction: { mode: 'index', axis: 'y', intersect: false },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: { usePointStyle: true, pointStyle: 'rectRounded', boxWidth: 10, boxHeight: 10, color: '#374151' },
                },
                tooltip,
            },
            scales: { x: valueAxis(), y: { ...categoryAxis, ticks: { color: '#374151' } } },
        },
    });
}

const builders = { revenue: revenueChart, categories: categoryChart };

export default function initDashboardCharts() {
    const source = document.getElementById('dashboard-chart-data');
    if (!source) return;

    const data = JSON.parse(source.textContent);

    document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
        const build = builders[canvas.dataset.chart];
        if (build && data[canvas.dataset.chart]) build(canvas, data[canvas.dataset.chart]);
    });
}
