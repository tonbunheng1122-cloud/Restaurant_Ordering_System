@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<body class="bg-[#FFE4DB]">

<div x-data="{ open: false }" class="relative min-h-screen flex">

    <!-- MOBILE TOP BAR -->
    <div class="fixed top-0 left-0 right-0 bg-[#a05137] text-white p-4 flex justify-between items-center md:hidden z-40 shadow-lg">
        <h1 class="text-xl font-bold">RESTAURANT</h1>
        <button @click="open = true">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
    </div>

    <!-- OVERLAY -->
    <div x-show="open"
         @click="open = false"
         x-transition.opacity
         class="fixed inset-0 bg-black/50 z-30 md:hidden">
    </div>

    <!-- SIDEBAR -->
    <aside
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed md:static inset-y-0 left-0 z-40
               w-64 min-h-screen
               bg-[#a05137] rounded-lg p-6
               flex flex-col items-center
               shadow-xl text-white
               transform transition-transform duration-300 ease-in-out
               md:translate-x-0">

        <!-- HEADER -->
        <div class="flex justify-between items-center w-full mb-12">
            <h1 class="text-2xl font-bold">
                <!-- RESTAURANT  -->
                 <!-- <span class="text-[#E15E3A]">FAST</span><span class="text-black">BITE</span> -->
                    RESTAURANT
            </h1>
            <button @click="open = false" class="md:hidden">
                ✕
            </button>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex flex-col w-full space-y-4">

            <a href="{{ route('dashboard.index') }}"
               class="flex items-center justify-center p-3 rounded-lg border border-white/30
               {{ request()->routeIs('dashboard.*') ? 'bg-white text-[#a05137]' : 'hover:bg-white/55' }}
               transition-all duration-300 font-bold text-lg">
                Dashboard
            </a>

            <a href="{{ route('allproduct.index') }}"
               class="flex items-center justify-center p-3 rounded-lg border border-white/30
               {{ request()->routeIs('allproduct.*') ? 'bg-white text-[#a05137]' : 'hover:bg-white/55' }}
               transition-all duration-300 font-bold text-lg">
                Product
            </a>

            <a href="{{ route('allcategory.index') }}"
               class="flex items-center justify-center p-3 rounded-lg border border-white/30
               {{ request()->routeIs('allcategory.*') ? 'bg-white text-[#a05137]' : 'hover:bg-white/55' }}
               transition-all duration-300 font-bold text-lg">
                Category
            </a>

            <a href="{{ route('menu.index') }}"
               class="flex items-center justify-center p-3 rounded-lg border border-white/30
               {{ request()->routeIs('menu.*') ? 'bg-white text-[#a05137]' : 'hover:bg-white/55' }}
               transition-all duration-300 font-bold text-lg">
                Menu
            </a>

            <a href="{{ route('reservations.index') }}"
               class="flex items-center justify-center p-3 rounded-lg border border-white/30
               {{ request()->routeIs('reservations.*') ? 'bg-white text-[#a05137]' : 'hover:bg-white/55' }}
               transition-all duration-300 font-bold text-lg">
                Table
            </a>

            <a href="{{ route('report.index') }}"
               class="flex items-center justify-center p-3 rounded-lg border border-white/30
               {{ request()->routeIs('report.*') ? 'bg-white text-[#a05137]' : 'hover:bg-white/55' }}
               transition-all duration-300 font-bold text-lg">
                Report
            </a>

            <a href="{{ route('setting.index') }}"
               class="flex items-center justify-center p-3 rounded-lg border border-white/30
               {{ request()->routeIs('setting.*') ? 'bg-white text-[#a05137]' : 'hover:bg-white/55' }}
               transition-all duration-300 font-bold text-lg">
                Setting
            </a>

        </nav>

    </aside>

</div>

</body>