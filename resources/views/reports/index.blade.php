@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            📊 Reports Dashboard
        </h1>
        <p class="text-gray-500">
            Business insights and analytics overview
        </p>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- DAILY SALES --}}
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-lg font-semibold mb-2">📅 Daily Sales</h3>
            <p class="text-gray-500 mb-4">
                View today's sales transactions and totals.
            </p>

            <a href="{{ route('reports.sales') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Open Report
            </a>
        </div>

        {{-- MONTHLY SALES --}}
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-lg font-semibold mb-2">📈 Monthly Sales</h3>
            <p class="text-gray-500 mb-4">
                Track revenue trends and monthly performance.
            </p>

            <a href="{{ route('reports.revenue') }}"
               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Open Report
            </a>
        </div>

        {{-- INVENTORY --}}
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-lg font-semibold mb-2">📦 Inventory Valuation</h3>
            <p class="text-gray-500 mb-4">
                Check stock value and product inventory status.
            </p>

            <a href="{{ route('reports.inventory') }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Open Report
            </a>
        </div>

        {{-- TOP PRODUCTS --}}
<div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <h3 class="text-lg font-semibold mb-2">🏆 Top Products</h3>
    <p class="text-gray-500 mb-4">
        View best-selling products and performance.
    </p>

    <a href="{{ route('reports.top-products') }}"
       class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
        Open Report
    </a>
</div>

{{-- TOP CUSTOMERS --}}
<div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <h3 class="text-lg font-semibold mb-2">👥 Top Customers</h3>
    <p class="text-gray-500 mb-4">
        View highest spending customers and purchase history.
    </p>

    <a href="{{ route('reports.customers') }}"
       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        Open Report
    </a>
</div>

    </div>

</div>

@endsection