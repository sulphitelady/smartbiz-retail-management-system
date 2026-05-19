@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-6 space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-3xl font-bold text-gray-800">
            🏆 Top Products
        </h2>
        <p class="text-gray-500">
            Best selling products based on sales performance
        </p>
    </div>

    {{-- KPI --}}
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Total Products in Report</p>
        <h2 class="text-2xl font-bold text-indigo-600">
            {{ $products->count() }}
        </h2>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-3 text-left">Rank</th>
                    <th class="p-3 text-left">Product</th>
                    <th class="p-3 text-left">Units Sold</th>
                    <th class="p-3 text-left">Revenue</th>
                    <th class="p-3 text-left">Performance</th>
                </tr>
            </thead>

            <tbody>

            @forelse($products as $index => $p)

                <tr class="border-b hover:bg-gray-50 transition">

                    {{-- Rank --}}
                    <td class="p-3 font-bold text-gray-600">
                        #{{ $index + 1 }}
                    </td>

                    {{-- Product --}}
                    <td class="p-3 font-medium text-gray-800">
                        {{ $p->product->name ?? 'Unknown' }}
                    </td>

                    {{-- Units --}}
                    <td class="p-3">
                        {{ $p->total_qty }}
                    </td>

                    {{-- Revenue --}}
                    <td class="p-3 font-semibold text-green-600">
                        AED {{ number_format($p->revenue, 2) }}
                    </td>

                    {{-- Badge --}}
                    <td class="p-3">

                        @if($p->total_qty > 50)
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                🔥 Best Seller
                            </span>

                        @elseif($p->total_qty > 20)
                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                                ⭐ Popular
                            </span>

                        @else
                            <span class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                                Low Sales
                            </span>
                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-500">
                        No product sales found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection