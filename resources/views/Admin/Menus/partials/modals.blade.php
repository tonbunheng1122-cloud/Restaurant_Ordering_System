{{-- resources/views/Admin/Menus/partials/modals.blade.php --}}

{{-- ===== ORDER CONFIRMATION MODAL ===== --}}
<div x-show="showOrderModal" x-cloak x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 no-print">
    <div class="bg-[var(--admin-card-bg)] w-full max-w-2xl rounded-3xl p-6 md:p-10 shadow-2xl relative border border-[var(--admin-border)]">
        <button @click="showOrderModal = false"
            class="absolute top-6 left-6 bg-[#EE6D3C] text-white p-2 rounded-xl hover:scale-105 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </button>
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-[var(--admin-text-primary)]">Food Order</h2>
        <div class="bg-[var(--admin-bg-primary)] rounded-3xl p-6 shadow-inner border border-[var(--admin-border)]">
            <div class="grid grid-cols-3 text-[var(--admin-text-secondary)] font-bold mb-4 px-2">
                <span>Item</span><span class="text-center">QTY</span><span class="text-right">Price</span>
            </div>
            <div class="space-y-4 mb-8 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
                <template x-for="item in cart" :key="item.id">
                    <div class="grid grid-cols-3 items-center border-b border-[var(--admin-border)] pb-4">
                        <div class="flex items-center gap-3">
                            <img :src="getProductImage(item.image)" :alt="item.name" class="w-12 h-12 rounded-xl object-cover border border-[var(--admin-border)]"/>
                            <span class="font-bold text-[var(--admin-text-primary)] text-sm" x-text="item.name"></span>
                        </div>
                        <div class="flex justify-center items-center gap-3">
                            <button @click="removeFromCart(item.id)" class="w-6 h-6 bg-[var(--admin-bg-primary)] rounded text-[var(--admin-text-primary)] hover:bg-orange-50/10 transition font-bold">-</button>
                            <span class="font-bold text-[var(--admin-text-primary)]" x-text="item.qty"></span>
                            <button @click="addToCart(item.id, item.name, item.price, item.image)" class="w-6 h-6 bg-[#EE6D3C] text-white rounded hover:bg-orange-600 transition font-bold">+</button>
                        </div>
                        <div class="text-right text-[#EE6D3C] font-bold" x-text="'$' + (item.price * item.qty).toFixed(2)"></div>
                    </div>  
                </template>
            </div>
            <div class="mb-6">
                <label class="block text-[var(--admin-text-secondary)] text-sm font-bold mb-2 uppercase tracking-wide">Name or Table *</label>
                <input type="text" x-model="tableNumber" list="reservation-list" placeholder="Select guest or enter table..."
                    class="w-full px-4 py-3 rounded-xl border border-[var(--admin-border)] focus:border-[#EE6D3C] focus:ring-1 focus:ring-[#EE6D3C] outline-none transition font-bold text-[var(--admin-text-primary)] bg-[var(--admin-card-bg)]">
                <datalist id="reservation-list">
                    <template x-for="res in allReservations" :key="res.name + res.table">
                        <option :value="res.name + ' (Table ' + res.table + ')'"></option>
                    </template>
                </datalist>
            </div>
            <div class="bg-[var(--admin-card-bg)] p-6 rounded-2xl border-2 border-dashed border-[var(--admin-border)]">
                <div class="flex justify-between text-[var(--admin-text-primary)] font-black text-xl">
                    <span>Total price($):</span>
                    <span x-text="'$' + subtotal.toFixed(2)"></span>admin
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <button @click="saveOrder()"
                    class="flex-1 bg-[#EE6D3C] text-white py-4 rounded-2xl font-bold text-lg shadow-md hover:scale-[1.02] hover:bg-orange-600 transition">Save Order</button>
                <button @click="printCurrentCart()"
                    class="flex-1 border-2 border-[#EE6D3C] text-[#EE6D3C] py-4 rounded-2xl font-bold text-lg hover:bg-orange-50/10 transition">Print Invoice</button>
            </div>
        </div>
    </div>
</div>

