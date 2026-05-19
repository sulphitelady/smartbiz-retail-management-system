@extends('layouts.app')

@section('content')

<div class="p-6 bg-white shadow rounded">

    <h2 class="text-xl font-bold mb-4">📄 Invoice Details</h2>

    <p><strong>Invoice:</strong> {{ $sale->invoice_number }}</p>
    <p><strong>Customer:</strong> {{ $sale->customer->name }}</p>
    <p><strong>Total:</strong> AED {{ $sale->total }}</p>
    <p><strong>Status:</strong> {{ $sale->status }}</p>
    <p><strong>Payment:</strong> {{ $sale->payment_method }}</p>
    <p><strong>Date:</strong> {{ $sale->created_at->format('d M Y') }}</p>

</div>

@endsection