@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!-- for chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false, activeTab: 'All' }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">
        
        <aside > 
            @include('components.asidebar')
        </aside>
            <main class="flex-1 overflow-y-auto pr-1 md:pr-1 custom-scrollbar">
            <header class="flex items-center py-1 gap-4 mb-2 xl:hidden">
                <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </header>
        <div class="bg-[#FFE4DB] min-h-screen" x-data="{ open: false }">
            <div class="flex-1 overflow-y-auto pr-1 custom-scrollbar">
                <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-4 md:p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="hidden sm:flex items-center justify-center w-12 h-12 rounded-2xl bg-orange-50 text-[#EE6D3C]">
                                <!-- icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl md:text-2xl text-gray-800 font-bold tracking-tight">
                                    Dashboard Overview
                                </h2>
                                <p class="text-gray-500">Welcome back, Admin! Here's a summary of your restaurant's performance.</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <div class="relative w-full sm:w-64">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <!-- Icon -->
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" placeholder="Search menu items..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#EE6D3C]/20 focus:border-[#EE6D3C] transition-all">
                            </div>

                            <div class="flex items-center gap-2 bg-green-50 border border-green-100 px-4 py-2 rounded-xl">
                                <div class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </div>
                                <span class="text-xs font-bold text-green-700 uppercase tracking-wider">System Live</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-[#EE6D3C] transition-all cursor-default">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Total Products</p>
                        <div class="flex items-end justify-between mt-2">
                            <h3 class="text-2xl font-bold text-gray-800">124</h3>
                            <div class="p-2 bg-orange-50 text-[#EE6D3C] rounded-lg group-hover:bg-[#EE6D3C] group-hover:text-white transition-colors">
                                <!-- Icon -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-amber-400 transition-all cursor-default">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Categories</p>
                        <div class="flex items-end justify-between mt-2">
                            <h3 class="text-2xl font-bold text-gray-800">12</h3>
                            <div class="p-2 bg-amber-50 text-amber-500 rounded-lg group-hover:bg-amber-400 group-hover:text-white transition-colors">
                                <!-- Icon -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-blue-400 transition-all cursor-default">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Active Tables</p>
                        <div class="flex items-end justify-between mt-2">
                            <h3 class="text-2xl font-bold text-gray-800">08/20</h3>
                            <div class="p-2 bg-blue-50 text-blue-500 rounded-lg group-hover:bg-blue-400 group-hover:text-white transition-colors">
                                <!-- Icon -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-green-400 transition-all cursor-default">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">User Members</p>
                        <div class="flex items-end justify-between mt-2">
                            <h3 class="text-2xl font-bold text-gray-800">06</h3>
                            <div class="p-2 bg-green-50 text-green-500 rounded-lg group-hover:bg-green-400 group-hover:text-white transition-colors">
                                <!-- Icon -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                    
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-orange-50 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-5 bg-[#EE6D3C] rounded-full"></span>
                                Recent Products
                            </h3>
                            <button class="text-xs font-bold text-[#EE6D3C] hover:bg-orange-50 px-3 py-1.5 rounded-lg transition-colors">View All</button>
                        </div>
                        <div class="overflow-x-auto no-scrollbar">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-gray-400 text-xs uppercase border-b border-gray-50">
                                        <th class="pb-3 px-2">Item Name</th>
                                        <th class="pb-3 px-2">Category</th>
                                        <th class="pb-3 px-2">Price</th>
                                        <th class="pb-3 px-2">Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr class="hover:bg-orange-50/30 transition-colors group">
                                        <td class="py-4 px-2 font-medium text-gray-700">Seafood Pasta</td>
                                        <td class="py-4 px-2 text-gray-500">Main Course</td>
                                        <td class="py-4 px-2 font-bold text-gray-800">$12.00</td>
                                        <td class="py-4 px-2">
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-[10px] font-bold tracking-tight">45 In Stock</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-orange-50/30 transition-colors group">
                                        <td class="py-4 px-2 font-medium text-gray-700">Iced Americano</td>
                                        <td class="py-4 px-2 text-gray-500">Drinks</td>
                                        <td class="py-4 px-2 font-bold text-gray-800">$2.50</td>
                                        <td class="py-4 px-2">
                                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-[10px] font-bold tracking-tight">12 Low Stock</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-orange-50 p-6">
                            <h3 class="font-bold text-gray-800 mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('allproduct.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-[#EE6D3C] hover:text-white transition-all group">
                                    <button class="flex flex-col items-center justify-center">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        <span class="text-[10px] font-bold uppercase">Add Product</span>
                                    </button>
                                </a>
                                <a href="{{ route('alltable.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-[#EE6D3C] hover:text-white transition-all group">
                                    <button class="flex flex-col items-center justify-center">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        <span class="text-[10px] font-bold uppercase">Tables</span>
                                    </button>
                                </a>
                                <a href="{{ route('setting.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-[#EE6D3C] hover:text-white transition-all group">
                                    <button class="flex flex-col items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span class="text-[10px] font-bold uppercase">Add User</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div> 
                    <div class="bg-white rounded-2xl shadow-sm border border-orange-50 p-6 lg:col-span-3">
                        <h3 class="font-bold text-gray-800 mb-4">Sales Overview</h3>

                        <canvas id="salesChart" height="120"></canvas>

                        <script>
                        document.addEventListener("DOMContentLoaded", function () {

                            const ctx = document.getElementById('salesChart');

                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['Jan','Feb','Mar','Apr','May','Jun'],
                                    datasets: [{
                                        label: 'Sales ($)',
                                        data: [1200,1900,3000,2500,2200,3200],
                                        borderColor: '#EE6D3C',
                                        backgroundColor: 'rgba(238,109,60,0.2)',
                                        borderWidth: 3,
                                        tension: 0.4,
                                        fill: true
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true
                                        }
                                    }
                                }
                            });

                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>