{{-- ===== STATUS EDIT MODAL ===== --}}
<div x-show="showStatusModal" x-cloak x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 no-print">
    <div class="bg-[var(--admin-card-bg)] w-full max-w-sm rounded-2xl p-8 shadow-2xl border border-[var(--admin-border)]">
        <h3 class="text-xl font-bold text-[var(--admin-text-primary)] mb-2">Update Order Status</h3>
        <p class="text-sm text-[var(--admin-text-secondary)] mb-5">Order <strong x-text="'#' + editOrderId"></strong></p>
        <div class="grid grid-cols-1 gap-2 mb-6">
            <template x-for="s in ['pending','confirmed','processing','completed','cancelled']" :key="s">
                <button @click="editOrderStatus = s"
                    :class="editOrderStatus?.toLowerCase() === s.toLowerCase() ? 'border-[#EE6D3C] bg-[#EE6D3C]/10 text-[#EE6D3C] font-bold' : 'border-[var(--admin-border)] text-[var(--admin-text-secondary)] hover:border-[#EE6D3C]/30'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl border text-sm transition text-left group">
                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                        :class="{'bg-yellow-400':s==='pending','bg-blue-400':s==='confirmed','bg-purple-400':s==='processing','bg-green-400':s==='completed','bg-red-400':s==='cancelled'}"></span>
                    <span x-text="s.charAt(0).toUpperCase() + s.slice(1)"></span>
                    <svg x-show="editOrderStatus?.toLowerCase() === s.toLowerCase()" class="w-4 h-4 ml-auto text-[#EE6D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </template>
        </div>
        <div class="flex gap-3">
            <button @click="showStatusModal = false"
                class="flex-1 px-4 py-3 border border-[var(--admin-border)] text-[var(--admin-text-secondary)] font-bold rounded-xl hover:bg-orange-500/5 transition text-sm">Cancel</button>
            <button @click="updateStatus()"
                class="flex-1 px-4 py-3 bg-[#EE6D3C] hover:bg-orange-600 text-white font-bold rounded-xl transition text-sm shadow-lg shadow-orange-500/20">Update</button>
        </div>
    </div>
</div>

{{-- ===== VIEW ORDER MODAL (Clean Light Theme) ===== --}}
<div x-show="showViewModal" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 no-print">
    
    <div class="bg-[var(--admin-card-bg)] w-full max-w-4xl rounded-lg shadow-lg relative overflow-hidden flex flex-col md:flex-row min-h-[400px] max-h-[90vh]">
        
        <!-- Left Panel: Plain Image -->
        <div class="w-full md:w-1/2 bg-[var(--admin-card-bg)] flex items-center justify-center p-4 relative border-b md:border-b-0 md:border-r border-[var(--admin-border)]">
            <template x-if="viewOrder && viewOrder.items && viewOrder.items[0]">
                <img :src="getProductImage(viewOrder.items[0].image)" class="max-w-full max-h-full object-contain rounded-lg">
            </template>
        </div>

        <!-- Right Panel: Simple Content -->
        <div class="w-full md:w-1/2 flex flex-col pt-8 pb-6 px-8 bg-[var(--admin-card-bg)] text-[var(--admin-text-primary)]">
            
            <!-- Header -->
            <div class="mb-4">
                <h2 class="text-3xl font-bold text-[var(--admin-text-primary)] mb-2 truncate" 
                    x-text="viewOrder ? (isNaN(viewOrder.table_number) && !viewOrder.table_number.toLowerCase().includes('table') ? viewOrder.table_number : (viewOrder.table_number.toLowerCase().includes('table') ? viewOrder.table_number : 'Table ' + viewOrder.table_number)) : 'Guest Order'"></h2>
                <div class="text-sm text-[var(--admin-text-secondary)]">
                    <span x-text="viewOrder ? ('Posted on ' + viewOrder.created_at) : ''"></span>
                    <span class="mx-1">&middot;</span>
                    <span x-text="viewOrder ? viewOrder.time : ''"></span>
                    <span class="ml-2 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide border"
                        :class="{
                            'bg-yellow-500/10 text-yellow-500 border-yellow-500/20': viewOrder && viewOrder.status === 'pending',
                            'bg-blue-500/10 text-blue-500 border-blue-500/20':    viewOrder && viewOrder.status === 'confirmed',
                            'bg-purple-500/10 text-purple-500 border-purple-500/20':viewOrder && viewOrder.status === 'processing',
                            'bg-green-500/10 text-green-500 border-green-500/20':  viewOrder && viewOrder.status === 'completed',
                            'bg-red-500/10 text-red-500 border-red-500/20':      viewOrder && viewOrder.status === 'cancelled'
                        }" x-text="viewOrder ? viewOrder.status : ''"></span>
                </div>
            </div>

            <hr class="border-[var(--admin-border)] mb-6 opacity-50">

            <!-- Body Area -->
            <div class="flex-1 overflow-y-auto mb-6 pr-2 custom-scrollbar">
                <div class="space-y-3">
                    <template x-for="(item, idx) in (viewOrder ? viewOrder.items : [])" :key="idx">
                        <div class="flex justify-between items-center text-sm md:text-base text-[var(--admin-text-primary)] hover:bg-[var(--admin-bg-primary)] p-2 -mx-2 rounded transition">
                            <span class="font-medium truncate pr-4" x-text="item.name"></span>
                            <span class="flex-shrink-0 font-bold bg-[var(--admin-bg-primary)] px-2 py-1 rounded text-[var(--admin-text-primary)] border border-[var(--admin-border)]" x-text="'x' + item.quantity"></span>
                        </div>
                    </template>
                </div>
                
                <div class="mt-8">
                     <p class="text-[var(--admin-text-secondary)] text-xs font-bold uppercase tracking-wider mb-1">Total Amount</p>
                     <p class="text-[var(--admin-text-primary)] text-2xl font-bold font-mono">
                         <span x-text="'$' + parseFloat(viewOrder ? viewOrder.total_amount : 0).toFixed(2)"></span>
                         <span class="text-sm text-[var(--admin-text-secondary)] font-normal ml-2" x-text="'(៛' + toKhr(viewOrder ? viewOrder.total_amount : 0) + ')'"></span>
                     </p>
                </div>
            </div>

            <hr class="border-[var(--admin-border)] mb-4 opacity-50">

            <!-- Footer Buttons -->
            <div class="flex justify-end gap-3 shrink-0">
                <button @click="showViewModal = false; openStatusModal(viewOrder.id, viewOrder.status)"
                    class="px-5 py-2.5 bg-[#EE6D3C] hover:bg-orange-600 text-white text-sm font-bold rounded-lg transition shadow-sm">
                    Update Status
                </button>
                <button @click="showViewModal = false"
                    class="px-5 py-2.5 bg-slate-600 hover:bg-slate-700 text-white text-sm font-bold rounded-lg transition shadow-sm">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


