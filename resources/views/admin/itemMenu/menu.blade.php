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
        /* Hide everything by default */
        body * { visibility: hidden; background: none !important; }
        /* Show and style only the invoice */
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

{{-- Initializing Alpine State --}}
<div class="bg-[#FFE4DB] min-h-screen" 
     x-data="{ 
        mobileMenuOpen: false, 
        showOrderModal: false,
        showQR: false,
        cart: [],
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
            if(this.cart.length > 0) {
                window.print();
            } else {
                alert('Cart is empty!');
            }
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
            {{-- Header/Categories --}}
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                <div class="flex items-center mb-6">
                    <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">Menu</h2>
                </div>

                <div class="flex flex-col xl:flex-row gap-8">
                    {{-- Product Grid --}}
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(range(1, 6) as $index)
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group">
                            <div class="p-3">
                                <img src="https://via.placeholder.com/300" class="w-full h-40 md:h-48 object-cover rounded-2xl group-hover:scale-105 transition">
                            </div>
                            <div class="p-5 pt-0">
                                <div class="text-gray-400 font-bold">Food Item {{ $index }}</div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-[#EE6D3C] font-bold text-xl">$9.99</span>
                                    <div class="flex items-center gap-2">
                                        <button @click="removeFromCart({{ $index }})" class="w-8 h-8 rounded-lg bg-gray-100">-</button>
                                        <span class="font-bold w-4 text-center" x-text="cart.find(i => i.id === {{ $index }})?.qty || 0">0</span>
                                        <button @click="addToCart({{ $index }}, 'Food Item {{ $index }}', 9.99, 'https://via.placeholder.com/50')" class="w-8 h-8 rounded-lg bg-[#EE6D3C] text-white">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Right Sidebar Checkout --}}
                    <div class="w-full xl:w-[380px] flex-shrink-0">
                        <div class="border border-gray-300 rounded-xl p-6 sticky top-4 bg-white shadow-sm">
                            <h3 class="text-2xl font-bold text-center mb-6 border-b pb-2">Checkout</h3>
                            <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto custom-scrollbar">
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
                                <button @click="showOrderModal = true" class="w-full bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-xl hover:bg-orange-600 transition">
                                    Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Order Summary Modal --}}
    <div x-show="showOrderModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 no-print">
        <div class="bg-[#D9D9D9] w-full max-w-2xl rounded-3xl p-6 md:p-10 shadow-2xl relative">
            <button @click="showOrderModal = false; showQR = false" class="absolute top-6 left-6 bg-[#EE6D3C] text-white p-2 rounded-xl hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>

            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-gray-800">Order Food</h2>

            <div class="bg-white rounded-3xl p-6 shadow-inner">
                {{-- Header List --}}
                <div class="grid grid-cols-3 text-gray-500 font-bold mb-4 px-2">
                    <span>Item</span><span class="text-center">QTY</span><span class="text-right">Price</span>
                </div>

                {{-- Modal Item Loop --}}
                <div class="space-y-4 mb-8 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
                    <template x-for="item in cart" :key="item.id">
                        <div class="grid grid-cols-3 items-center border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <img :src="item.image" class="w-12 h-12 rounded-xl object-cover">
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
                   <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TotalAmount:' + subtotal" alt="QR Code" class="w-32 h-32">
                   <p class="mt-2 text-sm font-bold text-gray-600">Scan to pay $<span x-text="subtotal.toFixed(2)"></span></p>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-300 space-y-2">
                    <div class="flex justify-between text-gray-700 font-bold">
                        <span>Sub Total:</span><span x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                    <div class="flex justify-between text-gray-800 font-black text-xl pt-2">
                        <span>Total price($):</span><span x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <button class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] transition">Save</button>
                    <button @click="printInvoice()" class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] transition">Print</button>
                </div>
                
                <button @click="showQR = !showQR" 
                        class="w-full bg-[#333333] text-white py-5 rounded-2xl font-bold text-xl mt-4 shadow-lg hover:bg-black transition-all flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    Create QR Code for Price
                </button>
            </div>
        </div>
    </div>

    {{-- INVOICE PRINT AREA (Only visible on Print) --}}
    <div id="printable-invoice" class="hidden">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold uppercase underline">Restaurant Invoice</h1>
            <p class="text-sm">Order Date: {{ now()->format('d M Y, h:i A') }}</p>
        </div>
        
        <table class="w-full text-left mb-6 border-collapse">
            <thead>
                <tr class="border-b-2 border-black">
                    <th class="py-2 text-lg">Item Name</th>
                    <th class="py-2 text-center text-lg">Qty</th>
                    <th class="py-2 text-right text-lg">Total</th>
                </tr>
            </thead>
            <tbody>
                {{-- This loop ensures items show on the printed invoice --}}
                <template x-for="item in cart" :key="item.id">
                    <tr class="border-b border-gray-300">
                        <td class="py-3 text-md font-bold" x-text="item.name"></td>
                        <td class="py-3 text-center" x-text="item.qty"></td>
                        <td class="py-3 text-right font-bold" x-text="'$' + (item.price * item.qty).toFixed(2)"></td>
                    </tr>
                </template>
            </tbody>
        </table>

        <div class="flex justify-end pt-4 border-t-2 border-black">
            <div class="text-right">
                <p class="text-lg">Subtotal: $<span x-text="subtotal.toFixed(2)"></span></p>
                <h2 class="text-2xl font-black mt-2">TOTAL: $<span x-text="subtotal.toFixed(2)"></span></h2>
            </div>
        </div>

        <div class="mt-16 text-center text-sm border-t border-dotted border-black pt-6">
            <p>Thank you for your business!</p>
            <p>Visit us again at www.restaurant.com</p>
        </div>
    </div>
</div>