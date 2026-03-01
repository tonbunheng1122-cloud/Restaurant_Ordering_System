@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
</style>
<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">      
        <aside> 
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
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl md:text-3xl text-gray-800 font-bold">Table List</h2>
                </div>
                <!-- Search and create button -->
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-6">
                    <a href="{{ route('addtable.index') }}" class="w-full sm:w-auto">
                        <button class="px-5 py-2 bg-[#A0522D] text-white rounded-lg font-semibold hover:opacity-90 transition w-full sm:w-auto">
                            + Create New Table
                        </button>
                    </a>
                    <!-- Search form -->
                    <form action="{{ route('reservations.search') }}" method="GET" class="relative w-full sm:w-64">
                        <input type="text" name="query" value="{{ $query ?? '' }}" placeholder="Search by name, phone, or table"
                               class="pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-200 outline-none w-full">
                        <button type="submit" class="absolute right-2 top-1.5 text-gray-400">🔍</button>
                    </form>
                </div>
                <!-- Table -->
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm sm:text-base">
                        <thead class="bg-gray-50">
                            <tr class="border-b text-gray-600 uppercase text-xs">
                                <th class="p-4">ID</th>
                                <th class="p-4">Name</th>
                                <th class="p-4 hidden md:table-cell">Date/Time</th>
                                <th class="p-4 hidden md:table-cell">Phone Number</th>
                                <th class="p-4 hidden lg:table-cell">Table</th>
                                <th class="p-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($reservations as $res)
                            <tr class="hover:bg-orange-50/50 transition">
                                <td class="p-4 font-medium text-gray-700">#{{ $res->id }}</td>
                                <td class="p-4">{{ $res->full_name }}</td>
                                <td class="p-4 hidden md:table-cell">
                                    <span class="block">{{ $res->date }}</span>
                                    <span class="text-xs text-gray-400">{{ $res->time }}</span>
                                </td>
                                <td class="p-4 hidden md:table-cell text-gray-600">{{ $res->phone_number }}</td>
                                <td class="p-4 hidden lg:table-cell">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Table {{ $res->table_id }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('reservations.edit', $res->id) }}" class="flex items-center justify-center w-8 h-8 rounded-full border border-gray-800 hover:bg-gray-800 hover:text-white transition">
                                            ✎
                                        </a>

                                        <form action="{{ route('reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Delete this table?');">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition">
                                                ✕
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400 italic">No Table found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        
                <div class="mt-6">
                    {{ $reservations->links() }}
                </div>
            </div>
        </main>
    </div>
</div>