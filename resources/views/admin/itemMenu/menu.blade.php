@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 bg-black/50 z-40 xl:hidden"></div>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">
            <header class="flex items-center gap-4 mb-2 xl:hidden">
                <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </header>

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                <!-- MAIN CONTENT -->
                <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">                        
                        <div class="flex items-center mb-6">
                            <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">Menu</h2>
                        </div>
            
                        <!-- Categories -->
                        <div class="flex overflow-x-auto gap-3 pb-4 mb-8">
                            @php 
                                $categories = [
                                    ['name' => 'All', 'count' => '200 Items'],
                                    ['name' => 'Burger', 'count' => '10 Items'],
                                    ['name' => 'Soups', 'count' => '10 Items'],
                                    ['name' => 'Pasta', 'count' => '10 Items'],
                                    ['name' => 'Steak', 'count' => '10 Items'],
                                ];
                            @endphp
                            @foreach($categories as $cat)
                                <button class="flex-shrink-0 min-w-[120px] p-4 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 transition">
                                    <div class="font-bold text-lg">{{ $cat['name'] }}</div>
                                    <div class="text-xs opacity-80">{{ $cat['count'] }}</div>
                                </button>
                            @endforeach
                        </div>
            
                        <!-- Content Grid -->
                        <div class="flex flex-col xl:flex-row gap-8">
                            
                            <!-- Products -->
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach(range(1, 6) as $index)
                                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group">
                                    <div class="p-3">
                                        <img src="https://via.placeholder.com/300" class="w-full h-40 md:h-48 object-cover rounded-2xl group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <div class="p-5 pt-0">
                                        <div class="text-gray-400 font-bold">Food Item</div>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[#EE6D3C] font-bold text-xl">$9.99</span>
                                            <div class="flex items-center gap-2">
                                                <button class="w-8 h-8 rounded-lg bg-gray-100">-</button>
                                                <span class="font-bold w-4 text-center">0</span>
                                                <button class="w-8 h-8 rounded-lg bg-[#EE6D3C] text-white">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
            
                            <!-- Checkout -->
                            <div class="w-full xl:w-[380px] flex-shrink-0">
                                <div class="border border-gray-300 rounded-xl p-6 sticky top-4">
                                    <h3 class="text-2xl font-bold text-center mb-6">Checkout</h3>
                                    <button class="w-full bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-xl hover:bg-orange-600 transition">
                                        Order
                                    </button>
                                </div>
                            </div>
            
                        </div>
            

                </main>
        </div>
    </div>




