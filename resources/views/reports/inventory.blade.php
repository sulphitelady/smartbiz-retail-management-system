@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                📦 Inventory Valuation Report
            </h1>

            <p class="text-gray-500">
                Stock overview, valuation & product status
            </p>
        </div>

        {{-- EXPORT BUTTON --}}
        <a href="{{ route('reports.inventory.csv') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow">
            Export CSV
        </a>

    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Total Products</p>
            <h2 class="text-2xl font-bold text-indigo-600">
                {{ $stats['total'] }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Low Stock</p>
            <h2 class="text-2xl font-bold text-yellow-500">
                {{ $stats['low_stock'] }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Inventory Value</p>
            <h2 class="text-2xl font-bold text-green-600">
                AED {{ number_format($stats['value'], 2) }}
            </h2>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-3 text-left">Product</th>
                    <th class="p-3 text-left">SKU</th>
                    <th class="p-3 text-left">Qty</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Value</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>

            <tbody>

            @foreach($products as $product)

                @php
                    $value = $product->price * $product->quantity;
                @endphp

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3 font-medium">
                        {{ $product->name }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $product->sku }}
                    </td>

                    <td class="p-3">
                        {{ $product->quantity }}
                    </td>

                    <td class="p-3">
                        AED {{ number_format($product->price, 2) }}
                    </td>

                    <td class="p-3 font-semibold">
                        AED {{ number_format($value, 2) }}
                    </td>

                    <td class="p-3">

                        @if($product->quantity == 0)
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded">
                                Out of Stock
                            </span>

                        @elseif($product->quantity <= 10)
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                Low Stock
                            </span>

                        @else
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                In Stock
                            </span>
                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection