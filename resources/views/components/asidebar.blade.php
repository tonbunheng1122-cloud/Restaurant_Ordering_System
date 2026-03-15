<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>

<div x-data="{ open: false }" class="relative">

    <!-- Mobile Top Bar -->
    <div class="fixed top-0 left-0 right-0 bg-[#EE6D3C] text-white px-4 py-3 flex justify-between items-center md:hidden z-40 shadow-md">
        <div class="flex items-center gap-2">
            <span class="text-lg font-black tracking-tight">Fast<span class="text-white/70">Bite</span></span>
        </div>
        <button @click="open = true" class="p-1.5 rounded-lg bg-white/20 hover:bg-white/30 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
    </div>

    <!-- Overlay -->
    <div x-show="open"
         @click="open = false"
         x-transition.opacity
         class="fixed inset-0 bg-black/50 z-30 md:hidden">
    </div>

    <!-- Sidebar -->
    <aside
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed md:static inset-y-0 left-0 z-40
               w-64 h-full
               bg-white rounded-2xl shadow-sm border border-orange-100
               flex flex-col
               transform transition-transform duration-300 ease-in-out
               md:translate-x-0 overflow-hidden">

        <!-- Logo -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-orange-50">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[#EE6D3C] rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-lg font-black text-gray-800 tracking-tight">
                    Fast<span class="text-[#EE6D3C]">Bite</span>
                </span>
            </div>
            <button @click="open = false" class="md:hidden p-1 rounded-lg hover:bg-gray-100 text-gray-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto no-scrollbar">

            @php
            $navItems = [
                ['route' => 'dashboard.index', 'match' => 'dashboard.*', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],

                ['route' => 'allproduct.index',   'match' => 'allproduct.*',   'label' => 'Products',  'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],

                ['route' => 'allcategory.index',  'match' => 'allcategory.*',  'label' => 'Categories','icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                ['route' => 'menu.index',         'match' => 'menu.*',         'label' => 'Menu',      'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],

                ['route' => 'reservations.index', 'match' => 'reservations.*', 'label' => 'Tables',    'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1'],

                ['route' => 'report.index',       'match' => 'report.*',       'label' => 'Reports',   'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],

                ['route' => 'setting.index',   'match' => 'setting.*',      'label' => 'Settings',  'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],

            ];
            @endphp

            @foreach($navItems as $item)
                @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200
                       {{ $active
                           ? 'bg-[#EE6D3C] text-white shadow-md shadow-orange-200'
                           : 'text-gray-600 hover:bg-orange-50 hover:text-[#EE6D3C]' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    <span>{{ $item['label'] }}</span>
                    @if($active)
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                    @endif
                </a>
            @endforeach
        </nav>
    </aside>
</div>