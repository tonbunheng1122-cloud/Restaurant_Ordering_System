@vite('resources/css/app.css')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
body { font-family: 'Inter', sans-serif; }
.custom-scrollbar::-webkit-scrollbar { width: 5px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
.no-scrollbar::-webkit-scrollbar { display: none; }
@media print {
    body * { visibility: hidden; -webkit-print-color-adjust: exact; }
    #printable-invoice, #printable-invoice * { visibility: visible; }
    #printable-invoice { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; display: block !important; }
    .no-print { display: none !important; }
}
</style>

<title>FastBite | Reports</title>

<div class="bg-[#FFE4DB] min-h-screen"
x-data="{
    activeTab: 'reservations',
    resSearch: '', selectedTable: 'All',
    matchReservation(text, table) {
        let s = this.resSearch === '' || text.toLowerCase().includes(this.resSearch.toLowerCase());
        let t = this.selectedTable === 'All' || this.selectedTable == table;
        return s && t;
    },
    orderSearch: '', selectedStatus: 'All',
    matchOrder(text, status) {
        let s = this.orderSearch === '' || text.toLowerCase().includes(this.orderSearch.toLowerCase());
        let st = this.selectedStatus === 'All' || this.selectedStatus === status;
        return s && st;
    },
    productSearch: '', selectedCategory: 'All',
    matchProduct(text, category) {
        let s = this.productSearch === '' || text.toLowerCase().includes(this.productSearch.toLowerCase());
        let c = this.selectedCategory === 'All' || this.selectedCategory === category;
        return s && c;
    },
    categorySearch: '',
    matchCategory(text) { return this.categorySearch === '' || text.toLowerCase().includes(this.categorySearch.toLowerCase()); },
    exportUrl(format) { return '/reports/export/' + format + '?type=' + this.activeTab; }
}">

