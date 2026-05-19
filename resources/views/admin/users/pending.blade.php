@extends('layouts.app')

@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">
        🟡 Pending User Approvals
    </h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-hidden">

        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr class="border-t">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>

                        <td class="p-3 flex gap-2">

                            <!-- APPROVE -->
                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded">
                                    Approve
                                </button>
                            </form>

                            <!-- REJECT -->
                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    Reject
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No pending users
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection