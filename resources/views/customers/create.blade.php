@extends('layouts.app')

@section('content')

<h2 class="text-xl font-semibold text-indigo-600 mb-4">
    ➕ Add New Customer
</h2>

<div class="bg-white p-6 rounded shadow">

<form method="POST" action="{{ route('customers.store') }}">
    @csrf

    <div class="mb-4">
        <label class="block mb-1">Name</label>
        <input type="text" name="name" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1">Phone</label>
        <input type="text" name="phone" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Address</label>
        <textarea name="address" class="w-full border p-2 rounded"></textarea>
    </div>

    <button class="bg-indigo-600 text-white px-4 py-2 rounded">
        Save Customer
    </button>

</form>

</div>

@endsection