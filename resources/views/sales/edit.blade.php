@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto bg-white shadow p-6 rounded">

    <h2 class="text-xl font-bold mb-4">✏️ Edit Order</h2>

    <form method="POST" action="{{ route('sales.update', $sale->id) }}">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-semibold">Status</label>

        <select name="status" class="border p-2 w-full rounded mb-4">

            <option value="pending" {{ $sale->status=='pending'?'selected':'' }}>
                Pending
            </option>

            <option value="completed" {{ $sale->status=='completed'?'selected':'' }}>
                Completed
            </option>

            <option value="cancelled" {{ $sale->status=='cancelled'?'selected':'' }}>
                Cancelled
            </option>

        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Order
        </button>

    </form>

</div>

@endsection