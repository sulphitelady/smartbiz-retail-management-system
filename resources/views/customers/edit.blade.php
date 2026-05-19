@extends('layouts.app')

@section('content')

<h2 class="text-xl font-semibold text-indigo-600 mb-4">
    ✏️ Edit Customer
</h2>

<div class="bg-white p-6 rounded shadow">

<form method="POST" action="{{ route('customers.update', $customer->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label>Name</label>
        <input type="text" name="name"
               value="{{ $customer->name }}"
               class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email"
               value="{{ $customer->email }}"
               class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label>Phone</label>
        <input type="text" name="phone"
               value="{{ $customer->phone }}"
               class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label>Address</label>
        <textarea name="address" class="w-full border p-2 rounded">
            {{ $customer->address }}
        </textarea>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Update Customer
    </button>

</form>

</div>

@endsection