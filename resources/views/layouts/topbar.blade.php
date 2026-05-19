<div class="bg-white border-b px-6 py-3 flex justify-between items-center">

    <!-- LEFT: Page Title -->
    <div class="font-semibold text-gray-800">
        Dashboard
    </div>

    <!-- RIGHT: User Menu -->
    <div class="flex items-center gap-4">

        <!-- 🔴 ADMIN PENDING USERS BADGE -->
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.users.pending') }}"
               class="relative text-sm text-indigo-600 hover:underline">

                User Approvals

                <span class="ml-2 px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">
                    {{ \App\Models\User::where('status','pending')->count() }}
                </span>
            </a>
        @endif

        <!-- USER NAME -->
        <span class="text-gray-600 text-sm">
            {{ auth()->user()->name }}
        </span>

        <!-- PROFILE -->
        <a href="{{ route('profile.edit') }}" class="text-sm text-indigo-600 hover:underline">
            Profile
        </a>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-red-500 hover:underline">
                Logout
            </button>
        </form>

    </div>

</div>