@vite('resources/css/app.css')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    [x-cloak] { display: none !important; }
    @media print {
        body * { visibility: hidden; -webkit-print-color-adjust: exact; }
        #printable-invoice, #printable-invoice * { visibility: visible; }
        #printable-invoice { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; display: block !important; }
        .no-print { display: none !important; }
    }
</style>
<title>FastBite | Menu</title>

@php
$ordersJson = $orders->map(function($o) {
    return [
        'id'           => $o->id,
        'status'       => $o->status ?? 'pending',
        'total_amount' => $o->total_amount,
        'created_at'   => $o->created_at->format('d M Y'),
        'time'         => $o->created_at->format('h:i A'),
        'items'        => $o->items->map(function($i, $idx) {
            return [
                'uid'      => $i->id ?? $idx,
                'name'     => $i->name ?? 'Unknown',
                'quantity' => $i->quantity ?? 0,
            ];
        })->values()->toArray(),
    ];
})->values();
@endphp

<div class="bg-[#FFE4DB] min-h-screen"
    x-data="{
        categories: {{ $categories }},
        products: {{ $products }},
        orders: {{ $ordersJson }},

        activeCategory: null,
        cart: [],
        showOrderModal: false,
        showStatusModal: false,
        editOrderId: null,
        editOrderStatus: 'pending',
        stockAlerts: [],
        toast: null,
        currentPage: 1,
        perPage: 6,

        showToast(msg, type) {
            this.toast = { msg, type: type || 'success' };
            setTimeout(() => { this.toast = null; }, 3500);
        },

        get filteredProducts() {
            if (!this.activeCategory) return this.products;
            return this.products.filter(p => p.category === this.activeCategory);
        },
        get paginatedProducts() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredProducts.slice(start, start + this.perPage);
        },
        get totalPages() { return Math.ceil(this.filteredProducts.length / this.perPage); },
        get pageNumbers() { return Array.from({ length: this.totalPages }, (_, i) => i + 1); },
        setCategory(cat) { this.activeCategory = cat; this.currentPage = 1; },
        get subtotal() { return this.cart.reduce((sum, item) => sum + item.price * item.qty, 0); },

        getProductImage(image) {
            if (image) return '/storage/' + image;
            return 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=200&q=80';
        },
        addToCart(id, name, price, image) {
            const ex = this.cart.find(i => i.id === id);
            if (ex) { ex.qty++; } else { this.cart.push({ id, name, price, image, qty: 1 }); }
        },
        removeFromCart(id) {
            const ex = this.cart.find(i => i.id === id);
            if (ex) { ex.qty--; if (ex.qty === 0) this.cart = this.cart.filter(i => i.id !== id); }
        },

        saveOrder() {
            fetch('/order/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart: this.cart, total: this.subtotal })
            })
            .then(r => r.json())
            .then(data => {
                if (data.message) {
                    if (data.stock_alerts && data.stock_alerts.length > 0) this.stockAlerts = data.stock_alerts;

                    const now = new Date();
                    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    const pad = n => String(n).padStart(2,'0');
                    const h = now.getHours();
                    const h12 = h > 12 ? h - 12 : (h === 0 ? 12 : h);
                    const ampm = h >= 12 ? 'PM' : 'AM';

                    this.orders.unshift({
                        id: data.order_id,
                        status: 'pending',
                        total_amount: this.subtotal,
                        created_at: pad(now.getDate()) + ' ' + months[now.getMonth()] + ' ' + now.getFullYear(),
                        time: pad(h12) + ':' + pad(now.getMinutes()) + ' ' + ampm,
                        items: this.cart.map((i, idx) => ({ uid: idx, name: i.name, quantity: i.qty })),
                    });

                    this.cart = [];
                    this.showOrderModal = false;
                    this.showToast('Order #' + data.order_id + ' saved!');
                } else {
                    this.showToast(data.error || 'Order failed', 'error');
                }
            })
            .catch(() => this.showToast('Network error. Please try again.', 'error'));
        },

        openStatusModal(orderId, currentStatus) {
            this.editOrderId = orderId;
            this.editOrderStatus = currentStatus;
            this.showStatusModal = true;
        },

        updateStatus() {
            fetch('/order/' + this.editOrderId + '/status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: this.editOrderStatus })
            })
            .then(r => r.json())
            .then(data => {
                if (data.message) {
                    const order = this.orders.find(o => o.id === this.editOrderId);
                    if (order) order.status = this.editOrderStatus;
                    this.showStatusModal = false;
                    this.showToast('Order #' + this.editOrderId + ' → ' + this.editOrderStatus.charAt(0).toUpperCase() + this.editOrderStatus.slice(1));
                } else {
                    this.showToast('Update failed', 'error');
                }
            })
            .catch(() => this.showToast('Network error', 'error'));
        },

        deleteOrder(id) {
            if (!confirm('Delete order #' + id + '? This cannot be undone.')) return;
            fetch('/order/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.message) {
                    this.orders = this.orders.filter(o => o.id !== id);
                    this.showToast('Order #' + id + ' deleted.');
                } else {
                    this.showToast('Delete failed', 'error');
                }
            })
            .catch(() => this.showToast('Network error', 'error'));
        },

        printInvoice() { window.print(); }
    }">

    {{-- ===== TOAST ===== --}}
    <div x-show="toast" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[60] no-print pointer-events-none">
        <div class="flex items-center gap-3 px-6 py-3.5 rounded-2xl shadow-2xl text-sm font-semibold whitespace-nowrap"
            :class="toast && toast.type === 'error' ? 'bg-red-600 text-white' : 'bg-gray-900 text-white'">
            <template x-if="toast && toast.type !== 'error'">
                <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </template>
            <template x-if="toast && toast.type === 'error'">
                <svg class="w-4 h-4 text-red-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </template>
            <span x-text="toast ? toast.msg : ''"></span>
        </div>
    </div>

    {{-- ===== STOCK ALERT BANNERS ===== --}}
    @if($outOfStockProducts->count() || $lowStockProducts->count())
    <div class="no-print">
        @if($outOfStockProducts->count())
        <div class="flex items-start gap-3 bg-red-50 border-b border-red-200 px-6 py-3 text-sm text-red-700">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div><strong>🚫 Out of Stock:</strong> {{ $outOfStockProducts->pluck('name')->join(', ') }} — Please restock immediately.</div>
        </div>
        @endif
        @if($lowStockProducts->count())
        <div class="flex items-start gap-3 bg-amber-50 border-b border-amber-200 px-6 py-3 text-sm text-amber-700">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>⚠️ Low Stock (≤2 units):</strong>
                @foreach($lowStockProducts as $p)
                    <span class="font-semibold">{{ $p->name }}</span> ({{ $p->qty }} left)@if(!$loop->last), @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- ===== POST-ORDER STOCK TOASTS ===== --}}
    <div x-show="stockAlerts.length > 0" x-cloak class="fixed top-4 right-4 z-50 space-y-2 no-print" style="max-width:340px">
        <template x-for="(alert, i) in stockAlerts" :key="i">
            <div class="flex items-start gap-3 p-4 rounded-xl shadow-lg border"
                :class="alert.qty <= 0 ? 'bg-red-50 border-red-200 text-red-700' : 'bg-amber-50 border-amber-200 text-amber-700'">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="font-bold text-sm" x-text="alert.qty <= 0 ? '🚫 Out of Stock' : '⚠️ Low Stock'"></p>
                    <p class="text-xs mt-0.5" x-text="alert.name + ' — ' + alert.qty + ' units left'"></p>
                </div>
                <button @click="stockAlerts.splice(i,1)" class="ml-auto text-current opacity-50 hover:opacity-100 text-lg leading-none">✕</button>
            </div>
        </template>
    </div>

    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative no-print">
        <aside>@include('components.asidebar')</aside>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

            <button class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            {{-- Menu --}}
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-6">
                <h2 class="text-2xl md:text-3xl text-gray-800 font-bold mb-6">Menu</h2>

                <div class="flex overflow-x-auto gap-3 pb-4 mb-8 no-scrollbar">
                    <button @click="setCategory(null)"
                        :class="activeCategory === null ? 'bg-[#EE6D3C] text-white' : 'bg-white border border-gray-300 hover:bg-gray-100'"
                        class="flex-shrink-0 min-w-[120px] p-4 rounded-lg transition text-left">
                        <div class="font-bold text-lg">All</div>
                        <div class="text-xs opacity-80" x-text="products.length + ' items'"></div>
                    </button>
                    <template x-for="cat in categories" :key="cat.name">
                        <button @click="setCategory(cat.name)"
                            :class="activeCategory === cat.name ? 'bg-[#EE6D3C] text-white' : 'bg-white border border-gray-300 hover:bg-gray-100'"
                            class="flex-shrink-0 min-w-[120px] p-4 rounded-lg transition text-left">
                            <div class="font-bold text-lg" x-text="cat.name"></div>
                            <div class="text-xs opacity-80" x-text="cat.count + ' items'"></div>
                        </button>
                    </template>
                </div>

                <div class="flex flex-col xl:flex-row gap-8">
                    <div class="flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <template x-if="filteredProducts.length === 0">
                                <div class="col-span-3 text-center text-gray-400 py-20"><p class="text-xl">No products found.</p></div>
                            </template>
                            <template x-for="product in paginatedProducts" :key="product.id">
                                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group relative">
                                    <template x-if="product.qty <= 2 && product.qty > 0">
                                        <div class="absolute top-3 left-3 z-10 bg-amber-400 text-white text-xs font-bold px-2 py-1 rounded-full">⚠️ Low</div>
                                    </template>
                                    <template x-if="product.qty <= 0">
                                        <div class="absolute top-3 left-3 z-10 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">🚫 Out</div>
                                    </template>
                                    <div class="p-3">
                                        <img :src="getProductImage(product.image)" class="w-full h-40 md:h-48 object-cover rounded-2xl group-hover:scale-105 transition cursor-pointer" :alt="product.name">
                                    </div>
                                    <div class="p-5 pt-0">
                                        <div class="text-gray-700 font-bold text-sm" x-text="product.name"></div>
                                        <div class="text-xs text-gray-400 mt-0.5" x-text="'Stock: ' + product.qty + ' units'"></div>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[#EE6D3C] font-bold text-xl" x-text="'$' + product.price.toFixed(2)"></span>
                                            <div class="flex items-center gap-2">
                                                <button @click="removeFromCart(product.id)" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 transition font-bold text-gray-600">-</button>
                                                <span class="font-bold w-4 text-center" x-text="cart.find(i => i.id === product.id)?.qty || 0"></span>
                                                <button @click="addToCart(product.id, product.name, product.price, getProductImage(product.image))"
                                                    :disabled="product.qty <= 0"
                                                    class="w-8 h-8 rounded-lg bg-[#EE6D3C] text-white hover:bg-orange-600 transition font-bold disabled:opacity-40 disabled:cursor-not-allowed">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div x-show="totalPages > 1" class="flex justify-center items-center gap-2 mt-8 flex-wrap">
                            <button @click="currentPage--" :disabled="currentPage === 1" class="w-9 h-9 rounded-lg bg-white border border-gray-300 hover:bg-orange-50 disabled:opacity-40 disabled:cursor-not-allowed transition font-bold text-gray-600 flex items-center justify-center text-lg">‹</button>
                            <template x-for="page in pageNumbers" :key="page">
                                <button @click="currentPage = page"
                                    :class="currentPage === page ? 'bg-[#EE6D3C] text-white border-[#EE6D3C] shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-orange-50'"
                                    class="w-9 h-9 rounded-lg border font-bold transition text-sm"><span x-text="page"></span></button>
                            </template>
                            <button @click="currentPage++" :disabled="currentPage === totalPages" class="w-9 h-9 rounded-lg bg-white border border-gray-300 hover:bg-orange-50 disabled:opacity-40 disabled:cursor-not-allowed transition font-bold text-gray-600 flex items-center justify-center text-lg">›</button>
                        </div>
                    </div>

                    <div class="w-full xl:w-[380px] flex-shrink-0">
                        <div class="border border-gray-300 rounded-xl p-6 sticky top-4 bg-white shadow-sm">
                            <h3 class="text-2xl font-bold text-center mb-6 border-b pb-2">Checkout</h3>
                            <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto custom-scrollbar">
                                <template x-if="cart.length === 0"><p class="text-center text-gray-400 py-10">Your cart is empty</p></template>
                                <template x-for="item in cart" :key="item.id">
                                    <div class="flex justify-between items-center">
                                        <span x-text="item.name" class="font-medium text-gray-700 text-sm"></span>
                                        <span x-text="'x' + item.qty" class="text-[#EE6D3C] font-bold text-sm"></span>
                                    </div>
                                </template>
                            </div>
                            <div class="border-t pt-4">
                                <div class="flex justify-between font-bold text-xl mb-6">
                                    <span>Total:</span><span x-text="'$' + subtotal.toFixed(2)"></span>
                                </div>
                                <button @click="showOrderModal = true" :disabled="cart.length === 0"
                                    class="w-full bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-xl hover:bg-orange-600 transition disabled:opacity-50 disabled:cursor-not-allowed">Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== ORDER HISTORY — fully reactive ===== --}}
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Order History</h2>
                    <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full" x-text="orders.length + ' orders'"></span>
                </div>
                <div class="w-full overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr class="border-b text-gray-600 uppercase text-xs">
                                <th class="p-4">ID</th>
                                <th class="p-4">Items</th>
                                <th class="p-4">Total</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Date</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <template x-if="orders.length === 0">
                                <tr><td colspan="6" class="p-10 text-center text-gray-400 italic">No orders found.</td></tr>
                            </template>
                            <template x-for="order in orders" :key="order.id">
                                <tr class="hover:bg-orange-50/50 transition align-top">

                                    <td class="p-4 font-medium text-gray-700 whitespace-nowrap" x-text="'#' + order.id"></td>

                                    <td class="p-4">
                                        <div class="flex flex-col gap-1">
                                            <template x-for="(item, idx) in (order.items || [])" :key="(order.id + '-' + idx)">
                                                <div class="flex items-center gap-2">
                                                    <span class="inline-flex items-center justify-center w-5 h-5 bg-orange-100 text-orange-700 text-xs font-bold rounded-full leading-none" x-text="item.quantity"></span>
                                                    <span class="text-gray-700" x-text="item.name"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </td>

                                    <td class="p-4 whitespace-nowrap">
                                        <span class="text-[#EE6D3C] font-bold text-base" x-text="'$' + parseFloat(order.total_amount).toFixed(2)"></span>
                                    </td>

                                    <td class="p-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold"
                                            :class="{
                                                'bg-yellow-100 text-yellow-700': order.status === 'pending',
                                                'bg-blue-100 text-blue-700':    order.status === 'confirmed',
                                                'bg-purple-100 text-purple-700':order.status === 'processing',
                                                'bg-green-100 text-green-700':  order.status === 'completed',
                                                'bg-red-100 text-red-700':      order.status === 'cancelled',
                                                'bg-gray-100 text-gray-600':    !['pending','confirmed','processing','completed','cancelled'].includes(order.status)
                                            }">
                                            <span class="w-1.5 h-1.5 rounded-full"
                                                :class="{
                                                    'bg-yellow-500': order.status === 'pending',
                                                    'bg-blue-500':   order.status === 'confirmed',
                                                    'bg-purple-500': order.status === 'processing',
                                                    'bg-green-500':  order.status === 'completed',
                                                    'bg-red-500':    order.status === 'cancelled'
                                                }"></span>
                                            <span x-text="order.status.charAt(0).toUpperCase() + order.status.slice(1)"></span>
                                        </span>
                                    </td>

                                    <td class="p-4 whitespace-nowrap">
                                        <span class="block font-medium text-gray-700 text-xs" x-text="order.created_at"></span>
                                        <span class="text-gray-400 text-xs" x-text="order.time"></span>
                                    </td>

                                    <td class="p-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="openStatusModal(order.id, order.status)"
                                                class="p-2 rounded-lg border border-gray-200 hover:border-blue-400 hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition" title="Change Status">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button @click="deleteOrder(order.id)"
                                                class="p-2 rounded-lg border border-gray-200 hover:border-red-400 hover:bg-red-50 text-gray-500 hover:text-red-600 transition" title="Delete Order">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    {{-- Order Confirmation Modal --}}
    <div x-show="showOrderModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 no-print">
        <div class="bg-[#D9D9D9] w-full max-w-2xl rounded-3xl p-6 md:p-10 shadow-2xl relative">
            <button @click="showOrderModal = false" class="absolute top-6 left-6 bg-[#EE6D3C] text-white p-2 rounded-xl hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </button>
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-gray-800">Food Order</h2>
            <div class="bg-white rounded-3xl p-6 shadow-inner">
                <div class="grid grid-cols-3 text-gray-500 font-bold mb-4 px-2">
                    <span>Item</span><span class="text-center">QTY</span><span class="text-right">Price</span>
                </div>
                <div class="space-y-4 mb-8 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
                    <template x-for="item in cart" :key="item.id">
                        <div class="grid grid-cols-3 items-center border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <img :src="item.image" :alt="item.name" class="w-12 h-12 rounded-xl object-cover"/>
                                <span class="font-bold text-gray-800 text-sm" x-text="item.name"></span>
                            </div>
                            <div class="flex justify-center items-center gap-3">
                                <button @click="removeFromCart(item.id)" class="w-6 h-6 bg-gray-100 rounded text-gray-600 hover:bg-gray-200 transition font-bold">-</button>
                                <span class="font-bold" x-text="item.qty"></span>
                                <button @click="addToCart(item.id, item.name, item.price, item.image)" class="w-6 h-6 bg-[#EE6D3C] text-white rounded hover:bg-orange-600 transition font-bold">+</button>
                            </div>
                            <div class="text-right text-[#EE6D3C] font-bold" x-text="'$' + (item.price * item.qty).toFixed(2)"></div>
                        </div>
                    </template>
                </div>
                <div class="bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="flex justify-between text-gray-800 font-black text-xl">
                        <span>Total price($):</span><span x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <button @click="saveOrder()" class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] hover:bg-orange-600 transition">Save Order</button>
                    <button @click="printInvoice()" class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] hover:bg-orange-600 transition">Print Invoice</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Edit Modal --}}
    <div x-show="showStatusModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 no-print">
        <div class="bg-white w-full max-w-sm rounded-2xl p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Update Order Status</h3>
            <p class="text-sm text-gray-500 mb-5">Order <strong x-text="'#' + editOrderId"></strong></p>
            <div class="grid grid-cols-1 gap-2 mb-6">
                <template x-for="s in ['pending','confirmed','processing','completed','cancelled']" :key="s">
                    <button @click="editOrderStatus = s"
                        :class="editOrderStatus === s ? 'border-[#EE6D3C] bg-orange-50 text-[#EE6D3C] font-bold' : 'border-gray-200 text-gray-600 hover:border-gray-300'"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl border text-sm transition">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                            :class="{'bg-yellow-400':s==='pending','bg-blue-400':s==='confirmed','bg-purple-400':s==='processing','bg-green-400':s==='completed','bg-red-400':s==='cancelled'}"></span>
                        <span x-text="s.charAt(0).toUpperCase() + s.slice(1)"></span>
                        <svg x-show="editOrderStatus === s" class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </template>
            </div>
            <div class="flex gap-3">
                <button @click="showStatusModal = false" class="flex-1 px-4 py-3 border border-gray-300 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition text-sm">Cancel</button>
                <button @click="updateStatus()" class="flex-1 px-4 py-3 bg-gray-900 hover:bg-gray-700 text-white font-bold rounded-xl transition text-sm">Update</button>
            </div>
        </div>
    </div>

    {{-- Printable Invoice --}}
    <div id="printable-invoice" class="hidden">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold uppercase underline">Restaurant Receipt</h1>
            <p class="text-sm mt-2">Date: {{ now()->format('d M Y, h:i A') }}</p>
        </div>
        <table class="w-full text-left mb-6 border-collapse">
            <thead><tr class="border-b-2 border-black"><th class="py-2 text-lg">Item</th><th class="py-2 text-center text-lg">Qty</th><th class="py-2 text-right text-lg">Price</th></tr></thead>
            <tbody>
                <template x-for="item in cart" :key="item.id">
                    <tr class="border-b border-gray-200">
                        <td class="py-3 font-bold" x-text="item.name"></td>
                        <td class="py-3 text-center" x-text="item.qty"></td>
                        <td class="py-3 text-right" x-text="'$' + (item.price * item.qty).toFixed(2)"></td>
                    </tr>
                </template>
            </tbody>
        </table>
        <div class="flex justify-end pt-4 border-t-2 border-black">
            <h2 class="text-2xl font-black">TOTAL: $<span x-text="subtotal.toFixed(2)"></span></h2>
        </div>
        <div class="mt-12 text-center text-xs"><p>Thank you for dining with us!</p></div>
    </div>

</div>