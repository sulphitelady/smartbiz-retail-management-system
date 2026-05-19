@extends('layouts.app')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-bold mb-4">Profile</h2>

    <!-- USER INFO CARD -->
    <div class="bg-white p-4 rounded shadow mb-6">

        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

        <p class="mt-2">
    <strong>Role:</strong>
    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded">
        {{ auth()->user()->getRoleNames()->first() ?? 'No Role Assigned' }}
    </span>
</p>

    </div>

    <!-- PROFILE FORMS -->
    <div class="space-y-6">

        @include('profile.partials.update-profile-information-form')

        @include('profile.partials.update-password-form')

        @include('profile.partials.delete-user-form')

    </div>

</div>

@endsection