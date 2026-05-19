<aside class="w-72 min-h-screen bg-[#0f172a] border-r border-slate-800 shadow-2xl flex flex-col">

    {{-- ================= LOGO ================= --}}
    <div class="p-6 border-b border-slate-800">

        <h1 class="text-3xl font-extrabold text-indigo-400 tracking-wide">
            SmartBiz
        </h1>

        <p class="text-slate-400 text-sm mt-1 capitalize">
            {{ auth()->user()->getRoleNames()->first() }}
        </p>

    </div>


    {{-- ================= NAVIGATION ================= --}}
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">📊</span>
            <span class="font-medium">Dashboard</span>

        </a>


        {{-- ================= ADMIN MENU ================= --}}
        @role('admin')

        {{-- USER APPROVALS --}}
        <a href="{{ route('admin.users.pending') }}"
           class="flex items-center justify-between px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <div class="flex items-center gap-3">
                <span class="text-lg">👥</span>
                <span class="font-medium">User Approvals</span>
            </div>

            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                {{ \App\Models\User::where('status','pending')->count() }}
            </span>

        </a>

        {{-- PRODUCTS --}}
        <a href="{{ route('products.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">📦</span>
            <span class="font-medium">Products</span>

        </a>

        {{-- CUSTOMERS --}}
        <a href="{{ route('customers.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">👤</span>
            <span class="font-medium">Customers</span>

        </a>

        {{-- SALES --}}
        <a href="{{ route('sales.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">🧾</span>
            <span class="font-medium">Sales</span>

        </a>

        {{-- INVENTORY --}}
        <a href="{{ route('inventory') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">📊</span>
            <span class="font-medium">Inventory</span>

        </a>

        {{-- REPORTS --}}
        <a href="{{ route('reports') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">📈</span>
            <span class="font-medium">Reports</span>

        </a>

        {{-- SETTINGS --}}
        <a href="{{ route('settings') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">⚙️</span>
            <span class="font-medium">Settings</span>

        </a>

        @endrole



        {{-- ================= MANAGER MENU ================= --}}
        @role('manager')

        <a href="{{ route('products.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">📦</span>
            <span class="font-medium">Products</span>

        </a>

        <a href="{{ route('customers.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">👤</span>
            <span class="font-medium">Customers</span>

        </a>

        <a href="{{ route('sales.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">🧾</span>
            <span class="font-medium">Sales</span>

        </a>

        <a href="{{ route('inventory') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">📊</span>
            <span class="font-medium">Inventory</span>

        </a>

        <a href="{{ route('reports') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">📈</span>
            <span class="font-medium">Reports</span>

        </a>

        @endrole



        {{-- ================= STAFF MENU ================= --}}
        @role('staff')

        <a href="{{ route('customers.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">👤</span>
            <span class="font-medium">Customers</span>

        </a>

        <a href="{{ route('sales.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">

            <span class="text-lg">🧾</span>
            <span class="font-medium">Sales</span>

        </a>

        @endrole

    </nav>


    {{-- ================= FOOTER ================= --}}
    <div class="p-4 border-t border-slate-800">

        <div class="bg-slate-800 rounded-xl p-4">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">

                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                </div>

                <div>

                    <p class="text-white font-semibold text-sm">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-slate-400 text-xs">
                        {{ auth()->user()->email }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</aside>