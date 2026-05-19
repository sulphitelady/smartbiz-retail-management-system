@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">📦 Orders (Sales)</h2>

    <a href="{{ route('sales.create') }}"
   class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded">
    + Add Order
</a>
</div>

<div class="bg-white shadow rounded p-4">

<table class="w-full text-left border-collapse">
    <thead class="bg-gray-800 text-white">
        <tr>
            <th class="p-2">Invoice</th>
            <th class="p-2">Customer</th>
            <th class="p-2">Total</th>
            <th class="p-2">Status</th>
            <th class="p-2">Date</th>
            <th class="p-2">Actions</th>
        </tr>
    </thead>

    <tbody>
    @foreach($sales as $sale)
        <tr class="border-b">
            <td class="p-2">{{ $sale->invoice_number }}</td>
            <td class="p-2">{{ $sale->customer->name }}</td>
            <td class="p-2">{{ formatCurrency($sale->total) }}</td>
            <td class="p-2">
                <span class="px-2 py-1 text-sm rounded
                    {{ ($sale->status ?? 'completed') == 'cancelled' ? 'bg-red-200' : 'bg-green-200' }}">
                    {{ $sale->status ?? 'completed' }}
                </span>
            </td>
            <td class="p-2">{{ $sale->created_at->format('d M Y') }}</td>

            <td class="p-2 space-x-2">

                <a href="{{ route('sales.show', $sale->id) }}"
                   class="text-blue-600">View</a>

                <a href="{{ route('sales.edit', $sale->id) }}"
                   class="text-green-600">Edit</a>

                <form action="{{ route('sales.cancel', $sale->id) }}"
                      method="POST"
                      class="inline">
                    @csrf
                    <button class="text-red-600"
                            onclick="return confirm('Cancel this order?')">
                        Cancel
                    </button>
                </form>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>

@endsection