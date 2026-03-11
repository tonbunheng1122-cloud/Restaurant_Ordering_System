@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Flavor Unleashed</title>
<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false, tab: 'general' }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">
        <aside>
            @include('components.asidebar')
        </aside>

        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" 
             class="fixed inset-0 bg-black/50 z-40 xl:hidden backdrop-blur-sm transition-opacity"></div>

        <main class="flex-1 overflow-y-auto pr-1 custom-scrollbar">
            
            <header class="flex items-center justify-between mb-4 xl:hidden">
                <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-xl shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
                <h1 class="text-xl font-bold text-gray-800">Settings</h1>
            </header>

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800">System Settings</h2>
                    <p class="text-gray-500 text-sm">Manage your restaurant configuration and preferences.</p>
                </div>

                <div class="grid grid-cols-12">
                    <div class="col-span-12 md:col-span-3 bg-gray-50/50 p-4 border-r border-gray-100">
                        <nav class="flex md:flex-col gap-2 overflow-x-auto no-scrollbar">
                            <template x-for="item in ['general', 'users', 'printers',]">
                                <button @click="tab = item"
                                    :class="tab === item ? 'bg-[#EE6D3C] text-white shadow-orange-200 shadow-lg' : 'text-gray-600 hover:bg-orange-50'"
                                    class="whitespace-nowrap px-4 py-3 rounded-xl font-medium transition-all duration-200 text-left capitalize">
                                    <span x-text="item.replace('-', ' ')"></span>
                                </button>
                            </template>
                        </nav>
                    </div>

                    <div class="col-span-12 md:col-span-9 p-6 md:p-8 min-h-[500px]">
                        
                        <div x-show="tab === 'general'" x-transition>
                            <h3 class="text-lg font-bold mb-6 text-gray-800">General Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Restaurant Name</label>
                                    <input type="text" placeholder="e.g. My Cafe" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#EE6D3C] outline-none border transition-all">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Phone Number</label>
                                    <input type="text" placeholder="+855..." class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#EE6D3C] outline-none border transition-all">
                                </div>
                                <div class="space-y-1 md:col-span-2">
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Email Address</label>
                                    <input type="email" placeholder="contact@restaurant.com" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#EE6D3C] outline-none border transition-all">
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'printers'" x-transition>
                            <h3 class="text-lg font-bold mb-6 text-gray-800">Hardware Configuration</h3>
                            <div class="p-4 bg-orange-50 border border-orange-100 rounded-xl mb-6">
                                <p class="text-sm text-orange-800 font-medium">Connect your thermal printers via IP address or USB.</p>
                            </div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kitchen Printer IP</label>
                            <input type="text" placeholder="192.168.1.100" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#EE6D3C] outline-none border">
                        </div>

                        <div x-show="tab === 'system'" x-transition>
                            <h3 class="text-lg font-bold mb-6 text-gray-800">Localization</h3>
                            <div class="space-y-4 max-w-sm">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Currency</label>
                                    <select class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#EE6D3C] outline-none border bg-white">
                                        <option>USD ($)</option>
                                        <option>KHR (៛)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div x-show="['categories', 'payments', 'users'].includes(tab)" x-transition>
                            <h3 class="text-lg font-bold mb-4 capitalize" x-text="tab"></h3>
                            <p class="text-gray-500 italic">Content for <span x-text="tab"></span> management goes here...</p>
                        </div>

                    </div>
                </div>
                
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button class="px-8 py-2 bg-[#EE6D3C] text-white font-bold rounded-xl shadow-md hover:scale-105 transition-transform">Save Changes</button>
                </div>
            </div>
        </main>
    </div>
</div>