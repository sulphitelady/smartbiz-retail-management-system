@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                📊 Daily Sales Report
            </h2>

            <p class="text-gray-500">
                Daily / filtered sales analytics
            </p>
        </div>

        {{-- CSV EXPORT (WITH FILTERS) --}}
        <a href="{{ route('reports.sales.csv', request()->query()) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow">
            Export CSV
        </a>

    </div>

    {{-- FILTER --}}
    <div class="bg-white p-5 rounded-xl shadow">

        <form method="GET"
              action="{{ route('reports.sales') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">From Date</label>
                <input type="date"
                       name="date_from"
                       value="{{ request('date_from') }}"
                       class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">To Date</label>
                <input type="date"
                       name="date_to"
                       value="{{ request('date_to') }}"
                       class="w-full border rounded-lg p-2">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg w-full">
                    Filter Report
                </button>
            </div>

        </form>

    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white p-5 rounded-xl shadow">
            <p class="text-sm opacity-80">Total Revenue</p>
            <h3 class="text-3xl font-bold">
                AED {{ number_format($stats['revenue'], 2) }}
            </h3>
        </div>

        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-5 rounded-xl shadow">
            <p class="text-sm opacity-80">Total Orders</p>
            <h3 class="text-3xl font-bold">
                {{ $stats['total'] }}
            </h3>
        </div>

        <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-5 rounded-xl shadow">
            <p class="text-sm opacity-80">Average Order</p>
            <h3 class="text-3xl font-bold">
                AED {{ number_format($stats['avg_order'], 2) }}
            </h3>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-5 border-b">
            <h3 class="text-lg font-semibold">🧾 Sales Transactions</h3>
        </div>

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="text-left p-4">Time</th>
                    <th class="text-left p-4">Customer</th>
                    <th class="text-left p-4">Amount</th>
                    <th class="text-left p-4">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

            @forelse($sales as $sale)

                <tr class="hover:bg-gray-50 transition">

                    <td class="p-4">
                        {{ $sale->created_at->format('d M Y - h:i A') }}
                    </td>

                    <td class="p-4 font-medium">
                        {{ $sale->customer->name ?? 'Walk-in Customer' }}
                    </td>

                    <td class="p-4 font-semibold text-green-600">
                        AED {{ number_format($sale->total, 2) }}
                    </td>

                    <td class="p-4">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            Completed
                        </span>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center py-10 text-gray-500">
                        No sales available
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection