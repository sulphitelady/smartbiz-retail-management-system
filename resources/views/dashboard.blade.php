@extends('layouts.app')

@section('content')

<div class="space-y-4 h-[calc(100vh-80px)] overflow-hidden">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white p-5 rounded-2xl shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-2xl font-bold">📊 SmartBiz Dashboard</h1>

                <p class="mt-1 text-sm opacity-90">
                    Welcome {{ auth()->user()->name }}
                    ({{ auth()->user()->getRoleNames()->first() }})
                </p>
            </div>

        </div>

    </div>

    {{-- ================= ADMIN STATS ================= --}}
    @if(auth()->user()->hasRole('admin') && isset($users))

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded-xl shadow border-l-4 border-blue-500">
            <p class="text-gray-500 text-xs">Total Users</p>
            <h2 class="text-2xl font-bold">{{ $users['total'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow border-l-4 border-green-500">
            <p class="text-gray-500 text-xs">Staff</p>
            <h2 class="text-2xl font-bold">{{ $users['staff'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow border-l-4 border-purple-500">
            <p class="text-gray-500 text-xs">Managers</p>
            <h2 class="text-2xl font-bold">{{ $users['manager'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow border-l-4 border-red-500">
            <p class="text-gray-500 text-xs">Pending</p>
            <h2 class="text-2xl font-bold text-red-500">
                {{ $users['pending'] ?? 0 }}
            </h2>
        </div>

    </div>

    @endif

    {{-- ================= BUSINESS STATS ================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Products</p>
            <h2 class="text-2xl font-bold">
                {{ $stats['total_products'] ?? 0 }}
            </h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Customers</p>
            <h2 class="text-2xl font-bold">
                {{ $stats['total_customers'] ?? 0 }}
            </h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Sales</p>
            <h2 class="text-2xl font-bold">
                {{ $stats['total_sales'] ?? 0 }}
            </h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Revenue</p>

            <h2 class="text-2xl font-bold text-green-600">
                AED {{ number_format($stats['monthly_revenue'] ?? 0, 2) }}
            </h2>
        </div>

    </div>

    {{-- ================= CHARTS ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 flex-1">

        {{-- Revenue Chart --}}
        <div class="bg-white p-4 rounded-2xl shadow h-[320px]">

            <h3 class="font-semibold mb-2 text-sm">
                📈 Monthly Revenue
            </h3>

            <div class="h-[250px]">
                <canvas id="salesChart"></canvas>
            </div>

        </div>

        {{-- Category Chart --}}
        <div class="bg-white p-4 rounded-2xl shadow h-[320px]">

            <h3 class="font-semibold mb-2 text-sm">
                📊 Category Distribution
            </h3>

            <div class="h-[250px]">
                <canvas id="categoryChart"></canvas>
            </div>

        </div>

    </div>

</div>

@endsection


{{-- ================= CHART JS ================= --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const monthly = @json($monthlyRevenue ?? []);
    const category = @json($categoryStats ?? []);

    const salesCanvas = document.getElementById('salesChart');
    const categoryCanvas = document.getElementById('categoryChart');

    if (!salesCanvas || !categoryCanvas) return;

    // ================= BAR CHART =================
    new Chart(salesCanvas, {

        type: 'bar',

        data: {
            labels: Object.keys(monthly),

            datasets: [{
                label: 'Revenue (AED)',
                data: Object.values(monthly),

                backgroundColor: '#4F46E5',
                borderRadius: 10,
                barThickness: 40
            }]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    });

    // ================= DOUGHNUT CHART =================
    new Chart(categoryCanvas, {

        type: 'doughnut',

        data: {
            labels: Object.keys(category),

            datasets: [{
                data: Object.values(category),

                backgroundColor: [
                    '#4F46E5',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444',
                    '#8B5CF6'
                ]
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false
        }

    });

});
</script>

@endpush