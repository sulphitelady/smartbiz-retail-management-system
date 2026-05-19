@extends('layouts.app')

@section('content')

<h2 class="text-xl font-semibold text-indigo-600 mb-4">
    👤 Customer Profile
</h2>

{{-- ================= CUSTOMER INFO ================= --}}
<div class="bg-white p-6 rounded shadow">

    <p><strong>Name:</strong> {{ $customer->name }}</p>
    <p><strong>Email:</strong> {{ $customer->email }}</p>
    <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
    <p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>

</div>

{{-- ================= SALES HISTORY ================= --}}
<h3 class="mt-6 text-lg font-semibold">📊 Sales History</h3>

<div class="bg-white mt-3 p-4 rounded shadow">

@if(isset($customer->sales) && $customer->sales->count() > 0)

<table class="w-full border-collapse">

    <thead class="bg-gray-800 text-white">
        <tr>
            <th class="p-2 text-left">Invoice</th>
            <th class="p-2 text-left">Products</th>
            <th class="p-2 text-left">Total</th>
            <th class="p-2 text-left">Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($customer->sales as $sale)
        <tr class="border-b">

            <td class="p-2">
                {{ $sale->invoice_number }}
            </td>

            <td class="p-2">
                @if(isset($sale->items) && $sale->items->count() > 0)
                    @foreach($sale->items as $item)
                        {{ $item->product->name ?? 'Unknown Product' }}
                        ({{ $item->quantity }})<br>
                    @endforeach
                @else
                    No items
                @endif
            </td>

            <td class="p-2">
                ${{ number_format($sale->total, 2) }}
            </td>

            <td class="p-2">
                {{ optional($sale->created_at)->format('d M Y') }}
            </td>

        </tr>
        @endforeach
    </tbody>

</table>

@else
    <p class="text-gray-500">No sales found for this customer.</p>
@endif

</div>

@endsection