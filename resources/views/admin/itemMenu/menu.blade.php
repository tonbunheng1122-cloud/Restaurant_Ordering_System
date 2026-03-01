@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    [x-cloak] { display: none !important; }

    /* Print Logic */
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

<div class="bg-[#FFE4DB] min-h-screen" 
     x-data="{ 
        mobileMenuOpen: false, 
        showOrderModal: false,
        showQR: false,
        cart: [],
        activeCategory: 'All',
        categories: [
            {name: 'All', count: '200 Items'},
            {name: 'Burger', count: '10 Items'},
            {name: 'Soups', count: '10 Items'},
            {name: 'Pasta', count: '10 Items'},
            {name: 'Steak', count: '10 Items'},
            {name: 'Pizza', count: '10 Items'},
        ],
        products: [
            {id:1, name:'Classic Burger', price:9.99, category:'Burger', image:'https://via.placeholder.com/300'},
            {id:2, name:'Tomato Soup', price:5.50, category:'Soups', image:'https://via.placeholder.com/300'},
            {id:3, name:'Creamy Pasta', price:12.99, category:'Pasta', image:'https://via.placeholder.com/300'},
            {id:4, name:'Ribeye Steak', price:24.99, category:'Steak', image:'https://via.placeholder.com/300'},
            {id:5, name:'Pepperoni Pizza', price:14.50, category:'Pizza', image:'https://via.placeholder.com/300'},
            {id:6, name:'Cheese Burger', price:10.99, category:'Burger', image:'https://via.placeholder.com/300'},
        ],
        addToCart(id, name, price, image) {
            let item = this.cart.find(i => i.id === id);
            if (item) { item.qty++; } 
            else { this.cart.push({ id, name, price, image, qty: 1 }); }
            this.showQR = false;
        },
        removeFromCart(id) {
            let item = this.cart.find(i => i.id === id);
            if (item && item.qty > 1) { item.qty--; } 
            else { this.cart = this.cart.filter(i => i.id !== id); }
            this.showQR = false;
        },
        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },
        printInvoice() {
            if(this.cart.length > 0) { window.print(); } 
            else { alert('Cart is empty!'); }
        },
        get filteredProducts() {
            if(this.activeCategory === 'All') return this.products;
            return this.products.filter(p => p.category === this.activeCategory);
        }
     }">

    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative no-print">
        <aside>@include('components.asidebar')</aside>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">
            <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                <h2 class="text-2xl md:text-3xl text-gray-800 font-bold mb-6">Menu</h2>

                <div class="flex overflow-x-auto gap-3 pb-4 mb-8 no-scrollbar">
                    <template x-for="cat in categories" :key="cat.name">
                        <button @click="activeCategory = cat.name" 
                                :class="activeCategory === cat.name ? 'bg-[#EE6D3C] text-white' : 'bg-white border border-gray-300 hover:bg-gray-100'" 
                                class="flex-shrink-0 min-w-[120px] p-4 rounded-lg transition text-left">
                            <div class="font-bold text-lg" x-text="cat.name"></div>
                            <div class="text-xs opacity-80" x-text="cat.count"></div>
                        </button>
                    </template>
                </div>

                <div class="flex flex-col xl:flex-row gap-8">
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="product in filteredProducts" :key="product.id">
                            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group">
                                <div class="p-3">
                                    <img :src="product.image" class="w-full h-40 md:h-48 object-cover rounded-2xl group-hover:scale-105 transition">
                                </div>
                                <div class="p-5 pt-0">
                                    <div class="text-gray-400 font-bold" x-text="product.name"></div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-[#EE6D3C] font-bold text-xl" x-text="'$' + product.price.toFixed(2)"></span>
                                        <div class="flex items-center gap-2">
                                            <button @click="removeFromCart(product.id)" class="w-8 h-8 rounded-lg bg-gray-100">-</button>
                                            <span class="font-bold w-4 text-center" x-text="cart.find(i => i.id === product.id)?.qty || 0">0</span>
                                            <button @click="addToCart(product.id, product.name, product.price, product.image)" class="w-8 h-8 rounded-lg bg-[#EE6D3C] text-white">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

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
                                        class="w-full bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-xl hover:bg-orange-600 transition disabled:opacity-50">
                                    Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div x-show="showOrderModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 no-print">
        <div class="bg-[#D9D9D9] w-full max-w-2xl rounded-3xl p-6 md:p-10 shadow-2xl relative">
            <button @click="showOrderModal = false; showQR = false" class="absolute top-6 left-6 bg-[#EE6D3C] text-white p-2 rounded-xl hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>

            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-gray-800">Order Summary</h2>

            <div class="bg-white rounded-3xl p-6 shadow-inner">
                <div class="grid grid-cols-3 text-gray-500 font-bold mb-4 px-2">
                    <span>Item</span><span class="text-center">QTY</span><span class="text-right">Price</span>
                </div>

                <div class="space-y-4 mb-8 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
                    <template x-for="item in cart" :key="item.id">
                        <div class="grid grid-cols-3 items-center border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <img :src="item.image" class="w-12 h-12 rounded-xl object-cover" />
                                <span class="font-bold text-gray-800" x-text="item.name"></span>
                            </div>
                            <div class="flex justify-center items-center gap-3">
                                <button @click="removeFromCart(item.id)" class="w-6 h-6 bg-gray-100 rounded text-gray-600">-</button>
                                <span class="font-bold" x-text="item.qty"></span>
                                <button @click="addToCart(item.id, item.name, item.price, item.image)" class="w-6 h-6 bg-[#EE6D3C] text-white rounded">+</button>
                            </div>
                            <div class="text-right text-[#EE6D3C] font-bold" x-text="'$' + (item.price * item.qty).toFixed(2)"></div>
                        </div>
                    </template>
                </div>

                <div x-show="showQR" x-transition class="flex flex-col items-center mb-4 p-4 bg-gray-50 rounded-2xl border-2 border-[#EE6D3C]">
                    <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TotalAmount:' + subtotal" alt="QR Code" class="w-32 h-32" />
                    <p class="mt-2 text-sm font-bold text-gray-600">Scan to pay $<span x-text="subtotal.toFixed(2)"></span></p>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-300 space-y-2">
                    <div class="flex justify-between text-gray-800 font-black text-xl">
                        <span>Total price($):</span>
                        <span x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <button class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] transition">Save Order</button>
                    <button @click="printInvoice()" class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] transition">Print Invoice</button>
                </div>

                <button @click="showQR = !showQR" class="w-full bg-[#333333] text-white py-4 rounded-2xl font-bold text-lg mt-4 shadow-lg hover:bg-black transition flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    Toggle QR Payment
                </button>
            </div>
        </div>
    </div>

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