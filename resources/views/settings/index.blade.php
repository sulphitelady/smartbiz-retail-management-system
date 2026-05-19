@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#0f172a] p-8 text-white">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

        <div>
            <h1 class="text-4xl font-bold tracking-tight">
                ⚙️ System Settings
            </h1>

            <p class="text-slate-400 mt-2">
                Configure your SmartBiz application preferences and business settings
            </p>
        </div>

        {{-- STATUS BADGE --}}
        <div class="mt-4 md:mt-0">

            <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-4 py-2 rounded-xl text-sm font-semibold">
                System Active
            </span>

        </div>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>

    @endif

    {{-- ================= SETTINGS GRID ================= --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- ================= LEFT SIDE ================= --}}
        <div class="xl:col-span-2">

            <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="border-b border-slate-800 px-8 py-6">

                    <h2 class="text-2xl font-bold">
                        Business Configuration
                    </h2>

                    <p class="text-slate-400 mt-1 text-sm">
                        Update your company information and financial preferences
                    </p>

                </div>

                {{-- FORM --}}
                <form method="POST" action="#" class="p-8 space-y-8">

                    @csrf

                    {{-- BUSINESS INFO --}}
                    <div>

                        <h3 class="text-lg font-semibold mb-5 text-indigo-400">
                            🏢 Business Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- BUSINESS NAME --}}
                            <div>

                                <label class="block text-slate-300 mb-2 text-sm font-medium">
                                    Business Name
                                </label>

                                <input type="text"
                                       name="business_name"
                                       placeholder="SmartBiz Solutions"
                                       class="w-full bg-slate-800 border border-slate-700 rounded-2xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            </div>

                            {{-- EMAIL --}}
                            <div>

                                <label class="block text-slate-300 mb-2 text-sm font-medium">
                                    Business Email
                                </label>

                                <input type="email"
                                       name="email"
                                       placeholder="admin@smartbiz.com"
                                       class="w-full bg-slate-800 border border-slate-700 rounded-2xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            </div>

                        </div>

                    </div>

                    {{-- FINANCIAL SETTINGS --}}
                    <div>

                        <h3 class="text-lg font-semibold mb-5 text-green-400">
                            💰 Financial Settings
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            {{-- CURRENCY --}}
                            <div>

                                <label class="block text-slate-300 mb-2 text-sm font-medium">
                                    Currency
                                </label>

                                <select name="currency"
                                        class="w-full bg-slate-800 border border-slate-700 rounded-2xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                    <option>AED</option>
                                    <option>USD</option>
                                    <option>EUR</option>
                                    <option>GBP</option>

                                </select>

                            </div>

                            {{-- TAX --}}
                            <div>

                                <label class="block text-slate-300 mb-2 text-sm font-medium">
                                    Tax Rate %
                                </label>

                                <input type="number"
                                       name="tax_rate"
                                       placeholder="5"
                                       class="w-full bg-slate-800 border border-slate-700 rounded-2xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            </div>

                            {{-- TIMEZONE --}}
                            <div>

                                <label class="block text-slate-300 mb-2 text-sm font-medium">
                                    Timezone
                                </label>

                                <select name="timezone"
                                        class="w-full bg-slate-800 border border-slate-700 rounded-2xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                    <option>Asia/Dubai</option>
                                    <option>UTC</option>
                                    <option>Europe/London</option>

                                </select>

                            </div>

                        </div>

                    </div>

                    {{-- SECURITY --}}
                    <div>

                        <h3 class="text-lg font-semibold mb-5 text-red-400">
                            🔐 Security Preferences
                        </h3>

                        <div class="space-y-4">

                            {{-- OPTION --}}
                            <label class="flex items-center justify-between bg-slate-800 border border-slate-700 rounded-2xl p-4 cursor-pointer">

                                <div>
                                    <p class="font-medium">
                                        Enable User Approval
                                    </p>

                                    <p class="text-slate-400 text-sm">
                                        New users require admin approval
                                    </p>
                                </div>

                                <input type="checkbox" checked
                                       class="w-5 h-5 accent-indigo-500">

                            </label>

                            {{-- OPTION --}}
                            <label class="flex items-center justify-between bg-slate-800 border border-slate-700 rounded-2xl p-4 cursor-pointer">

                                <div>
                                    <p class="font-medium">
                                        Email Notifications
                                    </p>

                                    <p class="text-slate-400 text-sm">
                                        Receive alerts for system updates
                                    </p>
                                </div>

                                <input type="checkbox"
                                       class="w-5 h-5 accent-indigo-500">

                            </label>

                        </div>

                    </div>

                    {{-- SAVE --}}
                    <div class="pt-4 border-t border-slate-800">

                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 px-8 py-4 rounded-2xl font-semibold text-white shadow-lg transition duration-300">

                            Save Changes

                        </button>

                    </div>

                </form>

            </div>

        </div>

        {{-- ================= RIGHT SIDE ================= --}}
        <div class="space-y-6">

            {{-- SYSTEM STATUS --}}
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl">

                <h3 class="text-xl font-bold mb-5">
                    📊 System Status
                </h3>

                <div class="space-y-4">

                    <div class="flex justify-between items-center">

                        <span class="text-slate-400">
                            Server Status
                        </span>

                        <span class="text-emerald-400 font-semibold">
                            Online
                        </span>

                    </div>

                    <div class="flex justify-between items-center">

                        <span class="text-slate-400">
                            Database
                        </span>

                        <span class="text-emerald-400 font-semibold">
                            Connected
                        </span>

                    </div>

                    <div class="flex justify-between items-center">

                        <span class="text-slate-400">
                            App Version
                        </span>

                        <span class="text-indigo-400 font-semibold">
                            v1.0
                        </span>

                    </div>

                </div>

            </div>

            {{-- QUICK INFO --}}
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-6 shadow-xl">

                <h3 class="text-xl font-bold mb-3">
                    🚀 SmartBiz Pro
                </h3>

                <p class="text-sm text-white/80 leading-relaxed">
                    Manage products, customers, inventory, sales,
                    reports, approvals, and analytics from one centralized dashboard.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection