<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">

                <!-- LOGO -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- LINKS -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    {{-- ADMIN APPROVAL LINK --}}
                    @if(auth()->user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.users.pending')">
                            User Approvals

                            {{-- 🔴 BADGE --}}
                            <span class="ml-2 px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">
                                {{ \App\Models\User::where('status','pending')->count() }}
                            </span>
                        </x-nav-link>
                    @endif

                    {{-- CUSTOMERS --}}
                    @if(auth()->user()->hasAnyRole(['admin','manager','staff']))
                        <x-nav-link href="/customers">Customers</x-nav-link>
                    @endif

                    {{-- PRODUCTS --}}
                    @if(auth()->user()->hasRole('admin'))
                        <x-nav-link href="/products">Products</x-nav-link>
                    @endif

                    {{-- SALES --}}
                    @if(auth()->user()->hasAnyRole(['admin','manager','staff']))
                        <x-nav-link href="/sales">Sales</x-nav-link>
                    @endif

                    {{-- INVENTORY --}}
                    @if(auth()->user()->hasAnyRole(['admin','manager']))
                        <x-nav-link href="/inventory">Inventory</x-nav-link>
                    @endif

                    {{-- REPORTS --}}
                    @if(auth()->user()->hasAnyRole(['admin','manager']))
                        <x-nav-link href="/reports">Reports</x-nav-link>
                    @endif

                    {{-- SETTINGS --}}
                    @if(auth()->user()->hasRole('admin'))
                        <x-nav-link href="/settings">Settings</x-nav-link>
                    @endif

                </div>

            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center justify-center w-10 h-10 rounded-full focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md hover:scale-105 transition">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <div class="px-4 py-2 text-sm text-gray-700">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="px-4 py-2 text-xs text-gray-500">
                            {{ Auth::user()->email }}
                        </div>

                        <hr>

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- MOBILE BUTTON -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900">

                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            {{-- ADMIN APPROVAL MOBILE --}}
            @if(auth()->user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.users.pending')">
                    User Approvals
                    <span class="ml-2 px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">
                        {{ \App\Models\User::where('status','pending')->count() }}
                    </span>
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasAnyRole(['admin','manager','staff']))
                <x-responsive-nav-link href="/customers">Customers</x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <x-responsive-nav-link href="/products">Products</x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasAnyRole(['admin','manager','staff']))
                <x-responsive-nav-link href="/sales">Sales</x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasAnyRole(['admin','manager']))
                <x-responsive-nav-link href="/inventory">Inventory</x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasAnyRole(['admin','manager']))
                <x-responsive-nav-link href="/reports">Reports</x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <x-responsive-nav-link href="/settings">Settings</x-responsive-nav-link>
            @endif

        </div>

        <!-- MOBILE PROFILE -->
        <div class="pt-4 pb-1 border-t">

            <div class="px-4 text-sm">
                {{ Auth::user()->name }}
            </div>

            <div class="px-4 text-xs text-gray-500">
                {{ Auth::user()->email }}
            </div>

        </div>

    </div>

</nav>