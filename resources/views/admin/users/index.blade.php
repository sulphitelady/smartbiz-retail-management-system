@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                User Approval Panel
            </h1>

            <p class="text-gray-500 mt-1">
                Approve or reject newly registered users
            </p>
        </div>

        <!-- PENDING COUNT -->
        <div class="flex items-center gap-2 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg">

            <span class="font-semibold text-sm">
                Pending Users
            </span>

            <span class="bg-white text-red-600 font-bold px-3 py-1 rounded-full text-sm shadow">
                {{ $users->count() }}
            </span>

        </div>

    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <!-- HEAD -->
                <thead class="bg-gray-200 dark:bg-gray-700">

                    <tr>
                        <th class="text-left p-4">User</th>
                        <th class="text-left p-4">Email</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-center p-4">Actions</th>
                    </tr>

                </thead>

                <!-- BODY -->
                <tbody>

                @forelse($users as $user)

                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                        <!-- USER -->
                        <td class="p-4 flex items-center gap-3">

                            <div class="w-10 h-10 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div>
                                <div class="font-semibold text-gray-800 dark:text-white">
                                    {{ $user->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    ID: {{ $user->id }}
                                </div>
                            </div>

                        </td>

                        <!-- EMAIL -->
                        <td class="p-4 text-gray-700 dark:text-gray-300">
                            {{ $user->email }}
                        </td>

                        <!-- STATUS -->
                        <td class="p-4">

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-500 text-white">
                                Pending
                            </span>

                        </td>

                        <!-- ACTIONS -->
                        <td class="p-4 text-center">

                            <!-- APPROVE -->
                            <form method="POST"
                                  action="{{ route('admin.users.approve', $user->id) }}"
                                  class="inline-block">

                                @csrf

                                <select name="role"
                                        class="border rounded px-2 py-1 text-sm">

                                    <option value="staff">Staff</option>
                                    <option value="manager">Manager</option>
                                    <option value="admin">Admin</option>

                                </select>

                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded ml-2">
                                    Approve
                                </button>

                            </form>

                            <!-- REJECT -->
                            <form method="POST"
                                  action="{{ route('admin.users.reject', $user->id) }}"
                                  class="inline-block ml-2">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                    Reject
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-500">
                            No pending users found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection