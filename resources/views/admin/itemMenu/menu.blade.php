@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    [x-cloak] { display: none !important; }

    @media print {
        body * { visibility: hidden; -webkit-print-color-adjust: exact; }
        #printable-invoice, #printable-invoice * { visibility: visible; }
        #printable-invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
            display: block !important;
        }
        .no-print { display: none !important; }
    }
</style>
<title>FastBite | Flavor Unleashed</title>

<div class="bg-[#FFE4DB] min-h-screen" 
    x-data="{
        categories: {{ $categories }},
        products: {{ $products }},
        activeCategory: null,
        cart: [],
        showOrderModal: false,

        currentPage: 1,
        perPage: 6,

        get filteredProducts() {
            if (!this.activeCategory) return this.products;
            return this.products.filter(p => p.category === this.activeCategory);
        },
        get paginatedProducts() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredProducts.slice(start, start + this.perPage);
        },
        get totalPages() {
            return Math.ceil(this.filteredProducts.length / this.perPage);
        },
        get pageNumbers() {
            return Array.from({ length: this.totalPages }, (_, i) => i + 1);
        },
        setCategory(cat) {
            this.activeCategory = cat;
            this.currentPage = 1;
        },

        saveOrder() {
            fetch('/order/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: this.cart,
                    total: this.subtotal
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.message) {
                    alert('Order Successfully!');
                    this.cart = [];
                    this.showOrderModal = false;
                }
            })
            .catch(err => alert('Error!'));
        },
        get subtotal() {
            return this.cart.reduce((sum, item) => sum + item.price * item.qty, 0);
        },
        getProductImage(image) {
            if (image) return '/storage/' + image;
            return '/storage/default.png';   
        },
        addToCart(id, name, price, image) {
            const existing = this.cart.find(i => i.id === id);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ id, name, price, image, qty: 1 });
            }
        },
        removeFromCart(id) {
            const existing = this.cart.find(i => i.id === id);
            if (existing) {
                existing.qty--;
                if (existing.qty === 0) {
                    this.cart = this.cart.filter(i => i.id !== id);
                }
            }
        },
        printInvoice() {
            window.print();
        }
    }">

    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative no-print">

        <aside>
            @include('components.asidebar') 
        </aside>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

            <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Menu Section -->
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                <h2 class="text-2xl md:text-3xl text-gray-800 font-bold mb-6">Menu</h2>

                <!-- Category Filters -->
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
                    <!-- Product Grid -->
                    <div class="flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <template x-if="filteredProducts.length === 0">
                                <div class="col-span-3 text-center text-gray-400 py-20">
                                    <p class="text-xl">No products found.</p>
                                </div>
                            </template>
                            <template x-for="product in paginatedProducts" :key="product.id">
                                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group">
                                    <div class="p-3">
                                        <img :src="getProductImage(product.image)"
                                             class="w-full h-40 md:h-48 object-cover rounded-2xl group-hover:scale-105 transition cursor-pointer" 
                                             :alt="product.name">
                                    </div>
                                    <div class="p-5 pt-0">
                                        <div class="text-gray-700 font-bold text-sm" x-text="product.name"></div>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[#EE6D3C] font-bold text-xl" x-text="'$' + product.price.toFixed(2)"></span>
                                            <div class="flex items-center gap-2">
                                                <button @click="removeFromCart(product.id)" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 transition font-bold text-gray-600">-</button>
                                                <span class="font-bold w-4 text-center" x-text="cart.find(i => i.id === product.id)?.qty || 0">0</span>
                                                <button @click="addToCart(product.id, product.name, product.price, getProductImage(product.image))" class="w-8 h-8 rounded-lg bg-[#EE6D3C] text-white hover:bg-orange-600 transition font-bold">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Pagination -->
                        <div x-show="totalPages > 1" class="flex justify-center items-center gap-2 mt-8 flex-wrap">
                            <button @click="currentPage--" :disabled="currentPage === 1"
                                class="w-9 h-9 rounded-lg bg-white border border-gray-300 hover:bg-orange-50 disabled:opacity-40 disabled:cursor-not-allowed transition font-bold text-gray-600 flex items-center justify-center text-lg">‹</button>
                            <template x-for="page in pageNumbers" :key="page">
                                <button @click="currentPage = page"
                                    :class="currentPage === page ? 'bg-[#EE6D3C] text-white border-[#EE6D3C] shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-orange-50'"
                                    class="w-9 h-9 rounded-lg border font-bold transition text-sm">
                                    <span x-text="page"></span>
                                </button>
                            </template>
                            <button @click="currentPage++" :disabled="currentPage === totalPages"
                                class="w-9 h-9 rounded-lg bg-white border border-gray-300 hover:bg-orange-50 disabled:opacity-40 disabled:cursor-not-allowed transition font-bold text-gray-600 flex items-center justify-center text-lg">›</button>
                        </div>
                    </div>

                    <!-- Checkout Sidebar -->
                    <div class="w-full xl:w-[380px] flex-shrink-0">
                        <div class="border border-gray-300 rounded-xl p-6 sticky top-4 bg-white shadow-sm">
                            <h3 class="text-2xl font-bold text-center mb-6 border-b pb-2">Checkout</h3>
                            <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto custom-scrollbar">
                                <template x-if="cart.length === 0">
                                    <p class="text-center text-gray-400 py-10">Your cart is empty</p>
                                </template>
                                <template x-for="item in cart" :key="item.id">
                                    <div class="flex justify-between items-center">
                                        <span x-text="item.name" class="font-medium text-gray-700"></span>
                                        <span x-text="'x' + item.qty" class="text-[#EE6D3C] font-bold"></span>
                                    </div>
                                </template>
                            </div>
                            <div class="border-t pt-4">
                                <div class="flex justify-between font-bold text-xl mb-6">
                                    <span>Total:</span>
                                    <span x-text="'$' + subtotal.toFixed(2)"></span>
                                </div>
                                <button @click="showOrderModal = true" 
                                        :disabled="cart.length === 0"
                                        class="w-full bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-xl hover:bg-orange-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ORDER HISTORY TABLE -->
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">

                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Order History</h2>
                    <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">
                        {{ $orders->count() }} orders
                    </span>
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
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($orders as $order)
                            <tr class="hover:bg-orange-50/50 transition align-top">

                                <!-- ID -->
                                <td class="p-4 font-medium text-gray-700 whitespace-nowrap">
                                    #{{ $order->id }}
                                </td>

                                <!-- Items -->
                                <td class="p-4">
                                    <div class="flex flex-col gap-1">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-2">
                                                <span class="inline-block w-5 h-5 bg-orange-100 text-orange-700 text-xs font-bold rounded-full text-center leading-5">
                                                    {{ $item->quantity }}
                                                </span>
                                                <span class="text-gray-700">{{ $item->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Total -->
                                <td class="p-4 whitespace-nowrap">
                                    <span class="text-[#EE6D3C] font-bold text-base">
                                        ${{ number_format($order->total_amount, 2) }}
                                    </span>
                                </td>

                                <!-- Status Badge -->
                                <td class="p-4 whitespace-nowrap">
                                    @php
                                        $status = strtolower($order->status ?? 'pending');
                                        $statusMap = [
                                            'pending'    => ['bg-yellow-100', 'text-yellow-700', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            'confirmed'  => ['bg-blue-100',   'text-blue-700',   'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            'completed'  => ['bg-green-100',  'text-green-700',  'M5 13l4 4L19 7'],
                                            'cancelled'  => ['bg-red-100',    'text-red-700',    'M6 18L18 6M6 6l12 12'],
                                            'processing' => ['bg-purple-100', 'text-purple-700', 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                                        ];
                                        [$bg, $text, $icon] = $statusMap[$status] ?? ['bg-gray-100', 'text-gray-600', 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $bg }} {{ $text }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                                        </svg>
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <!-- Date -->
                                <td class="p-4 whitespace-nowrap">
                                    <span class="block font-medium text-gray-700 text-xs">
                                        {{ $order->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-gray-400 text-xs">
                                        {{ $order->created_at->format('h:i A') }}
                                    </span>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-gray-400 italic">
                                    No orders found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Order Modal -->
    <div x-show="showOrderModal" x-cloak x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 no-print">
        <div class="bg-[#D9D9D9] w-full max-w-2xl rounded-3xl p-6 md:p-10 shadow-2xl relative">
            <button @click="showOrderModal = false" class="absolute top-6 left-6 bg-[#EE6D3C] text-white p-2 rounded-xl hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
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
                                <img :src="item.image" :alt="item.name" class="w-12 h-12 rounded-xl object-cover" />
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
                        <span>Total price($):</span>
                        <span x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <button @click="saveOrder()"
                        class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] hover:bg-orange-600 transition">
                        Save Order
                    </button>
                    <button @click="printInvoice()"
                        class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] hover:bg-orange-600 transition">
                        Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Printable Invoice -->
    <div id="printable-invoice" class="hidden">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold uppercase underline">Restaurant Receipt</h1>
            <p class="text-sm mt-2">Date: {{ now()->format('d M Y, h:i A') }}</p>
        </div>
        <table class="w-full text-left mb-6 border-collapse">
            <thead>
                <tr class="border-b-2 border-black">
                    <th class="py-2 text-lg">Item</th>
                    <th class="py-2 text-center text-lg">Qty</th>
                    <th class="py-2 text-right text-lg">Price</th>
                </tr>
            </thead>
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
            <div class="text-right">
                <h2 class="text-2xl font-black">TOTAL: $<span x-text="subtotal.toFixed(2)"></span></h2>
            </div>
        </div>
        <div class="mt-12 text-center text-xs">
            <p>Thank you for dining with us!</p>
        </div>
    </div>

</div>