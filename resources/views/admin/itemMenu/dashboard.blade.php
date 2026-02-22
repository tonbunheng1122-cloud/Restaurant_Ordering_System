@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
    <!-- MOBILE HEADER -->
    <div class="fixed top-0 left-0 right-0 xl:hidden bg-[#a05137] text-white p-4 flex justify-between items-center shadow-md z-50">
        <h1 class="text-lg font-bold">RESTAURANT</h1>
        <button @click="open = true">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
    </div>

    <div class="flex flex-col xl:flex-row gap-4 p-2 md:p-4 overflow-hidden pt-20 xl:pt-4">

        <!-- MOBILE OVERLAY -->
        <div x-show="open" @click="open = false" class="fixed inset-0 z-40 xl:hidden"></div>

        <!-- LEFT SIDEBAR -->
        <aside :class="open ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed xl:static inset-y-0 left-0 z-50 w-64 flex-shrink-0 transform transition-transform duration-300 ease-in-out xl:translate-x-0">
            @include('components.asidebar')
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto pr-2 md:pr-4 custom-scrollbar">

            <!-- HEADER -->
            <header class="mb-4">
                @include('components.header')
            </header>

            <!-- BANNER -->
            <div class="bg-white rounded-3xl h-32 sm:h-40 md:h-48 mb-6 shadow-sm border border-orange-100 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1000&q=80"
                     class="w-full h-full object-cover opacity-80" alt="Banner">
            </div>

            <!-- CATEGORY SECTION -->
            <section class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">Category</h2>
                    <button class="text-white bg-[#F25C29] px-3 sm:px-4 py-1 rounded-lg text-xs sm:text-sm font-semibold hover:bg-orange-600 transition">
                        View all
                    </button>
                </div>

                <div class="flex gap-3 sm:gap-4 overflow-x-auto pb-4">
                    @php
                        $categories = [
                            ['name' => 'Steak', 'img' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=100&h=100'],
                            ['name' => 'Burger', 'img' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=100&h=100'],
                            ['name' => 'Pizza', 'img' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=100&h=100'],
                            ['name' => 'Dessert', 'img' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?auto=format&fit=crop&w=100&h=100'],
                            ['name' => 'Chicken', 'img' => 'https://images.unsplash.com/photo-1562967914-608f82629710?auto=format&fit=crop&w=100&h=100']
                        ];
                    @endphp

                    @foreach($categories as $cat)
                        <div class="bg-white p-3 sm:p-4 rounded-2xl flex flex-col items-center min-w-[90px] sm:min-w-[110px] shadow-sm border-2 transition hover:scale-105
                        {{ $cat['name'] == 'Steak' ? 'border-[#F25C29]' : 'border-transparent' }}">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-100 rounded-full mb-2 overflow-hidden">
                                <img src="{{ $cat['img'] }}" class="w-full h-full object-cover">
                            </div>
                            <span class="text-xs font-bold text-gray-700">{{ $cat['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- POPULAR DISHES -->
            <section class="mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">Popular Dishes</h2>
                    <button class="text-white bg-[#F25C29] px-3 sm:px-4 py-1 rounded-lg text-xs sm:text-sm font-semibold hover:bg-orange-600 transition">
                        View all
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-3 gap-4 sm:gap-6">
                    @php
                        $dishes = [
                            ['name' => 'Pizza Cheese', 'price' => '9.99', 'img' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=400&h=300'],
                            ['name' => 'Burger Cheese', 'price' => '7.99', 'img' => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?auto=format&fit=crop&w=400&h=300'],
                            ['name' => 'Steak Beef', 'price' => '10.99', 'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&h=300']
                        ];
                    @endphp

                    @foreach($dishes as $dish)
                        <div class="bg-white p-4 rounded-2xl sm:rounded-[2.5rem] shadow-md border border-gray-50 hover:shadow-xl transition">
                            <div class="overflow-hidden rounded-2xl mb-4">
                                <img src="{{ $dish['img'] }}" class="w-full h-36 sm:h-40 object-cover hover:scale-110 transition duration-500">
                            </div>
                            <h3 class="font-bold text-gray-800 text-sm sm:text-base">{{ $dish['name'] }}</h3>
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-[#F25C29] font-extrabold text-base sm:text-lg">${{ $dish['price'] }}</span>
                                <button class="bg-[#F25C29] text-white w-8 h-8 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center font-bold hover:bg-orange-600 transition">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>

        <!-- RIGHT SIDEBAR -->
        <aside class="w-full xl:w-80 flex flex-col gap-4 sm:gap-6 xl:sticky xl:top-4 self-start max-h-screen overflow-y-auto">

            <!-- ORDER CARD -->
            <div class="bg-white rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-6 shadow-lg border border-gray-50">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Order Menu</h2>
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-sm">
                        <span>Crack Burger</span>
                        <span class="text-red-500 font-bold">+$7.99</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Steak Beef</span>
                        <span class="text-red-500 font-bold">+$9.99</span>
                    </div>
                </div>
                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Sub Total</span>
                        <span>$17.98</span>
                    </div>
                    <div class="flex justify-between font-bold text-[#F25C29] text-lg">
                        <span>Total</span>
                        <span>$19.77</span>
                    </div>
                </div>
                <button class="w-full bg-[#F25C29] text-white py-3 rounded-xl mt-6 font-bold hover:bg-orange-600 transition">
                    Payment
                </button>
            </div>

            <!-- REPORT CARD -->
            <div class="bg-white rounded-2xl sm:rounded-[2.5rem] p-6 shadow-lg border border-gray-50">
                <h2 class="text-lg font-bold text-gray-800 mb-6">All Reports</h2>
                <div class="flex justify-center items-center h-40 text-gray-400">
                    Report Chart Area
                </div>
            </div>

        </aside>

    </div>
</div>