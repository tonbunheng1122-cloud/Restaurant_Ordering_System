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
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl md:text-3xl text-gray-800 font-bold">
                        Dashborad
                    </h2>
                    
                </div>
            </div>
    </main>
</div>