@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif
@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">

        {{-- Sidebar --}}
        <aside class="hidden xl:block w-64 flex-shrink-0">
            @include('components.asidebar')
        </aside>

        {{-- Mobile Overlay --}}
        <div x-show="mobileMenuOpen"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-black/50 z-40 xl:hidden">
        </div>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto pr-1 md:pr-1 custom-scrollbar ">

            
            <header class="flex items-center gap-4 mb-4 xl:hidden">
                <button @click="mobileMenuOpen = true"
                        class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg">
                    ☰
                </button>
            </header>
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl md:text-3xl text-gray-800 font-bold">Product List</h2>
                </div>
                <!-- Search and create button -->
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-6">
                    <a href="{{ route('addproduct.index') }}" class="w-full sm:w-auto">
                        <button class="px-5 py-2 bg-[#A0522D] text-white rounded-lg font-semibold hover:opacity-90 transition w-full sm:w-auto">
                            + Create New Product
                        </button>
                    </a>

                    {{-- Search Form --}}
                    <form method="GET"
                          action="{{ route('allproduct.index') }}"
                          class="relative w-full sm:w-64">

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search product..."
                               class="pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-200 outline-none w-full transition">

                        <button type="submit"
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-orange-500">
                            🔍
                        </button>
                    </form>
                </div>

                {{-- Product Table --}}
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    
                    <table class="w-full text-left text-sm sm:text-base border-collapse">

                        <thead class="bg-gray-50 border-b">
                            <tr class="text-gray-700">
                                <th class="p-3 w-10"><input type="checkbox"></th>
                                <th class="p-3 uppercase text-xs font-bold">Image</th>
                                <th class="p-3 uppercase text-xs font-bold">Name</th>
                                <th class="p-3 uppercase text-xs font-bold hidden md:table-cell">Category</th>
                                <th class="p-3 uppercase text-xs font-bold">Qty</th>
                                <th class="p-3 uppercase text-xs font-bold">Price</th>
                                <th class="p-3 text-center uppercase text-xs font-bold">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="p-3">
                                        <input type="checkbox">
                                    </td>

                                    {{-- Image (កែសម្រួលត្រង់នេះដើម្បីទាញចេញពី Array) --}}
                                    <td class="p-3">
                                        @php
                                            // ឆែកមើលថាជារូបភាពជា Array ឬជា String ធម្មតា
                                            $imagePath = 'https://via.placeholder.com/80';
                                            if ($product->images) {
                                                if (is_array($product->images) && count($product->images) > 0) {
                                                    $imagePath = asset('storage/' . $product->images[0]);
                                                } elseif (is_string($product->images)) {
                                                    $imagePath = asset('storage/' . $product->images);
                                                }
                                            }
                                        @endphp
                                        <img src="{{ $imagePath }}"
                                            alt="Product Image"
                                            class="w-14 h-14 rounded-xl object-cover shadow-sm border border-gray-100">
                                    </td>

                                    {{-- Name --}}
                                    <td class="p-3 font-semibold text-gray-800">
                                        {{ $product->name }}
                                    </td>

                                    {{-- Category --}}
                                    <td class="p-3 text-gray-600 hidden md:table-cell italic">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </td>

                                    {{-- Quantity --}}
                                    <td class="p-3 text-gray-600">
                                        {{ $product->qty }}
                                    </td>

                                    {{-- Price --}}
                                    <td class="p-3 font-bold text-orange-600">
                                        ${{ number_format($product->price, 2) }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="p-3">
                                        <div class="flex justify-center gap-2">

                                            {{-- Edit --}}
                                            <a href="{{ route('product.edit', $product->id) }}"
                                               class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition">
                                                ✎
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('product.destroy', $product->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="w-8 h-8 flex items-center justify-center rounded-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition">
                                                    ✕
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="p-12 text-center text-gray-400 italic">
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- Laravel Pagination --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>

            </div>
        </main>
    </div>
</div>