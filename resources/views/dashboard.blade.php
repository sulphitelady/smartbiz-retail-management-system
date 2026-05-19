@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white p-8 rounded-2xl shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold">📊 SmartBiz Dashboard</h1>
                <p class="mt-2 text-sm opacity-90">
                    Welcome {{ auth()->user()->name }} ({{ auth()->user()->getRoleNames()->first() }})
                </p>
            </div>


        </div>

    </div>

    {{-- ================= ADMIN STATS ================= --}}
    @if(auth()->user()->hasRole('admin') && isset($users))

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm">Total Users</p>
            <h2 class="text-3xl font-bold">{{ $users['total'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border-l-4 border-green-500">
            <p class="text-gray-500 text-sm">Staff</p>
            <h2 class="text-3xl font-bold">{{ $users['staff'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border-l-4 border-purple-500">
            <p class="text-gray-500 text-sm">Managers</p>
            <h2 class="text-3xl font-bold">{{ $users['manager'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border-l-4 border-red-500">
            <p class="text-gray-500 text-sm">Pending</p>
            <h2 class="text-3xl font-bold text-red-500">{{ $users['pending'] ?? 0 }}</h2>
        </div>

    </div>

    @endif

    {{-- ================= BUSINESS STATS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-gray-500">Products</p>
            <h2 class="text-2xl font-bold">{{ $stats['total_products'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-gray-500">Customers</p>
            <h2 class="text-2xl font-bold">{{ $stats['total_customers'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-gray-500">Sales</p>
            <h2 class="text-2xl font-bold">{{ $stats['total_sales'] ?? 0 }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-gray-500">Revenue</p>
            <h2 class="text-2xl font-bold text-green-600">
                AED {{ number_format($stats['monthly_revenue'] ?? 0, 2) }}
            </h2>
        </div>

    </div>

    {{-- ================= CHART SECTION ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="font-semibold mb-4">📈 Monthly Revenue</h3>
            <canvas id="salesChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="font-semibold mb-4">📊 Category Distribution</h3>
            <canvas id="categoryChart"></canvas>
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

    new Chart(salesCanvas, {
        type: 'line',
        data: {
            labels: Object.keys(monthly),
            datasets: [{
                label: 'Revenue',
                data: Object.values(monthly),
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79,70,229,0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    new Chart(categoryCanvas, {
        type: 'doughnut',
        data: {
            labels: Object.keys(category),
            datasets: [{
                data: Object.values(category),
                backgroundColor: ['#4F46E5','#10B981','#F59E0B','#EF4444','#8B5CF6']
            }]
        }
    });

});
</script>
@endpush