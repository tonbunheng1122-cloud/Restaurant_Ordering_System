@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Flavor Unleashed</title>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">

        <!-- Sidebar -->
        <aside>
            @include('components.asidebar')
        </aside>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

            <!-- Mobile menu button -->
            <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">

                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">

                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-800">Table List</h2>
                        <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">
                            Reservations
                        </span>
                    </div>

                    <div class="flex items-center gap-3 flex-wrap">

                        <!-- Search -->
                        <form action="{{ route('reservations.search') }}" method="GET" class="relative w-full md:w-72">
                            <input type="text" name="query"
                                value="{{ $query ?? '' }}"
                                placeholder="Search by name, phone, or table..."
                                class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm">
                            <button type="submit" class="absolute right-3 top-3.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </form>

                        <!-- Create button -->
                        <a href="{{ route('addtable.index') }}"
                            class="flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold px-4 py-3 rounded-xl transition whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create New
                        </a>

                    </div>
                </div>

                <!-- Table -->
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm">

                        <thead class="bg-gray-50">
                            <tr class="border-b text-gray-600 uppercase text-xs">
                                <th class="p-4">ID</th>
                                <th class="p-4">Name</th>
                                <th class="p-4 hidden md:table-cell">Date / Time</th>
                                <th class="p-4 hidden md:table-cell">Phone</th>
                                <th class="p-4 hidden lg:table-cell">Table</th>
                                <th class="p-4 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($reservations as $res)
                            <tr class="hover:bg-orange-50/50 transition">

                                <td class="p-4 font-medium text-gray-700">#{{ $res->id }}</td>

                                <td class="p-4 font-medium text-gray-800">{{ $res->full_name }}</td>

                                <td class="p-4 hidden md:table-cell">
                                    <span class="block text-gray-700">{{ $res->date }}</span>
                                    <span class="text-xs text-gray-400">{{ $res->time }}</span>
                                </td>

                                <td class="p-4 hidden md:table-cell text-gray-600">{{ $res->phone_number }}</td>

                                <td class="p-4 hidden lg:table-cell">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Table {{ $res->table_id }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <div class="flex justify-center items-center gap-2">

                                        <!-- Edit -->
                                        <a href="{{ route('reservations.edit', $res->id) }}"
                                            class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-800 hover:text-white hover:border-gray-800 transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('reservations.destroy', $res->id) }}" method="POST"
                                              onsubmit="return confirm('Delete this reservation?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center justify-center w-8 h-8 rounded-lg border border-red-300 text-red-500 hover:bg-red-500 hover:text-white hover:border-red-500 transition"
                                                title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400 italic">No reservations found.</td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $reservations->links() }}
                </div>

            </div>
        </main>
    </div>
</div>