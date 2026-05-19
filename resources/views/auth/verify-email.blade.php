<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-[#0f172a] px-6">

    <div class="w-full max-w-md">

        {{-- LOGO / TITLE --}}
        <div class="text-center mb-8">

            <h1 class="text-4xl font-bold text-white">
                SmartBiz
            </h1>

            <p class="text-slate-400 mt-2">
                Email Verification Required
            </p>

        </div>

        {{-- CARD --}}
        <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl p-8">

            {{-- ICON --}}
            <div class="flex justify-center mb-6">

                <div class="w-20 h-20 rounded-full bg-indigo-600/20 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-10 h-10 text-indigo-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8H3v8z" />

                    </svg>

                </div>

            </div>

            {{-- TEXT --}}
            <div class="text-center mb-6">

                <h2 class="text-2xl font-bold text-white mb-3">
                    Verify Your Email
                </h2>

                <p class="text-slate-400 leading-relaxed text-sm">

                    Thanks for signing up! Before getting started,
                    please verify your email address by clicking the
                    verification link we sent to your inbox.

                </p>

            </div>

            {{-- SUCCESS --}}
            @if (session('status') == 'verification-link-sent')

                <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-2xl text-sm">

                    A new verification link has been sent successfully.

                </div>

            @endif

            {{-- ACTIONS --}}
            <div class="space-y-4">

                {{-- RESEND --}}
                <form method="POST" action="{{ route('verification.send') }}">

                    @csrf

                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-2xl font-semibold transition shadow-lg">

                        Resend Verification Email

                    </button>

                </form>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="w-full bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 py-3 rounded-2xl font-semibold transition">

                        Log Out

                    </button>

                </form>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="text-center mt-6 text-slate-500 text-sm">

            © {{ date('Y') }} SmartBiz. All rights reserved.

        </div>

    </div>

</div>

</x-guest-layout>