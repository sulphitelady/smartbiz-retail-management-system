@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                🏆 Top Customers
            </h2>
            <p class="text-gray-500">
                Customers ranked by total purchases
            </p>
        </div>

    </div>

    {{-- KPI CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Total Customers</p>
            <h2 class="text-2xl font-bold text-indigo-600">
                {{ $stats['total'] }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Total Purchases</p>
            <h2 class="text-2xl font-bold text-green-600">
                {{ $stats['purchases'] }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Top Spender</p>
            <h2 class="text-2xl font-bold text-purple-600">
                AED {{ number_format($stats['top_spender'], 2) }}
            </h2>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-5 border-b">
            <h3 class="text-lg font-semibold text-gray-700">
                Customer Rankings
            </h3>
        </div>

        <table class="w-full text-sm">

            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-3 text-left">Rank</th>
                    <th class="p-3 text-left">Customer</th>
                    <th class="p-3 text-left">Purchases</th>
                    <th class="p-3 text-left">Total Spend</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>

            <tbody>

            @foreach($customers as $index => $c)

                <tr class="border-b hover:bg-gray-50 transition">

                    {{-- Rank --}}
                    <td class="p-3 font-bold text-gray-600">
                        #{{ $index + 1 }}
                    </td>

                    {{-- Name --}}
                    <td class="p-3 font-medium text-gray-800">
                        {{ $c->name }}
                    </td>

                    {{-- Purchases --}}
                    <td class="p-3">
                        {{ $c->sales_count }}
                    </td>

                    {{-- Total Spend --}}
                    <td class="p-3 font-semibold text-green-600">
                        AED {{ number_format($c->sales_sum_total, 2) }}
                    </td>

                    {{-- Badge --}}
                    <td class="p-3">

                        @if($c->sales_sum_total > 5000)
                            <span class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">
                                VIP Customer
                            </span>

                        @elseif($c->sales_sum_total > 2000)
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                Regular
                            </span>

                        @else
                            <span class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                                New
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