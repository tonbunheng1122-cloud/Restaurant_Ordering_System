@vite('resources/css/app.css')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | User Management</title>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">

        <aside>
            @include('components.asidebar')
        </aside>

        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
            class="fixed inset-0 bg-black/50 z-40 xl:hidden"></div>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

            <!-- Mobile menu button -->
            <button @click="mobileMenuOpen = true"
                class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            <!-- Flash Messages -->
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="flex items-center justify-between gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
                <button @click="show = false" class="text-green-400 hover:text-green-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">

                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
                        <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">
                            {{ $users->total() }} users
                        </span>
                    </div>

                    <div class="flex items-center gap-3 flex-wrap">

                        <!-- Search -->
                        <form method="GET" action="{{ route('user.index') }}" class="relative w-full md:w-72">
                            <input type="text" name="search"
                                value="{{ request('search') }}"
                                placeholder="Search users..."
                                class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition">
                            <button type="submit" class="absolute right-3 top-3.5 text-gray-400 hover:text-[#EE6D3C] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </form>

                        <!-- Create button -->
                        <a href="{{ route('user.create') }}"
                            class="flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold px-4 py-3 rounded-xl transition whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add User
                        </a>

                    </div>
                </div>

                <!-- Table -->
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm">

                        <thead class="bg-gray-50">
                            <tr class="border-b text-gray-600 uppercase text-xs">
                                <th class="p-4">ID</th>
                                <th class="p-4">Username</th>
                                <th class="p-4 hidden md:table-cell">Role</th>
                                <th class="p-4 hidden md:table-cell">Created At</th>
                                <th class="p-4 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($users as $user)
                            <tr class="hover:bg-orange-50/50 transition">

                                <!-- ID -->
                                <td class="p-4 font-medium text-gray-700">#{{ $user->id }}</td>

                                <!-- Username + Avatar -->
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-[#FFE4DB] text-[#EE6D3C] font-black text-sm flex items-center justify-center flex-shrink-0">
                                            {{ strtoupper(substr($user->username, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-gray-800">{{ $user->username }}</span>
                                    </div>
                                </td>

                                <!-- Role -->
                                <td class="p-4 hidden md:table-cell">
                                    @php
                                        $roleColors = [
                                            'Admin' => 'bg-purple-100 text-purple-700',
                                            'User'  => 'bg-blue-100 text-blue-700',
                                        ];
                                        $roleColor = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-600';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $roleColor }}">
                                        {{ $user->role ?? 'User' }}
                                    </span>
                                </td>

                                <!-- Created At -->
                                <td class="p-4 hidden md:table-cell">
                                    <span class="block text-gray-700 text-xs font-medium">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                    </span>
                                    <span class="text-gray-400 text-xs">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('h:i A') }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="p-4">
                                    <div class="flex justify-center items-center gap-2">

                                        <!-- Edit -->
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-800 hover:text-white hover:border-gray-800 transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Delete user {{ $user->username }}?')">
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
                                <td colspan="5" class="p-10 text-center text-gray-400 italic">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $users->links() }}
                </div>

            </div>
        </main>
    </div>
</div>