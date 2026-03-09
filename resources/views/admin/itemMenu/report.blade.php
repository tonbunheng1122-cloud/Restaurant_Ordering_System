@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Flavor Unleashed</title>
<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false, activeTab: 'All' }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">
        
        <aside > 
            @include('components.asidebar')
        </aside>
        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">
            <header class="flex items-center gap-4 mb-2 xl:hidden">
                <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </header>

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex items-center">
                        <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">Reports</h2>
                    </div>

                    <div class="relative w-full md:w-80">
                        <input type="text" placeholder="Search this table" class="w-full pl-4 pr-10 py-3 bg-white border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute right-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex overflow-x-auto gap-6 border-b-2 border-black mb-6 no-scrollbar">
                    @php 
                        $tabs = ['All',  'Products',  'Top Selling' , 'Table'];
                    @endphp
                    @foreach($tabs as $tab)
                        <button 
                            @click="activeTab = '{{ $tab }}'"
                            :class="activeTab === '{{ $tab }}' ? 'text-[#EE6D3C] border-b-4 border-[#EE6D3C]' : 'text-black hover:text-[#EE6D3C]'"
                            class="pb-3 px-1 text-lg font-bold whitespace-nowrap transition-all duration-200">
                            {{ $tab }}
                        </button>
                    @endforeach
                </div>

                <div class="overflow-x-auto">
                    
                    <table x-show="activeTab === 'All'" class="w-full text-left min-w-[800px]">
                        <thead>
                            <tr class="text-black font-extrabold text-lg border-b-2 border-gray-100">
                                <th class="py-4">Date</th><th class="py-4">ID</th><th class="py-4">Image</th><th class="py-4">Name</th><th class="py-4">Paid</th><th class="py-4">Status</th><th class="py-4">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-blue-400">
                            <tr class="text-black font-bold text-base hover:bg-gray-50 transition">
                                <td class="py-4">10-12-25</td><td class="py-4">001</td>
                                <td class="py-4"><img src="https://via.placeholder.com/60" class="w-14 h-14 rounded-xl object-cover"></td>
                                <td class="py-4">Spicy Korean Ramen</td><td class="py-4">$9.99</td>
                                <td class="py-4"><span class="border border-green-500 text-green-500 px-4 py-1 rounded-lg text-sm font-bold">Completed</span></td>
                                <td class="py-4"><span class="border border-green-500 text-green-500 px-6 py-1 rounded-lg text-sm font-bold">Paid</span></td>
                            </tr>
                        </tbody>
                    </table>

                    

                    <table x-show="activeTab === 'Products'" style="display: none;" class="w-full text-left min-w-[800px]">
                        <thead>
                            <tr class="text-black font-extrabold text-lg border-b-2 border-gray-100">
                                <th class="py-4">Code</th><th class="py-4">Product Name</th><th class="py-4">Stock</th><th class="py-4">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-green-400">
                            <tr class="font-bold"><td>PRO-99</td><td>Beef Burger XL</td><td>142</td><td>$12.50</td></tr>
                        </tbody>
                    </table>

                    <table x-show="activeTab === 'Top Selling'" style="display: none;" class="w-full text-left min-w-[800px]">
                        <thead>
                            <tr class="text-black font-extrabold text-lg border-b-2 border-gray-100">
                                <th class="py-4">Rank</th><th class="py-4">Product</th><th class="py-4">Category</th><th class="py-4">Sales Count</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-red-400">
                            <tr class="font-bold"><td>#1</td><td>Million Dollar Lasagna</td><td>Pasta</td><td>450 Units</td></tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </main>
    </div>
</div>