@extends('layouts.app')

@section('content')

<h2 class="text-xl font-semibold mb-4 text-indigo-600">
    👥 Customers Module
</h2>

<a href="{{ route('customers.create') }}"
   class="bg-indigo-600 text-white px-4 py-2 rounded">
    + Add Customer
</a>

<div class="mt-6 bg-white shadow rounded-lg overflow-hidden">

<table class="w-full border-collapse">

    <thead class="bg-gray-800 text-white">
        <tr>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Phone</th>
            <th class="p-3 text-left">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($customers as $customer)
        <tr class="border-b">

            <td class="p-3">{{ $customer->name }}</td>
            <td class="p-3">{{ $customer->email }}</td>
            <td class="p-3">{{ $customer->phone }}</td>

            <td class="p-3 flex gap-3">

                {{-- VIEW --}}
                <a href="{{ route('customers.show', $customer->id) }}"
                   class="text-green-600">
                    View
                </a>

                {{-- EDIT --}}
                <a href="{{ route('customers.edit', $customer->id) }}"
                   class="text-blue-600">
                    Edit
                </a>

                {{-- DELETE --}}
                <form action="{{ route('customers.destroy', $customer->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this customer?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="text-red-600">
                        Delete
                    </button>

                </form>

            </td>

        </tr>
        @endforeach
    </tbody>

</table>

</div>

@endsection