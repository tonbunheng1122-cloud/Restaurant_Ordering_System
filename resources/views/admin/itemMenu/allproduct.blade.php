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
            <!-- Main -->
            <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">
                        <!-- Header -->
                        <div class="mb-6 sm:mb-8">
                            <h2 class="text-xl sm:text-2xl md:text-3xl text-gray-800 font-bold">
                                Products
                            </h2>
                        </div>
                
                        <!-- Top Controls -->
                        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-6">
                
                            <a href="{{ route('addproduct.index') }}" class="w-full sm:w-auto">
                                <button class="px-5 py-2 bg-[#A0522D] text-white rounded-lg font-semibold hover:opacity-90 transition w-full sm:w-auto">
                                    + Create
                                </button>
                            </a>
                
                            <div class="relative w-full sm:w-64">
                                <input type="text" placeholder="Search this table"
                                    class="pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-200 outline-none w-full">
                                <span class="absolute right-3 top-2.5 text-gray-400">
                                    🔍
                                </span>
                            </div>
                
                        </div>
                
                        <!-- Responsive Table -->
                        <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                
                            <table class="w-full text-left text-sm sm:text-base">
                
                                <thead class="bg-gray-50">
                                    <tr class="border-b">
                                        <th class="p-3"><input type="checkbox"></th>
                                        <th class="p-3">Image</th>
                                        <th class="p-3">Name</th>
                                        <th class="p-3 hidden md:table-cell">Code</th>
                                        <th class="p-3 hidden md:table-cell">Price</th>
                                        <th class="p-3 hidden lg:table-cell">Unit</th>
                                        <th class="p-3 hidden lg:table-cell">QTY</th>
                                        <th class="p-3 text-center">Action</th>
                                    </tr>
                                </thead>
                
                                <tbody class="divide-y">
                
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-3"><input type="checkbox"></td>
                
                                        <td class="p-3">
                                            <img src="https://via.placeholder.com/80"
                                                 class="w-12 h-12 sm:w-16 sm:h-16 rounded-xl object-cover">
                                        </td>
                
                                        <td class="p-3 font-bold text-gray-800">
                                            Million Dollar Lasagna
                                        </td>
                
                                        <td class="p-3 hidden md:table-cell text-gray-600">
                                            0001
                                        </td>
                
                                        <td class="p-3 hidden md:table-cell text-gray-600">
                                            $14.99
                                        </td>
                
                                        <td class="p-3 hidden lg:table-cell text-gray-600">
                                            0
                                        </td>
                
                                        <td class="p-3 hidden lg:table-cell text-gray-600">
                                            0
                                        </td>
                
                                        <td class="p-3">
                                            <div class="flex justify-center gap-2">
                                                <button class="w-8 h-8 rounded-full border border-gray-800 hover:bg-gray-800 hover:text-white transition">
                                                    ✎
                                                </button>
                                                <button class="w-8 h-8 rounded-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition">
                                                    ✕
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                
                                </tbody>
                
                            </table>
                
                        </div>
                
                        <!-- Pagination -->
                        <div class="flex justify-center items-center gap-4 mt-8">
                            <button class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200">←</button>
                            <span class="font-bold text-gray-800">1</span>
                            <button class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200">→</button>
                        </div>
                
                    </div>
                
            </main>
        </div>
    </div>
    
    