@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            📦 Products Module
        </h2>

        <a href="{{ route('products.create') }}"
           class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Add Product
        </a>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500">Total Products</p>
            <h3 class="text-xl font-bold text-indigo-600">{{ $invStats['total'] }}</h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500">Low Stock</p>
            <h3 class="text-xl font-bold text-yellow-500">{{ $invStats['low'] }}</h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500">Out of Stock</p>
            <h3 class="text-xl font-bold text-red-500">{{ $invStats['out'] }}</h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-gray-500">Stock Value</p>
            <h3 class="text-xl font-bold text-green-500">
                ${{ number_format($invStats['value'] ?? 0, 2) }}
            </h3>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            {{-- HEADER --}}
            <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                <tr>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">SKU</th>
                    <th class="p-4 text-left">Price</th>
                    <th class="p-4 text-left">Stock</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y divide-gray-200">

            @foreach($products as $product)

                <tr class="hover:bg-gray-50 transition">

                    <td class="p-4 font-medium text-gray-800">
                        {{ $product->name }}
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ $product->sku }}
                    </td>

                    <td class="p-4">
                        ${{ number_format($product->price, 2) }}
                    </td>

                    <td class="p-4">
                        {{ $product->quantity }}
                    </td>

                    {{-- STATUS --}}
                    <td class="p-4">

                        @if($product->quantity == 0)
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">
                                Out of Stock
                            </span>

                        @elseif($product->quantity <= 10)
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                Low Stock
                            </span>

                        @else
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                In Stock
                            </span>
                        @endif

                    </td>

                    {{-- ACTIONS --}}
                    <td class="p-4 text-center">

                        <div class="flex justify-center items-center gap-2">

                            <a href="{{ route('products.edit', $product->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('products.destroy', $product->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection