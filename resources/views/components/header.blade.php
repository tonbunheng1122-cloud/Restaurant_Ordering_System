@vite('resources/css/app.css')
@vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Inter', sans-serif; } </style>
    <header class="flex items-center justify-between mb-8">
                <div class="flex flex-1 max-w-2xl gap-2">
                    <div class="relative flex-1">
                        <input type="text" placeholder="Search foods" class="w-full py-3 px-6 rounded-xl border focus:ring-2 focus:ring-orange-200 shadow-sm ">
                        <span class="absolute right-4 top-3 text-gray-400 cursor-pointer">✕</span>
                    </div>
                    <button class="bg-[#F25C29] text-white px-8 py-3 rounded-xl font-bold shadow-md hover:bg-orange-600 transition cursor-pointer">Search</button>
                </div>
                
                <div class="flex items-center gap-4 ml-4">
                    <div class="p-2 bg-white rounded-full shadow-sm cursor-pointer hover:bg-gray-50 transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v1m6 0H9"></path></svg>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=F25C29&color=fff" class="w-12 h-12 rounded-full border-2 border-white shadow-sm" alt="Profile">
                </div>
        </header>
