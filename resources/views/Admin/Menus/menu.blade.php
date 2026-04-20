@include('partials.theme-head')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    [x-cloak] { display: none !important; }
    @media print {
        body * { visibility: hidden; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        #printable-invoice, #printable-invoice * { visibility: visible !important; }
        #printable-invoice { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; display: block !important; }
        #printable-invoice img#print-qr-img { display: inline-block !important; }
        .no-print { display: none !important; }
    }
</style>



<title>FastBite | Menu</title>

<div class="bg-[var(--admin-bg-primary)] min-h-screen text-[var(--admin-text-primary)]"
    x-data="{
        categories: {{ $categories }},
        products: {{ $products }},
        orders: {{ $ordersJson }},

        activeCategory: null,
        cart: [],
        showOrderModal: false,
        showStatusModal: false,
        showInvoiceModal: false,
        showViewModal: false,
        mobileMenuOpen: false,
        editOrderId: null,
        editOrderStatus: 'pending',
        invoiceOrder: null,
        viewOrder: null,
        stockAlerts: [],
        toast: null,
        currentPage: 1,
        perPage: 6,
        tableNumber: '',
        allReservations: {{ $reservations }},

        /* ── Order History Pagination ── */
        orderPage: 1,
        orderPerPage: 5,
        orderSearchQuery: '',

        /* ── Theme state ── */
        // ... (existing state)

        toKhr(usd) {
            return (parseFloat(usd) * 4100).toLocaleString('en-US', { maximumFractionDigits: 0 });
        },

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
        get totalPages()  { return Math.ceil(this.filteredProducts.length / this.perPage); },
        get pageNumbers() { return Array.from({ length: this.totalPages }, (_, i) => i + 1); },
        setCategory(cat) { this.activeCategory = cat; this.currentPage = 1; },

        get filteredOrders() {
            if (!this.orderSearchQuery) return this.orders;
            const q = this.orderSearchQuery.toLowerCase();
            return this.orders.filter(o => 
                (o.id && String(o.id).toLowerCase().includes(q)) || 
                (o.table_number && String(o.table_number).toLowerCase().includes(q))
            );
        },

        get paginatedOrders() {
            const start = (this.orderPage - 1) * this.orderPerPage;
            return this.filteredOrders.slice(start, start + this.orderPerPage);
        },
        get orderTotalPages()  { return Math.ceil(this.filteredOrders.length / this.orderPerPage); },
        get orderPageNumbers() { return Array.from({ length: this.orderTotalPages }, (_, i) => i + 1); },

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
            if (!this.tableNumber) {
                this.showToast('Please enter Name or Table', 'error');
                return;
            }
            fetch('/order/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: this.cart,
                    total: this.subtotal,
                    table_number: this.tableNumber
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.message) {
                    if (data.stock_alerts && data.stock_alerts.length > 0) this.stockAlerts = data.stock_alerts;
                    const now    = new Date();
                    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    const pad    = n => String(n).padStart(2,'0');
                    const h      = now.getHours();
                    const h12    = h > 12 ? h - 12 : (h === 0 ? 12 : h);
                    const ampm   = h >= 12 ? 'PM' : 'AM';
                    this.orders.unshift({
                        id:           data.order_id,
                        table_number: this.tableNumber,
                        status:       'pending',
                        total_amount: this.subtotal,
                        created_at:   pad(now.getDate()) + ' ' + months[now.getMonth()] + ' ' + now.getFullYear(),
                        time:         pad(h12) + ':' + pad(now.getMinutes()) + ' ' + ampm,
                        items:        this.cart.map((i, idx) => ({ uid: idx, name: i.name, quantity: i.qty })),
                    });
                    this.cart           = [];
                    this.tableNumber    = '';
                    this.showOrderModal = false;
                    this.orderPage      = 1;
                    this.showToast('Order #' + data.order_id + ' saved!');
                } else {
                    this.showToast(data.error || 'Order failed', 'error');
                }
            })
            .catch(() => this.showToast('Network error. Please try again.', 'error'));
        },

        openStatusModal(orderId, currentStatus) {
            this.editOrderId     = orderId;
            this.editOrderStatus = (currentStatus || 'pending').toLowerCase();
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
                    if (this.orderPage > this.orderTotalPages) this.orderPage = Math.max(1, this.orderTotalPages);
                    this.showToast('Order #' + id + ' deleted.');
                } else {
                    this.showToast('Delete failed', 'error');
                }
            })
            .catch(() => this.showToast('Network error', 'error'));
        },

        openInvoiceAndPrint(order) {
            this.invoiceOrder = order;
            this.$nextTick(() => {
                window.print();
            });
        },

        openViewModal(order) {
            this.viewOrder      = order;
            this.showViewModal  = true;
        },

        printCurrentCart() {
            if (!this.tableNumber) {
                this.showToast('Please enter Name or Table first', 'error');
                return;
            }
            // Create a mock order object for the printable invoice
            const now    = new Date();
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const pad    = n => String(n).padStart(2,'0');
            const h      = now.getHours();
            const h12    = h > 12 ? h - 12 : (h === 0 ? 12 : h);
            const ampm   = h >= 12 ? 'PM' : 'AM';

            this.invoiceOrder = {
                id:           'DRAFT',
                table_number: this.tableNumber,
                status:       'pending',
                total_amount: this.subtotal,
                created_at:   pad(now.getDate()) + ' ' + months[now.getMonth()] + ' ' + now.getFullYear(),
                time:         pad(h12) + ':' + pad(now.getMinutes()) + ' ' + ampm,
                items:        this.cart.map((i, idx) => ({ uid: idx, name: i.name, quantity: i.qty })),
            };

            this.$nextTick(() => {
                window.print();
            });
        },

        init() {
            this.$watch('orderSearchQuery', () => {
                this.orderPage = 1;
            });
        }


    }">

    <!-- ===== ALERTS & TOASTS ===== -->
    @include('Admin.Menus.partials.alerts')

    <!-- ===== MAIN LAYOUT =====  -->
    <div class="flex flex-col md:flex-row md:h-screen md:p-4 md:gap-6 md:overflow-hidden relative no-print">

        @include('components.asidebar')

        <main class="flex-1 overflow-y-auto px-3 pb-4 md:px-0 md:pr-2 custom-scrollbar">
            <!-- ===== MENU BOARD =====  -->
            @include('Admin.Menus.partials.menu-board')

            <!-- ===== ORDER HISTORY =====  -->
            @include('Admin.Menus.partials.order-history')
        </main>
    </div>

    <!-- ===== MODALS & PRINT LAYOUT =====  -->
    @include('Admin.Menus.partials.modals')

</div>