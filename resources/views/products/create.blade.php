@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">

    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
        ➕ Add New Product
    </h2>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <input type="text" name="name" placeholder="Product Name"
                       class="p-2 border rounded w-full">

                <input type="text" name="sku" placeholder="SKU"
                       class="p-2 border rounded w-full">

                <input type="number" name="price" placeholder="Price"
                       class="p-2 border rounded w-full">

                <input type="number" name="quantity" placeholder="Stock"
                       class="p-2 border rounded w-full">

                <select name="category_id" class="p-2 border rounded w-full">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <input type="text" name="supplier" placeholder="Supplier"
                       class="p-2 border rounded w-full">

            </div>

            <textarea name="description" placeholder="Description"
                      class="w-full mt-4 p-2 border rounded"></textarea>

            <input type="file" name="image" class="mt-4">

            <button type="submit"
                    class="mt-6 bg-blue-600 text-white px-6 py-2 rounded">
                Save Product
            </button>

        </form>

    </div>

</div>

@endsection