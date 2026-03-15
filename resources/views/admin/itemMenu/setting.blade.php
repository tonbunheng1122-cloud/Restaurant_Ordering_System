@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Settings</title>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false, tab: '{{ old('_tab', 'general') }}' }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">

        <aside>
            @include('components.asidebar')
        </aside>

        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-black/50 z-40 xl:hidden backdrop-blur-sm"></div>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

            <button @click="mobileMenuOpen = true"
                class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            {{-- Success Flash --}}
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="flex items-center justify-between gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
                <button @click="show = false" class="text-green-400 hover:text-green-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            <form action="{{ route('setting.save') }}" method="POST">
                @csrf
                {{-- Remembers which tab was active when form was submitted --}}
                <input type="hidden" name="_tab" :value="tab">

                <div class="bg-white rounded-lg shadow-sm border border-orange-100 mt-4 mb-8 overflow-hidden">

                    {{-- Header --}}
                    <div class="p-6 md:p-8 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <h2 class="text-2xl font-bold text-gray-800">System Settings</h2>
                            <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">
                                Configuration
                            </span>
                        </div>
                        <p class="text-gray-500 text-sm mt-1">Manage your restaurant configuration and preferences.</p>
                    </div>

                    <div class="grid grid-cols-12">

                        {{-- Tab Nav --}}
                        <div class="col-span-12 md:col-span-3 bg-gray-50/50 p-4 border-r border-gray-100">
                            <nav class="flex md:flex-col gap-2 overflow-x-auto no-scrollbar">

                                @php
                                $tabs = [
                                    ['key' => 'general',  'label' => 'General',  'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                                    ['key' => 'users',    'label' => 'Users',    'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                    ['key' => 'printers', 'label' => 'Printers', 'icon' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z'],
                                ];
                                @endphp

                                @foreach($tabs as $item)
                                <button type="button" @click="tab = '{{ $item['key'] }}'"
                                    :class="tab === '{{ $item['key'] }}'
                                        ? 'bg-[#EE6D3C] text-white shadow-md shadow-orange-200'
                                        : 'text-gray-600 hover:bg-orange-50 hover:text-[#EE6D3C]'"
                                    class="whitespace-nowrap flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200 text-left">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                                    </svg>
                                    {{ $item['label'] }}
                                </button>
                                @endforeach

                            </nav>
                        </div>

                        {{-- Tab Content --}}
                        <div class="col-span-12 md:col-span-9 p-6 md:p-8 min-h-[500px]">

                            {{-- General --}}
                            <div x-show="tab === 'general'" x-transition>
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="w-1.5 h-5 bg-[#EE6D3C] rounded-full"></span>
                                    <h3 class="text-lg font-bold text-gray-800">General Information</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <div class="flex flex-col gap-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Restaurant Name</label>
                                        <input type="text" name="restaurant_name"
                                            value="{{ old('restaurant_name') }}"
                                            placeholder="e.g. FastBite"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition @error('restaurant_name') border-red-400 @enderror">
                                        @error('restaurant_name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Phone Number</label>
                                        <input type="text" name="phone"
                                            value="{{ old('phone') }}"
                                            placeholder="+855..."
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition @error('phone') border-red-400 @enderror">
                                        @error('phone')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-2 md:col-span-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Email Address</label>
                                        <input type="email" name="email"
                                            value="{{ old('email') }}"
                                            placeholder="contact@restaurant.com"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition @error('email') border-red-400 @enderror">
                                        @error('email')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-2 md:col-span-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Address</label>
                                        <textarea name="address" rows="3"
                                            placeholder="Enter restaurant address..."
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm resize-none transition">{{ old('address') }}</textarea>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Currency</label>
                                        <select name="currency"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-white transition">
                                            <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                            <option value="KHR" {{ old('currency') === 'KHR' ? 'selected' : '' }}>KHR (៛)</option>
                                        </select>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Timezone</label>
                                        <select name="timezone"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-white transition">
                                            <option value="Asia/Phnom_Penh" {{ old('timezone', 'Asia/Phnom_Penh') === 'Asia/Phnom_Penh' ? 'selected' : '' }}>Asia/Phnom_Penh (UTC+7)</option>
                                            <option value="Asia/Bangkok"    {{ old('timezone') === 'Asia/Bangkok'    ? 'selected' : '' }}>Asia/Bangkok (UTC+7)</option>
                                            <option value="UTC"             {{ old('timezone') === 'UTC'             ? 'selected' : '' }}>UTC</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            {{-- Users --}}
                            <div x-show="tab === 'users'" x-transition>
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="w-1.5 h-5 bg-[#EE6D3C] rounded-full"></span>
                                    <h3 class="text-lg font-bold text-gray-800">User Management</h3>
                                </div>
                                <div class="p-6 bg-orange-50 border border-orange-100 rounded-xl text-center">
                                    <svg class="w-10 h-10 mx-auto text-orange-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <p class="text-sm text-orange-700 font-medium">User management content goes here.</p>
                                </div>
                            </div>

                            {{-- Printers --}}
                            <div x-show="tab === 'printers'" x-transition>
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="w-1.5 h-5 bg-[#EE6D3C] rounded-full"></span>
                                    <h3 class="text-lg font-bold text-gray-800">Hardware Configuration</h3>
                                </div>
                                <div class="flex items-start gap-3 p-4 bg-orange-50 border border-orange-100 rounded-xl mb-6">
                                    <svg class="w-5 h-5 text-orange-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm text-orange-800 font-medium">Connect your thermal printers via IP address or USB.</p>
                                </div>
                                <div class="flex flex-col gap-5 max-w-md">
                                    <div class="flex flex-col gap-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Kitchen Printer IP</label>
                                        <input type="text" name="kitchen_printer"
                                            value="{{ old('kitchen_printer') }}"
                                            placeholder="192.168.1.100"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition @error('kitchen_printer') border-red-400 @enderror">
                                        @error('kitchen_printer')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Receipt Printer IP</label>
                                        <input type="text" name="receipt_printer"
                                            value="{{ old('receipt_printer') }}"
                                            placeholder="192.168.1.101"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition @error('receipt_printer') border-red-400 @enderror">
                                        @error('receipt_printer')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="p-5 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('setting.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition text-sm">
                            Reset
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 bg-gray-900 hover:bg-gray-700 text-white font-bold rounded-xl transition text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Changes
                        </button>
                    </div>

                </div>
            </form>
        </main>
    </div>
</div>