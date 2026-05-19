@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto bg-white shadow p-6 rounded">

    <h2 class="text-xl font-bold mb-4">✏️ Edit Product</h2>

    <form method="POST" action="{{ route('products.update', $product->id) }}">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <label class="block mb-1 font-semibold">Product Name</label>
        <input type="text" name="name"
               value="{{ $product->name }}"
               class="border p-2 w-full rounded mb-3">

        {{-- SKU --}}
        <label class="block mb-1 font-semibold">SKU</label>
        <input type="text" name="sku"
               value="{{ $product->sku }}"
               class="border p-2 w-full rounded mb-3">

        {{-- Category --}}
        <label class="block mb-1 font-semibold">Category</label>
        <select name="category_id" class="border p-2 w-full rounded mb-3">
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        {{-- Price --}}
        <label class="block mb-1 font-semibold">Price</label>
        <input type="number" name="price"
               value="{{ $product->price }}"
               class="border p-2 w-full rounded mb-3">

        {{-- Quantity --}}
        <label class="block mb-1 font-semibold">Quantity</label>
        <input type="number" name="quantity"
               value="{{ $product->quantity }}"
               class="border p-2 w-full rounded mb-3">

        {{-- Supplier --}}
        <label class="block mb-1 font-semibold">Supplier</label>
        <input type="text" name="supplier"
               value="{{ $product->supplier }}"
               class="border p-2 w-full rounded mb-3">

        {{-- Description --}}
        <label class="block mb-1 font-semibold">Description</label>
        <textarea name="description"
                  class="border p-2 w-full rounded mb-4">{{ $product->description }}</textarea>

        {{-- Button --}}
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Product
        </button>

    </form>

</div>

@endsection