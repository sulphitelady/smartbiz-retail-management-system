@extends('layouts.app')

@section('content')

<h2 class="text-xl font-semibold mb-4">➕ Create New Order</h2>

<form method="POST" action="{{ route('sales.store') }}">
@csrf

{{-- Customer --}}
<div class="mb-4">
    <label>Customer</label>
    <select name="customer_id" class="border p-2 w-full" required>
        <option value="">Select Customer</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>
</div>

{{-- Products --}}
{{-- Products --}}
<h3 class="font-semibold mb-3">Products</h3>

@foreach($products as $product)

<div class="flex gap-3 mb-3 items-center border p-3 rounded">

    <input type="hidden"
           name="items[{{ $loop->index }}][product_id]"
           value="{{ $product->id }}">

    <div class="w-52">
        <strong>{{ $product->name }}</strong><br>
        <small>AED {{ $product->price }}</small>
    </div>

    <input type="number"
           name="items[{{ $loop->index }}][quantity]"
           min="0"
           value="0"
           class="border p-2 w-24 rounded">

</div>

@endforeach

{{-- Discount --}}
<div class="mt-4">
    <label>Discount (%)</label>
    <input type="number" name="discount" class="border p-2 w-full">
</div>

{{-- Payment --}}
<div class="mt-4">
    <label>Payment Method</label>
    <select name="payment_method" class="border p-2 w-full" required>
        <option value="cash">Cash</option>
        <option value="card">Card</option>
        <option value="transfer">Bank Transfer</option>
    </select>
</div>

{{-- Notes --}}
<div class="mt-4">
    <label>Notes</label>
    <textarea name="notes" class="border p-2 w-full"></textarea>
</div>

{{-- Submit --}}
<button class="bg-blue-600 text-white px-4 py-2 mt-4 rounded">
    Save Order
</button>

</form>

@endsection