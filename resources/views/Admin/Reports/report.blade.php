@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
body { font-family: 'Inter', sans-serif; }
.custom-scrollbar::-webkit-scrollbar { width: 5px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
.no-scrollbar::-webkit-scrollbar { display: none; }

#toast {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 9999;
    transform: translateY(120%);
    opacity: 0;
    transition: transform 0.35s cubic-bezier(.4,0,.2,1), opacity 0.35s;
    pointer-events: none;
}
#toast.show {
    transform: translateY(0);
    opacity: 1;
    pointer-events: auto;
}

#export-modal {
    position: fixed;
    inset: 0;
    z-index: 9998;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0,0,0,0.45);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s;
}
#export-modal.open {
    opacity: 1;
    pointer-events: auto;
}
#export-modal .modal-box {
    background: #fff;
    border-radius: 1.25rem;
    padding: 2rem 2.25rem;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    transform: scale(0.93);
    transition: transform 0.25s;
}
#export-modal.open .modal-box {
    transform: scale(1);
}

@media print {
    body * { visibility: hidden; -webkit-print-color-adjust: exact; }
    #printable-invoice, #printable-invoice * { visibility: visible; }
    #printable-invoice { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; display: block !important; }
    .no-print { display: none !important; }
}
</style>

<title>FastBite | Reports</title>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{
    activeTab: 'reservations',

    resSearch: '',
    selectedTable: 'All',
    matchReservation(text, table) {
        let s = this.resSearch === '' || text.toLowerCase().includes(this.resSearch.toLowerCase());
        let t = this.selectedTable === 'All' || this.selectedTable == table;
        return s && t;
    },

    orderSearch: '',
    selectedStatus: 'All',
    matchOrder(text, status) {
        let s = this.orderSearch === '' || text.toLowerCase().includes(this.orderSearch.toLowerCase());
        let st = this.selectedStatus === 'All' || this.selectedStatus === status;
        return s && st;
    },

    productSearch: '',
    selectedCategory: 'All',
    matchProduct(text, category) {
        let s = this.productSearch === '' || text.toLowerCase().includes(this.productSearch.toLowerCase());
        let c = this.selectedCategory === 'All' || this.selectedCategory === category;
        return s && c;
    },

    categorySearch: '',
    matchCategory(text) {
        return this.categorySearch === '' || text.toLowerCase().includes(this.categorySearch.toLowerCase());
    },

    saleSearch: '',
    selectedSaleDate: 'All',
    matchSale(text, date) {
        let s = this.saleSearch === '' || text.toLowerCase().includes(this.saleSearch.toLowerCase());
        let d = this.selectedSaleDate === 'All' || this.selectedSaleDate === date;
        return s && d;
    },

    exportModal: false,
    exportFormat: '',
    exportLabel: '',
    exportColorClass: '',

    openExport(format) {
        const map = {
            excel: { label: 'Excel (.xlsx)', color: 'bg-emerald-600' },
            pdf:   { label: 'PDF document', color: 'bg-red-600'     },
            print: { label: 'Print preview', color: 'bg-gray-900'   },
        };
        this.exportFormat     = format;
        this.exportLabel      = map[format].label;
        this.exportColorClass = map[format].color;
        this.exportModal      = true;
    },

    confirmExport() {
        this.exportModal = false;
        if (this.exportFormat === 'print') {
            this.$nextTick(() => window.print());
        } else {
            window.location.href = '/reports/export/' + this.exportFormat + '?type=' + this.activeTab;
        }
        this.showToast(this.exportLabel);
    },

    toastMsg: '',
    showToast(label) {
        this.toastMsg = label + ' export started';
        const el = document.getElementById('toast');
        el.classList.add('show');
        setTimeout(() => el.classList.remove('show'), 3200);
    }
}">

    <div class="flex flex-col md:flex-row md:h-screen md:p-4 md:gap-6 md:overflow-hidden relative">

        {{-- Sidebar --}}
        @include('components.asidebar')

        <main class="flex-1 overflow-y-auto px-3 pb-4 md:px-0 md:pr-2 custom-scrollbar">
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-3 md:mt-0 mb-8">

                {{-- ===== HEADER ===== --}}
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-9 h-9 rounded-xl bg-[#FFE4DB] flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#EE6D3C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Reports</h2>
                            <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full"
                                x-text="activeTab.charAt(0).toUpperCase() + activeTab.slice(1)"></span>
                        </div>
                        <p class="text-sm text-gray-400 ml-12">View and export your restaurant data</p>
                    </div>

                    {{-- Export buttons --}}
                    <div class="flex items-center gap-2 flex-wrap no-print">
                        <button @click="openExport('excel')"
                            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Excel
                        </button>
                        <button @click="openExport('pdf')"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 active:scale-95 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            PDF
                        </button>
                        <button @click="openExport('print')"
                            class="flex items-center gap-2 bg-gray-900 hover:bg-gray-700 active:scale-95 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                    </div>
                </div>

                {{-- ===== STATS ROW ===== --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-3 mb-8">
                    <div class="bg-orange-50 rounded-2xl p-4 border border-orange-100">
                        <p class="text-xs font-semibold text-orange-400 uppercase tracking-wide mb-1">Reservations</p>
                        <p class="text-2xl font-bold text-orange-700">{{ $reservations->count() }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100">
                        <p class="text-xs font-semibold text-blue-400 uppercase tracking-wide mb-1">Orders</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $orders->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-4 border border-green-100">
                        <p class="text-xs font-semibold text-green-400 uppercase tracking-wide mb-1">Products</p>
                        <p class="text-2xl font-bold text-green-700">{{ $products->count() }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-2xl p-4 border border-purple-100">
                        <p class="text-xs font-semibold text-purple-400 uppercase tracking-wide mb-1">Categories</p>
                        <p class="text-2xl font-bold text-purple-700">{{ $categories->count() }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 cursor-pointer hover:border-amber-300 transition"
                         @click="activeTab = 'sales'">
                        <p class="text-xs font-semibold text-amber-500 uppercase tracking-wide mb-1">Today Sales</p>
                        <p class="text-2xl font-bold text-amber-700">${{ number_format($dailySalesTotal, 2) }}</p>
                        <p class="text-[10px] text-amber-400 mt-1">{{ now()->format('d M Y') }}</p>
                    </div>
                    <div class="bg-rose-50 rounded-2xl p-4 border border-rose-100 cursor-pointer hover:border-rose-300 transition"
                         @click="activeTab = 'sales'">
                        <p class="text-xs font-semibold text-rose-400 uppercase tracking-wide mb-1">Month Sales</p>
                        <p class="text-2xl font-bold text-rose-700">${{ number_format($monthlySalesTotal, 2) }}</p>
                        <p class="text-[10px] text-rose-400 mt-1">{{ now()->format('M Y') }}</p>
                    </div>
                </div>

                {{-- ===== TABS ===== --}}
                <div class="flex gap-1 bg-gray-100 rounded-xl p-1 mb-6 no-print overflow-x-auto no-scrollbar">
                    @foreach(['reservations','orders','products','categories','sales'] as $tab)
                        <button @click="activeTab = '{{ $tab }}'"
                            :class="activeTab === '{{ $tab }}' ? 'bg-white text-[#EE6D3C] shadow font-bold' : 'text-gray-500 hover:text-gray-700'"
                            class="flex-1 min-w-[110px] py-2 px-4 rounded-lg text-sm transition capitalize whitespace-nowrap flex items-center justify-center gap-1.5">
                            @if($tab === 'sales')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                            {{ ucfirst($tab) }}
                        </button>
                    @endforeach
                </div>

                {{-- ===== RESERVATIONS ===== --}}
                <div x-show="activeTab === 'reservations'" x-transition>
                    <div class="flex flex-wrap gap-3 mb-4">
                        <div class="relative w-full md:w-72">
                            <input type="text" placeholder="Search reservation..." x-model="resSearch"
                                class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Date & Time</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Phone</th>
                                    <th class="px-4 py-3 hidden lg:table-cell">Table</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($reservations as $res)
                                    <tr class="hover:bg-orange-50/40 transition"
                                        x-show="matchReservation('{{ $res->full_name }} {{ $res->phone_number }} Table {{ $res->table_id }}', '{{ $res->table_id }}')">
                                        <td class="px-4 py-3 text-gray-400 text-xs font-mono">#{{ $res->id }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $res->full_name }}</td>
                                        <td class="px-4 py-3 hidden md:table-cell">
                                            <span class="text-gray-700">{{ $res->date }}</span>
                                            <span class="ml-1 text-xs text-gray-400">{{ $res->time }}</span>
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell text-gray-500 text-sm">{{ $res->phone_number }}</td>
                                        <td class="px-4 py-3 hidden lg:table-cell">
                                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Table {{ $res->table_id }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="p-10 text-center text-gray-400 italic text-sm">No reservation data found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ===== ORDERS ===== --}}
                <div x-show="activeTab === 'orders'" x-transition>
                    <div class="flex flex-wrap gap-3 mb-4">
                        <div class="relative w-full md:w-72">
                            <input type="text" placeholder="Search order..." x-model="orderSearch"
                                class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <select x-model="selectedStatus" class="py-2.5 px-4 border border-gray-200 rounded-xl text-sm bg-gray-50 outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="All">All Statuses</option>
                            @foreach($orders->pluck('status')->unique() as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Items</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Date</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Total</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-orange-50/40 transition"
                                        x-show="matchOrder('#{{ $order->id }} {{ $order->status }}', '{{ $order->status }}')">
                                        <td class="px-4 py-3 text-gray-400 text-xs font-mono">#{{ $order->id }}</td>
                                        <td class="px-4 py-3">
                                            @if($order->items && $order->items->count())
                                                <div class="text-sm font-medium text-gray-800">
                                                    {{ $order->items->map(fn($i) => ($i->name ?? $i->product?->name ?? 'Unknown') . ' ×' . $i->quantity)->join(', ') }}
                                                </div>
                                                <div class="text-xs text-gray-400 mt-0.5">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</div>
                                            @else
                                                <span class="text-gray-400 text-xs italic">No items</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell text-gray-600 text-sm">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell font-semibold text-gray-800">${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $sc = [
                                                    'pending'   => 'bg-yellow-100 text-yellow-700',
                                                    'confirmed' => 'bg-blue-100 text-blue-700',
                                                    'completed' => 'bg-green-100 text-green-700',
                                                    'cancelled' => 'bg-red-100 text-red-700',
                                                ];
                                                $c = $sc[strtolower($order->status)] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $c }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="p-10 text-center text-gray-400 italic text-sm">No order data found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ===== PRODUCTS ===== --}}
                <div x-show="activeTab === 'products'" x-transition>
                    <div class="flex flex-wrap gap-3 mb-4">
                        <div class="relative w-full md:w-72">
                            <input type="text" placeholder="Search product..." x-model="productSearch"
                                class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <select x-model="selectedCategory" class="py-2.5 px-4 border border-gray-200 rounded-xl text-sm bg-gray-50 outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="All">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Category</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Price</th>
                                    <th class="px-4 py-3 hidden lg:table-cell">Cost</th>
                                    <th class="px-4 py-3 hidden lg:table-cell">Qty</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($products as $product)
                                    <tr class="hover:bg-orange-50/40 transition"
                                        x-show="matchProduct('{{ $product->name }} {{ $product->category?->name }}', '{{ $product->category?->name }}')">
                                        <td class="px-4 py-3 text-gray-400 text-xs font-mono">#{{ $product->id }}</td>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                            @if($product->description)
                                                <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $product->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell">
                                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">{{ $product->category?->name ?? 'Uncategorized' }}</span>
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell font-semibold text-gray-800">${{ number_format($product->price, 2) }}</td>
                                        <td class="px-4 py-3 hidden lg:table-cell text-gray-500">${{ number_format($product->cost ?? 0, 2) }}</td>
                                        <td class="px-4 py-3 hidden lg:table-cell">
                                            @php $qty = $product->qty ?? 0; @endphp
                                            <span class="px-2 py-0.5 rounded-lg text-xs font-bold {{ $qty > 10 ? 'bg-green-100 text-green-700' : ($qty > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $product->qty ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="p-10 text-center text-gray-400 italic text-sm">No product data found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ===== CATEGORIES ===== --}}
                <div x-show="activeTab === 'categories'" x-transition>
                    <div class="flex flex-wrap gap-3 mb-4">
                        <div class="relative w-full md:w-72">
                            <input type="text" placeholder="Search category..." x-model="categorySearch"
                                class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Category Name</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Code</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Total Products</th>
                                    <th class="px-4 py-3 hidden lg:table-cell">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($categories as $cat)
                                    <tr class="hover:bg-orange-50/40 transition"
                                        x-show="matchCategory('{{ $cat->name }}')">
                                        <td class="px-4 py-3 text-gray-400 text-xs font-mono">#{{ $cat->id }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $cat->name }}</td>
                                        <td class="px-4 py-3 hidden md:table-cell text-gray-500 text-xs font-mono">{{ $cat->code ?? '—' }}</td>
                                        <td class="px-4 py-3 hidden md:table-cell">
                                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">{{ $cat->products_count }} items</span>
                                        </td>
                                        <td class="px-4 py-3 hidden lg:table-cell text-gray-400 text-xs">{{ \Carbon\Carbon::parse($cat->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="p-10 text-center text-gray-400 italic text-sm">No category data found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ===== SALES ===== --}}
                <div x-show="activeTab === 'sales'" x-transition>

                    {{-- Summary Strip --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="relative overflow-hidden rounded-2xl bg-[#FFF8F5] border border-[#FDDDD0] p-4">
                            <div class="absolute -right-3 -top-3 w-20 h-20 rounded-full bg-[#EE6D3C]/10"></div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#EE6D3C] mb-1">Today</p>
                            <p class="text-2xl font-black text-gray-900">${{ number_format($todayTotal, 2) }}</p>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="inline-flex items-center gap-1 bg-[#EE6D3C]/10 text-[#EE6D3C] text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    {{ $todayCount }} orders
                                </span>
                                <span class="text-[10px] text-gray-400">{{ now()->format('d M') }}</span>
                            </div>
                        </div>
                        <div class="relative overflow-hidden rounded-2xl bg-[#F5F8FF] border border-[#DDEAFF] p-4">
                            <div class="absolute -right-3 -top-3 w-20 h-20 rounded-full bg-blue-500/10"></div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-500 mb-1">{{ now()->format('M Y') }}</p>
                            <p class="text-2xl font-black text-gray-900">${{ number_format($monthlySalesTotal, 2) }}</p>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="inline-flex items-center gap-1 bg-blue-500/10 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    {{ $monthlyCount }} orders
                                </span>
                            </div>
                        </div>
                        <div class="relative overflow-hidden rounded-2xl bg-gray-900 border border-gray-800 p-4">
                            <div class="absolute -right-3 -top-3 w-20 h-20 rounded-full bg-white/5"></div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Sales</p>
                            <p class="text-2xl font-black text-[#EE6D3C]">${{ number_format($grandTotal, 2) }}</p>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="inline-flex items-center gap-1 bg-white/10 text-gray-300 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    {{ $completedOrders->count() }} completed
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Search & Date Filter --}}
                    <div class="flex flex-wrap items-center gap-2 mb-5">
                        <div class="relative flex-1 min-w-[180px] max-w-xs">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" placeholder="Search order ID…" x-model="saleSearch"
                                class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-sm outline-none focus:ring-2 focus:ring-[#EE6D3C]/30 focus:border-[#EE6D3C]/50 transition">
                        </div>
                        <select x-model="selectedSaleDate"
                            class="py-2 px-3 rounded-xl border border-gray-200 bg-gray-50 text-sm outline-none focus:ring-2 focus:ring-[#EE6D3C]/30 focus:border-[#EE6D3C]/50 transition">
                            <option value="All">📅 All Dates</option>
                            @foreach($salesByDate->keys() as $dk)
                                <option value="{{ $dk }}">{{ \Carbon\Carbon::parse($dk)->format('d M Y') }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sales Table --}}
                    <div class="w-full overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-3">Order ID</th>
                                    <th class="px-4 py-3 hidden md:table-cell">Date & Time</th>
                                    <th class="px-4 py-3 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($completedOrders->sortByDesc('created_at') as $sale)
                                    <tr class="hover:bg-[#FFF8F5] transition"
                                        x-show="matchSale('#{{ $sale->id }}', '{{ \Carbon\Carbon::parse($sale->created_at)->toDateString() }}')">
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-[#FFE4DB] text-[10px] font-black text-[#EE6D3C]">
                                                #{{ $sale->id }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell">
                                            <p class="text-gray-700 text-sm font-medium">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($sale->created_at)->format('h:i A') }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <p class="text-sm font-black text-gray-900">${{ number_format($sale->total_amount ?? 0, 2) }}</p>
                                            <span class="text-[10px] font-bold text-green-500 bg-green-50 px-1.5 py-0.5 rounded-full">Paid</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="p-10 text-center text-gray-400 italic text-sm">No completed sales yet</td></tr>
                                @endforelse
                            </tbody>
                            @if($completedOrders->count())
                            <tfoot>
                                <tr class="bg-[#FFF8F5] border-t-2 border-[#EE6D3C]/20">
                                    <td colspan="2" class="px-4 py-3 text-xs font-bold uppercase tracking-widest text-gray-400">
                                        Grand Total · {{ $completedOrders->count() }} orders
                                    </td>
                                    <td class="px-4 py-3 text-right text-base font-black text-[#EE6D3C]">
                                        ${{ number_format($grandTotal, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>

                </div>{{-- end sales --}}

            </div>
        </main>

        {{-- ===== EXPORT CONFIRM MODAL ===== --}}
        <div id="export-modal" :class="exportModal ? 'open' : ''" @click.self="exportModal = false">
            <div class="modal-box">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#FFE4DB] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#EE6D3C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Confirm Export</h3>
                        <p class="text-xs text-gray-400">This will download your report</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 mb-5 border border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Format</span>
                        <span class="font-semibold text-gray-800" x-text="exportLabel"></span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-gray-500">Section</span>
                        <span class="font-semibold text-[#EE6D3C] capitalize" x-text="activeTab"></span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-gray-500">Generated</span>
                        <span class="font-semibold text-gray-800">{{ now()->format('d M Y, h:i A') }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button @click="exportModal = false"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button @click="confirmExport()"
                        class="flex-1 py-2.5 rounded-xl text-sm font-bold text-white transition active:scale-95"
                        :class="exportColorClass">
                        Export now
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== TOAST ===== --}}
        <div id="toast" class="no-print">
            <div class="flex items-center gap-3 bg-gray-900 text-white px-5 py-3.5 rounded-2xl shadow-xl text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span x-text="toastMsg"></span>
            </div>
        </div>

        {{-- ===== PRINTABLE ===== --}}
        <div id="printable-invoice" class="hidden">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold uppercase underline">FastBite — Full Report</h1>
                <p class="text-sm mt-2">Generated: {{ now()->format('d M Y, h:i A') }}</p>
            </div>

            <h2 class="text-xl font-bold mb-2 mt-6">Reservations</h2>
            <table class="w-full text-left border-collapse mb-8">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="py-2">Name</th><th class="py-2">Phone</th>
                        <th class="py-2">Date</th><th class="py-2">Table</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $res)
                        <tr class="border-b">
                            <td class="py-2">{{ $res->full_name }}</td>
                            <td class="py-2">{{ $res->phone_number }}</td>
                            <td class="py-2">{{ $res->date }} {{ $res->time }}</td>
                            <td class="py-2">Table {{ $res->table_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h2 class="text-xl font-bold mb-2 mt-6">Orders</h2>
            <table class="w-full text-left border-collapse mb-8">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="py-2">ID</th><th class="py-2">Items</th>
                        <th class="py-2">Status</th><th class="py-2">Total</th><th class="py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                        <tr class="border-b">
                            <td class="py-2">#{{ $o->id }}</td>
                            <td class="py-2">
                                @if($o->items && $o->items->count())
                                    {{ $o->items->map(fn($i) => ($i->name ?? $i->product?->name ?? 'Unknown') . ' ×' . $i->quantity)->join(', ') }}
                                @else —
                                @endif
                            </td>
                            <td class="py-2">{{ ucfirst($o->status) }}</td>
                            <td class="py-2">${{ number_format($o->total_amount ?? 0, 2) }}</td>
                            <td class="py-2">{{ \Carbon\Carbon::parse($o->created_at)->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h2 class="text-xl font-bold mb-2 mt-6">Products</h2>
            <table class="w-full text-left border-collapse mb-8">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="py-2">Name</th><th class="py-2">Category</th>
                        <th class="py-2">Price</th><th class="py-2">Cost</th><th class="py-2">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr class="border-b">
                            <td class="py-2">{{ $p->name }}</td>
                            <td class="py-2">{{ $p->category?->name ?? 'N/A' }}</td>
                            <td class="py-2">${{ number_format($p->price, 2) }}</td>
                            <td class="py-2">${{ number_format($p->cost ?? 0, 2) }}</td>
                            <td class="py-2">{{ $p->qty ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h2 class="text-xl font-bold mb-2 mt-6">Categories</h2>
            <table class="w-full text-left border-collapse mb-8">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="py-2">ID</th><th class="py-2">Name</th>
                        <th class="py-2">Code</th><th class="py-2">Total Products</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $c)
                        <tr class="border-b">
                            <td class="py-2">#{{ $c->id }}</td>
                            <td class="py-2">{{ $c->name }}</td>
                            <td class="py-2">{{ $c->code ?? '—' }}</td>
                            <td class="py-2">{{ $c->products_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h2 class="text-xl font-bold mb-2 mt-6">Daily Sales Report</h2>
            <table class="w-full text-left border-collapse mb-4">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="py-2 text-sm">Order ID</th>
                        <th class="py-2 text-sm">Date & Time</th>
                        <th class="py-2 text-sm text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedOrders->sortByDesc('created_at') as $sale)
                        <tr class="border-b border-gray-200">
                            <td class="py-1.5 text-sm">#{{ $sale->id }}</td>
                            <td class="py-1.5 text-sm">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y, h:i A') }}</td>
                            <td class="py-1.5 text-sm text-right font-semibold">${{ number_format($sale->total_amount ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="border-t-2 border-black">
                        <td colspan="2" class="py-1.5 text-sm font-bold text-right">Grand Total:</td>
                        <td class="py-1.5 text-sm font-bold text-right">${{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-8 rounded-2xl overflow-hidden">
                <div style="background:#EE6D3C;" class="flex items-center justify-between px-6 py-5">
                    <div>
                        <p style="font-size:10px;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:2px;">Grand Total · All Sales</p>
                        <p style="font-size:12px;color:rgba(255,255,255,0.6);">{{ $completedOrders->count() }} completed orders</p>
                    </div>
                    <p style="font-size:2rem;font-weight:900;color:#fff;">${{ number_format($grandTotal, 2) }}</p>
                </div>
            </div>
        </div>

    </div>
</div>