<div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">

    <aside>@include('components.asidebar')</aside>

    <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

        <button class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>

        <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-800">Reports</h2>
                    <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full"
                        x-text="activeTab.charAt(0).toUpperCase() + activeTab.slice(1)"></span>
                </div>

                <!-- Export Buttons -->
                <div class="flex items-center gap-2 flex-wrap no-print">

                    {{-- Excel/CSV --}}
                    <a :href="exportUrl('excel')"
                        class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-4 py-3 rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Excel
                    </a>

                    {{-- PDF --}}
                    <a :href="exportUrl('pdf')"
                        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-3 rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        PDF
                    </a>

                    {{-- Print --}}
                    <button onclick="window.print()"
                        class="flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold px-4 py-3 rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Print
                    </button>

                </div>
            </div>

            <!-- Tabs -->
            <div class="flex gap-1 bg-gray-100 rounded-xl p-1 mb-6 no-print overflow-x-auto no-scrollbar">
                <template x-for="tab in ['reservations','orders','products','categories']" :key="tab">
                    <button @click="activeTab = tab"
                        :class="activeTab === tab ? 'bg-white text-[#EE6D3C] shadow font-bold' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 min-w-[110px] py-2 px-4 rounded-lg text-sm transition capitalize whitespace-nowrap"
                        x-text="tab">
                    </button>
                </template>
            </div>

            <!-- RESERVATIONS -->
            <div x-show="activeTab === 'reservations'" x-transition>
                <div class="flex flex-wrap gap-3 mb-4">
                    <div class="relative w-full md:w-72">
                        <input type="text" placeholder="Search reservation..." x-model="resSearch"
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50"><tr class="border-b text-gray-600 uppercase text-xs">
                            <th class="p-4">ID</th><th class="p-4">Name</th>
                            <th class="p-4 hidden md:table-cell">Date</th><th class="p-4 hidden md:table-cell">Phone</th>
                            <th class="p-4 hidden lg:table-cell">Table</th>
                        </tr></thead>
                        <tbody class="divide-y">
                            @forelse($reservations as $res)
                            <tr class="hover:bg-orange-50/50 transition" x-show="matchReservation('{{ $res->full_name }} {{ $res->phone_number }} Table {{ $res->table_id }}', '{{ $res->table_id }}')">
                                <td class="p-4 font-medium text-gray-700">#{{ $res->id }}</td>
                                <td class="p-4">{{ $res->full_name }}</td>
                                <td class="p-4 hidden md:table-cell"><span>{{ $res->date }}</span><div class="text-xs text-gray-400">{{ $res->time }}</div></td>
                                <td class="p-4 hidden md:table-cell text-gray-600">{{ $res->phone_number }}</td>
                                <td class="p-4 hidden lg:table-cell"><span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Table {{ $res->table_id }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">No reservation data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ORDERS -->
            <div x-show="activeTab === 'orders'" x-transition>
                <div class="flex flex-wrap gap-3 mb-4">
                    <div class="relative w-full md:w-72">
                        <input type="text" placeholder="Search order..." x-model="orderSearch"
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <select x-model="selectedStatus" class="py-3 px-4 border border-gray-300 rounded-xl text-sm bg-white">
                        <option value="All">All Statuses</option>
                        @foreach($orders->pluck('status')->unique() as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50"><tr class="border-b text-gray-600 uppercase text-xs">
                            <th class="p-4">ID</th><th class="p-4">Customer</th>
                            <th class="p-4 hidden md:table-cell">Date</th><th class="p-4 hidden md:table-cell">Total</th>
                            <th class="p-4">Status</th>
                        </tr></thead>
                        <tbody class="divide-y">
                            @forelse($orders as $order)
                            <tr class="hover:bg-orange-50/50 transition" x-show="matchOrder('{{ $order->customer_name ?? $order->id }} {{ $order->status }}', '{{ $order->status }}')">
                                <td class="p-4 font-medium text-gray-700">#{{ $order->id }}</td>
                                <td class="p-4">{{ $order->customer_name ?? 'Guest' }}</td>
                                <td class="p-4 hidden md:table-cell text-gray-600">
                                    <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</span>
                                    <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</div>
                                </td>
                                <td class="p-4 hidden md:table-cell font-semibold text-gray-800">${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                <td class="p-4">
                                    @php $sc=['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-blue-100 text-blue-700','completed'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700']; $c=$sc[strtolower($order->status)]??'bg-gray-100 text-gray-700'; @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $c }}">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">No order data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PRODUCTS -->
            <div x-show="activeTab === 'products'" x-transition>
                <div class="flex flex-wrap gap-3 mb-4">
                    <div class="relative w-full md:w-72">
                        <input type="text" placeholder="Search product..." x-model="productSearch"
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <select x-model="selectedCategory" class="py-3 px-4 border border-gray-300 rounded-xl text-sm bg-white">
                        <option value="All">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50"><tr class="border-b text-gray-600 uppercase text-xs">
                            <th class="p-4">ID</th><th class="p-4">Product</th>
                            <th class="p-4 hidden md:table-cell">Category</th><th class="p-4 hidden md:table-cell">Price</th>
                            <th class="p-4 hidden lg:table-cell">Stock</th>
                        </tr></thead>
                        <tbody class="divide-y">
                            @forelse($products as $product)
                            <tr class="hover:bg-orange-50/50 transition" x-show="matchProduct('{{ $product->name }} {{ $product->category?->name }}', '{{ $product->category?->name }}')">
                                <td class="p-4 font-medium text-gray-700">#{{ $product->id }}</td>
                                <td class="p-4 font-medium">{{ $product->name }}</td>
                                <td class="p-4 hidden md:table-cell"><span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">{{ $product->category?->name ?? 'Uncategorized' }}</span></td>
                                <td class="p-4 hidden md:table-cell font-semibold text-gray-800">${{ number_format($product->price, 2) }}</td>
                                <td class="p-4 hidden lg:table-cell text-gray-600">{{ $product->stock ?? 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">No product data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CATEGORIES -->
            <div x-show="activeTab === 'categories'" x-transition>
                <div class="flex flex-wrap gap-3 mb-4">
                    <div class="relative w-full md:w-72">
                        <input type="text" placeholder="Search category..." x-model="categorySearch"
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50"><tr class="border-b text-gray-600 uppercase text-xs">
                            <th class="p-4">ID</th><th class="p-4">Category Name</th>
                            <th class="p-4 hidden md:table-cell">Total Products</th>
                            <th class="p-4 hidden lg:table-cell">Created At</th>
                        </tr></thead>
                        <tbody class="divide-y">
                            @forelse($categories as $cat)
                            <tr class="hover:bg-orange-50/50 transition" x-show="matchCategory('{{ $cat->name }}')">
                                <td class="p-4 font-medium text-gray-700">#{{ $cat->id }}</td>
                                <td class="p-4 font-medium">{{ $cat->name }}</td>
                                <td class="p-4 hidden md:table-cell"><span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">{{ $cat->products_count }} items</span></td>
                                <td class="p-4 hidden lg:table-cell text-gray-500 text-xs">{{ \Carbon\Carbon::parse($cat->created_at)->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-10 text-center text-gray-400 italic">No category data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- PRINTABLE -->
    <div id="printable-invoice" class="hidden">
        <div class="text-center mb-8"><h1 class="text-3xl font-bold uppercase underline">FastBite — Full Report</h1><p class="text-sm mt-2">Generated: {{ now()->format('d M Y, h:i A') }}</p></div>
        <h2 class="text-xl font-bold mb-2 mt-6">Reservations</h2>
        <table class="w-full text-left border-collapse mb-8"><thead><tr class="border-b-2 border-black"><th class="py-2">Name</th><th class="py-2">Phone</th><th class="py-2">Date</th><th class="py-2">Table</th></tr></thead><tbody>@foreach($reservations as $res)<tr class="border-b"><td class="py-2">{{ $res->full_name }}</td><td class="py-2">{{ $res->phone_number }}</td><td class="py-2">{{ $res->date }} {{ $res->time }}</td><td class="py-2">Table {{ $res->table_id }}</td></tr>@endforeach</tbody></table>
        <h2 class="text-xl font-bold mb-2 mt-6">Orders</h2>
        <table class="w-full text-left border-collapse mb-8"><thead><tr class="border-b-2 border-black"><th class="py-2">ID</th><th class="py-2">Status</th><th class="py-2">Total</th><th class="py-2">Date</th></tr></thead><tbody>@foreach($orders as $o)<tr class="border-b"><td class="py-2">#{{ $o->id }}</td><td class="py-2">{{ ucfirst($o->status) }}</td><td class="py-2">${{ number_format($o->total_amount??0,2) }}</td><td class="py-2">{{ \Carbon\Carbon::parse($o->created_at)->format('d M Y') }}</td></tr>@endforeach</tbody></table>
        <h2 class="text-xl font-bold mb-2 mt-6">Products</h2>
        <table class="w-full text-left border-collapse mb-8"><thead><tr class="border-b-2 border-black"><th class="py-2">Name</th><th class="py-2">Category</th><th class="py-2">Price</th><th class="py-2">Stock</th></tr></thead><tbody>@foreach($products as $p)<tr class="border-b"><td class="py-2">{{ $p->name }}</td><td class="py-2">{{ $p->category?->name??'N/A' }}</td><td class="py-2">${{ number_format($p->price,2) }}</td><td class="py-2">{{ $p->stock??'N/A' }}</td></tr>@endforeach</tbody></table>
        <h2 class="text-xl font-bold mb-2 mt-6">Categories</h2>
        <table class="w-full text-left border-collapse mb-8"><thead><tr class="border-b-2 border-black"><th class="py-2">ID</th><th class="py-2">Name</th><th class="py-2">Total Products</th></tr></thead><tbody>@foreach($categories as $c)<tr class="border-b"><td class="py-2">#{{ $c->id }}</td><td class="py-2">{{ $c->name }}</td><td class="py-2">{{ $c->products_count }}</td></tr>@endforeach</tbody></table>
    </div>

</div>
</div>