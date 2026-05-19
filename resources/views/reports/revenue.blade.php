@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    📆 Monthly Revenue - {{ $year }}
</h2>

@php

    // Convert collection into arrays
    $revenues = $monthly->pluck('revenue')->toArray();
    $months   = $monthly->pluck('month')->toArray();

    $max = !empty($revenues) ? max($revenues) : 0;

    $bestMonthIndex = array_search($max, $revenues);

    $bestMonth = $bestMonthIndex !== false
        ? date('F', mktime(0,0,0,$months[$bestMonthIndex],1))
        : 'N/A';

    $avg = count($revenues)
        ? array_sum($revenues) / count($revenues)
        : 0;

@endphp

{{-- INSIGHTS --}}
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 rounded-xl shadow mb-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div>
            <p class="text-sm opacity-80">Total Revenue</p>
            <h3 class="text-3xl font-bold">
                AED {{ number_format($total, 2) }}
            </h3>
        </div>

        <div>
            <p class="text-sm opacity-80">Best Month</p>
            <h3 class="text-3xl font-bold">
                {{ $bestMonth }}
            </h3>
        </div>

        <div>
            <p class="text-sm opacity-80">Average Monthly Revenue</p>
            <h3 class="text-3xl font-bold">
                AED {{ number_format($avg, 2) }}
            </h3>
        </div>

    </div>

</div>

{{-- CHART --}}
<div class="bg-white p-6 rounded-xl shadow">

    <div class="flex justify-between items-center mb-4">

        <div>
            <h3 class="text-lg font-semibold">
                📈 Revenue Analytics
            </h3>

            <p class="text-sm text-gray-500">
                Monthly sales performance overview
            </p>
        </div>

        <a href="{{ route('reports.revenue.csv') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
            Export CSV
        </a>

    </div>

    <div class="h-[420px]">
        <canvas id="revenueChart"></canvas>
    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const revenueData = @json($monthly->values());

    console.log(revenueData);

    const labels = revenueData.map(item => {

        const months = [
            "Jan","Feb","Mar","Apr","May","Jun",
            "Jul","Aug","Sep","Oct","Nov","Dec"
        ];

        return months[item.month - 1];

    });

    const revenues = revenueData.map(item => item.revenue);

    const ctx = document.getElementById('revenueChart');

    if (!ctx) {
        console.error("Canvas not found");
        return;
    }

    new Chart(ctx, {

        type: 'line',

        data: {
            labels: labels,

            datasets: [{
                label: 'Revenue (AED)',
                data: revenues,

                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79,70,229,0.15)',

                fill: true,
                tension: 0.4,
                borderWidth: 4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: true
                }
            },

            scales: {

                y: {
                    beginAtZero: true,

                    ticks: {
                        callback: function(value) {
                            return 'AED ' + value;
                        }
                    }
                }

            }

        }

    });

});

</script>

@endpush
