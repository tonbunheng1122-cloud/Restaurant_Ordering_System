@vite('resources/css/app.css')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    body { font-family: 'Inter', sans-serif; }
</style>
<title>FastBite | Login</title>

<div class="min-h-screen bg-[#FFE4DB] flex items-center justify-center p-4">
    <div class="w-full max-w-sm">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">

            <!-- Top accent bar -->
            <div class="h-1.5 w-full bg-[#EE6D3C]"></div>

            <div class="p-8">

                <!-- Logo & Title -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-[#FFE4DB] rounded-2xl mb-4">
                        <svg class="w-7 h-7 text-[#EE6D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-black text-gray-800 tracking-tight">
                        Fast<span class="text-[#EE6D3C]">Bite</span>
                    </h1>
                    <p class="text-sm text-gray-400 mt-1">Welcome back! Please sign in to continue.</p>
                </div>

                <!-- Success Flash -->
                @if(session('success'))
                <div class="flex items-center gap-2 mb-5 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                <!-- Error Flash -->
                @if($errors->has('login_error'))
                <div class="flex items-center gap-2 mb-5 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $errors->first('login_error') }}
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="/login">
                    @csrf

                    <!-- Username -->
                    <div class="flex flex-col gap-2 mb-4">
                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Username</label>
                        <input type="text" name="username" required
                            value="{{ old('username') }}"
                            placeholder="Enter your username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                @error('username') border-red-400 @enderror">
                        @error('username')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col gap-2 mb-6" x-data="{ show: false }">
                        <div class="flex justify-between items-center">
                            <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Password</label>
                            <!-- <a href="#" class="text-xs text-[#EE6D3C] hover:underline font-medium">Forgot?</a> -->
                        </div>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password" required
                                placeholder="Enter your password"
                                class="w-full px-4 py-3 pr-11 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                    @error('password') border-red-400 @enderror">
                            <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#EE6D3C] transition">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-gray-900 hover:bg-gray-700 text-white font-bold py-3 rounded-xl transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Sign In
                    </button>

                    <!-- Register link -->
                    <!-- <p class="text-center text-sm mt-6 text-gray-500">
                        Don't have an account?
                        <a href="/register" class="text-[#EE6D3C] font-bold hover:underline">Register now</a>
                    </p> -->

                </form>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-[10px] text-gray-400 mt-5 uppercase tracking-wider">
            © 2026 Restaurant Ordering System
        </p>

    </div>
</div>