{{-- ===== PRINTABLE INVOICE (Newly Redesigned) ===== --}}
<div id="printable-invoice" style="display:none; width: 100%; max-width: 400px; margin: 0 auto; color: #000; background: #fff;">
    <div style="padding: 15px; border: 1px solid #eee; border-radius: 8px;">
        <!-- Header -->
        <div style="text-align: center; border-bottom: 3px double #000; padding-bottom: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: center; margin-bottom: 8px;">
                <img src="{{ Vite::asset('resources/images/FASTBITE_LOGO.png') }}" style="width: 80px; height: 80px; object-fit: contain;">
            </div>
            <h1 style="font-size: 32px; font-weight: 900; margin: 0; letter-spacing: 4px; color: #000;">FASTBITE</h1>
            <p style="font-size: 14px; font-weight: 700; color: #333; margin: 2px 0; text-transform: uppercase; letter-spacing: 2px;">Official Invoice</p>
            <p style="font-size: 11px; color: #666; margin: 4px 0 0 0;">Premium Fast Food & Dining Experience</p>
        </div>

        <!-- Table Info Banner -->
        <div style="background: #000; color: #fff; padding: 12px; text-align: center; border-radius: 6px; margin-bottom: 20px;">
            <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 4px 0;">Assigned To</p>
            <h2 style="font-size: 18px; font-weight: 900; margin: 0; word-break: break-word;" 
                x-text="invoiceOrder ? (invoiceOrder.table_number.includes('Table') ? invoiceOrder.table_number : 'Table: ' + invoiceOrder.table_number) : 'General Order'"></h2>
        </div>

        <!-- Meta Details -->
        <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
            <div>
                <p style="margin: 0; color: #666;">Invoice ID</p>
                <p style="margin: 2px 0 0 0; font-weight: 900;" x-text="invoiceOrder ? '#' + invoiceOrder.id : ''"></p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0; color: #666;">Date & Time</p>
                <p style="margin: 2px 0 0 0; font-weight: 700;" x-text="invoiceOrder ? (invoiceOrder.created_at + ' ' + invoiceOrder.time) : ''"></p>
            </div>
        </div>

        <!-- Items Table -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="border-bottom: 2px solid #000;">
                    <th style="padding: 8px 4px; text-align: left; font-size: 12px; text-transform: uppercase;">Description</th>
                    <th style="padding: 8px 4px; text-align: right; font-size: 12px; text-transform: uppercase; width: 60px;">Qty</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, idx) in (invoiceOrder ? invoiceOrder.items : [])" :key="idx">
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 10px 4px; font-size: 14px; font-weight: 700;" x-text="item.name"></td>
                        <td style="padding: 10px 4px; text-align: right; font-size: 14px; font-weight: 900;" x-text="item.quantity"></td>
                    </tr>
                </template>
            </tbody>
        </table>

        <!-- Summary -->
        <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 14px; font-weight: 700; color: #444;">TOTAL USD</span>
                <span style="font-size: 22px; font-weight: 950;" x-text="'$' + parseFloat(invoiceOrder ? invoiceOrder.total_amount : 0).toFixed(2)"></span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 8px; border-top: 1px solid #ddd;">
                <span style="font-size: 12px; color: #777;">Payable in KHR</span>
                <span style="font-size: 14px; font-weight: 900;" x-text="'≈ ៛ ' + toKhr(invoiceOrder ? invoiceOrder.total_amount : 0)"></span>
            </div>
        </div>

        <!-- Footer -->
        <div style="margin-top: 25px; text-align: center;">
            <p style="font-size: 14px; font-weight: 900; margin: 0;">THANK YOU!</p>
            <p style="font-size: 11px; color: #888; margin: 4px 0 0 0;">Please visit us again at fastbite.com</p>
            <div style="margin-top: 15px; font-size: 10px; color: #ccc;">
                -----------------------------
            </div>
        </div>
    </div>
</div>
