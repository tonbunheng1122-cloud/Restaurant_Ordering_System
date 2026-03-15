@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Dashboard</title>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">

        <!-- Sidebar -->
        <aside>
            @include('components.asidebar')
        </aside>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

            <!-- Mobile menu button -->
            <button @click="mobileMenuOpen = true"
                class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            <!-- Header Card -->
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex items-center justify-center w-12 h-12 rounded-2xl bg-orange-50 text-[#EE6D3C]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
                            <p class="text-gray-500 text-sm">Welcome back, Admin! Here's a summary of your restaurant's performance.</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </span>
                            <input type="text" placeholder="Search menu items..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-orange-200 transition">
                        </div>
                        <div class="flex items-center gap-2 bg-green-50 border border-green-100 px-4 py-2.5 rounded-xl">
                            <div class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </div>
                            <span class="text-xs font-bold text-green-700 uppercase tracking-wider">System Live</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <!-- Total Products -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-[#EE6D3C] transition-all cursor-default">
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Total Products</p>
                    <div class="flex items-end justify-between mt-2">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</h3>
                        <div class="p-2 bg-orange-50 text-[#EE6D3C] rounded-lg group-hover:bg-[#EE6D3C] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-amber-400 transition-all cursor-default">
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Categories</p>
                    <div class="flex items-end justify-between mt-2">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalCategories }}</h3>
                        <div class="p-2 bg-amber-50 text-amber-500 rounded-lg group-hover:bg-amber-400 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Tables -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-blue-400 transition-all cursor-default">
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Active Tables</p>
                    <div class="flex items-end justify-between mt-2">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalTables }}</h3>
                        <div class="p-2 bg-blue-50 text-blue-500 rounded-lg group-hover:bg-blue-400 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- User Members -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-50 group hover:border-green-400 transition-all cursor-default">
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">User Members</p>
                    <div class="flex items-end justify-between mt-2">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</h3>
                        <div class="p-2 bg-green-50 text-green-500 rounded-lg group-hover:bg-green-400 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

                <!-- Recent Products Table -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-orange-50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-[#EE6D3C] rounded-full"></span>
                            Recent Products
                        </h3>
                        <a href="{{ route('allproduct.index') }}"
                            class="text-xs font-bold text-[#EE6D3C] hover:bg-orange-50 px-3 py-1.5 rounded-lg transition-colors">
                            View All
                        </a>
                    </div>
                    <div class="overflow-x-auto no-scrollbar">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase border-b border-gray-100">
                                    <th class="pb-3 px-2">Item Name</th>
                                    <th class="pb-3 px-2">Category</th>
                                    <th class="pb-3 px-2">Price</th>
                                    <th class="pb-3 px-2">Stock</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentProducts as $product)
                                <tr class="hover:bg-orange-50/30 transition-colors">
                                    <td class="py-4 px-2 font-medium text-gray-700">{{ $product->name }}</td>
                                    <td class="py-4 px-2">
                                        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs font-bold">
                                            {{ $product->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 font-bold text-gray-800">${{ number_format($product->price, 2) }}</td>
                                    <td class="py-4 px-2">
                                        @if(($product->qty ?? 0) > 20)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">
                                                {{ $product->qty }} In Stock
                                            </span>
                                        @elseif(($product->qty ?? 0) > 0)
                                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-full text-xs font-bold">
                                                {{ $product->qty }} Low Stock
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-400 italic text-sm">No products found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-orange-50 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-[#EE6D3C] rounded-full"></span>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-2 gap-3">

                        <a href="{{ route('allproduct.index') }}"
                            class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-[#EE6D3C] hover:text-white transition-all group text-gray-600">
                            <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="text-[10px] font-bold uppercase">Products</span>
                        </a>

                        <a href="{{ route('alltable.index') }}"
                            class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-[#EE6D3C] hover:text-white transition-all group text-gray-600">
                            <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                            </svg>
                            <span class="text-[10px] font-bold uppercase">Tables</span>
                        </a>

                        <a href="{{ route('allcategory.index') }}"
                            class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-[#EE6D3C] hover:text-white transition-all group text-gray-600">
                            <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            <span class="text-[10px] font-bold uppercase">Categories</span>
                        </a>

                        <a href="{{ route('setting.index') }}"
                            class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-[#EE6D3C] hover:text-white transition-all group text-gray-600">
                            <svg class="w-5 h-5 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-[10px] font-bold uppercase">Settings</span>
                        </a>

                    </div>
                </div>

                <!-- Sales Chart -->
                <div class="bg-white rounded-2xl shadow-sm border border-orange-50 p-6 lg:col-span-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-[#EE6D3C] rounded-full"></span>
                            Sales Overview
                        </h3>
                        <span class="text-xs text-gray-400">Last 6 months</span>
                    </div>
                    <canvas id="salesChart" height="90"></canvas>
                </div>

            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesLabels) !!},
            datasets: [{
                label: 'Revenue ($)',
                data: {!! json_encode($salesValues) !!},
                borderColor: '#EE6D3C',
                backgroundColor: 'rgba(238,109,60,0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#EE6D3C',
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' $' + ctx.parsed.y.toLocaleString()
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        callback: val => '$' + val.toLocaleString()
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>