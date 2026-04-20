<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>FastBite | Order Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    @include('partials.theme-head')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/userweb.css', 'resources/js/userweb.js'])
    <script>
        window.UserWebConfig = {
            orderStoreUrl: "{{ route('order.store') }}"
        };
    </script>


</head>
<body>

<!-- TOAST -->
<div class="toast" id="toast">✓ <span id="toast-text"></span></div>

<!-- MOBILE NAV -->
<div class="mobile-nav" id="mobileNav">
    <button class="close-nav" id="closeNav">✕</button>
    <a href="#menu" onclick="closeMobileNav()">Menu</a>
    <a class="nav-cta" href="#menu" onclick="closeMobileNav()">🛒 Order Now</a>
</div>

<!-- NAV -->
<nav>
    <div class="nav-inner">
        <a href="#" class="logo"><span>FAST</span>BITE</a>

        <ul class="nav-links">
            <li><a href="#menu">Menu</a></li>
            <li>
                <button onclick="toggleTheme()" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
                    <svg class="sun-icon hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="moon-icon block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
            </li>
            <li>
                <button class="cart-nav-btn" onclick="openCart()">
                    🛒 Cart
                    <span class="cart-nav-count hidden" id="cartNavCount">0</span>
                </button>
            </li>
            <li><a class="nav-cta" href="#menu">Order Now →</a></li>
            <li><a class="nav-cta" href="{{ route('login') }}">Sign In</a></li>
        </ul>

        <div style="display:flex;align-items:center;gap:0.75rem;">
            <button class="cart-nav-btn" onclick="openCart()" style="display:none;" id="mobileCartBtn">
                🛒 <span class="cart-nav-count hidden" id="mobileCartCount">0</span>
            </button>
            <button class="hamburger" id="hamburger">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<!-- MENU -->
<section id="menu" class="menu-section">
    <div class="menu-header">
        <div class="reveal">
            <div class="section-label">Our Menu</div>
            <h2 class="section-title">Popular Dishes</h2>
            <p class="section-sub">{{ $products->count() }} dishes across {{ $categories->count() }} categories</p>
        </div>

        <div class="filter-tabs reveal" id="filterTabsContainer">
            <button class="filter-tab active" onclick="filterMenu(this,'all')">All</button>
            @foreach($categories as $cat)
                <button class="filter-tab" data-cat-id="{{ $cat->id }}" onclick="filterMenu(this,'{{ $cat->id }}')">
                    {{ $cat->name }}
                    <span style="opacity:0.45;font-size:0.7rem;margin-left:2px;">({{ $cat->products_count }})</span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="menu-grid" id="menuGrid">
        @forelse($products as $product)
            @php
                $imagePath = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&q=80';
                if ($product->images) {
                    if (is_array($product->images) && count($product->images) > 0) {
                        $imagePath = asset('storage/' . $product->images[0]);
                    } elseif (is_string($product->images)) {
                        $imagePath = asset('storage/' . $product->images);
                    }
                }
                $isOut = $product->qty <= 0;
                $isLow = $product->qty > 0 && $product->qty <= 2;
            @endphp

            <div class="dish-card reveal"
                 data-category="{{ $product->category_id }}"
                 data-id="{{ $product->id }}"
                 data-name="{{ addslashes($product->name) }}"
                 data-price="{{ $product->price }}"
                 data-image="{{ $imagePath }}"
                 style="transition-delay:{{ ($loop->index % 3) * 0.08 }}s">

                <div class="dish-img-wrap">
                    <img src="{{ $imagePath }}" alt="{{ $product->name }}" loading="lazy">

                    @if($product->category)
                        <div class="dish-badge">{{ $product->category->name }}</div>
                    @endif

                    @if($isOut)
                        <div class="stock-badge">Out of Stock</div>
                    @elseif($isLow)
                        <div class="low-badge">⚠️ Low Stock</div>
                    @endif
                </div>

                <div class="dish-body">
                    <div class="dish-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                    <div class="dish-name">{{ $product->name }}</div>
                    <div class="dish-desc">{{ $product->description ?? 'Fresh and delicious, made with the finest ingredients.' }}</div>

                    <div class="dish-footer">
                        <div>
                            <div class="dish-price">${{ number_format($product->price, 2) }}</div>
                            <div class="dish-qty-label">
                                @if($isOut) Out of stock
                                @elseif($isLow) Only {{ $product->qty }} left
                                @else {{ $product->qty }} available
                                @endif
                            </div>
                        </div>

                        <div id="dish-action-{{ $product->id }}">
                            @if(!$isOut)
                                <button class="add-btn"
                                    onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $imagePath }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            @else
                                <button class="add-btn" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-products">
                <span class="no-products-icon">🍽️</span>
                <p style="font-weight:600;font-size:1.1rem;margin-bottom:.5rem;">No products yet</p>
                <p>Check back soon for our amazing dishes!</p>
            </div>
        @endforelse
    </div>

    <div class="menu-pagination" id="menuPagination"></div>
</section>

<!-- CART DRAWER -->
<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>

<div class="cart-drawer" id="cartDrawer">
    <div class="cart-header">
        <div>
            <div class="cart-title">Order 🛒</div>
            <div class="cart-item-count" id="cartItemCount">0 items</div>
        </div>
        <button class="cart-close" onclick="closeCart()">✕</button>
    </div>

    <div class="cart-items" id="cartItems">
        <div class="cart-empty" id="cartEmpty">
            <span class="cart-empty-icon">🛒</span>
            <p style="font-weight:600;color:var(--mid);">Your cart is empty</p>
            <p style="font-size:0.82rem;">Add some delicious dishes!</p>
        </div>
    </div>

    <div class="cart-footer">
        <div class="cart-subtotal">
            <span class="cart-subtotal-label">Total</span>
            <span class="cart-subtotal-value" id="cartTotal">$0.00</span>
        </div>
        <button class="btn-checkout" id="checkoutBtn" onclick="openCheckout()" disabled>
            Send to Kitchen →
        </button>
    </div>
</div>

<!-- CHECKOUT MODAL -->
<div class="checkout-overlay" id="checkoutOverlay" aria-modal="true" role="dialog">
    <div class="checkout-modal">
        <header class="checkout-modal-header">
            <div>
                <h2 class="checkout-modal-title">Confirm Your Order</h2>
                <p class="checkout-modal-sub">Review items before sending to the kitchen</p>
            </div>
            <button class="checkout-modal-close" onclick="closeCheckout()" aria-label="Close modal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </header>
        <main class="checkout-modal-body">
            <section aria-labelledby="orderSummaryHeading">
                <h3 id="orderSummaryHeading">Order Summary</h3>
                <div id="checkoutSummary">
                    <!-- Dynamic content will go here -->
                </div>
            </section>
            <section aria-labelledby="orderDetailsHeading">
                <h3 id="orderDetailsHeading">Name or Table</h3>
                <form class="checkout-form" id="checkoutForm" onsubmit="event.preventDefault(); placeOrder();">
                    <div class="form-group">
                        <label for="tableNumber">Your Name or Table <span aria-hidden="true">*</span></label>
                        <input type="text" id="tableNumber" name="tableNumber" required list="reservation-list" placeholder="Enter guest name or table..." />
                        <datalist id="reservation-list">
                            @foreach($reservations as $res)
                                <option value="{{ $res['name'] }} (Table {{ $res['table'] }})"></option>
                            @endforeach
                        </datalist>
                    </div>
                </form>
            </section>
        </main>
        <footer class="checkout-modal-footer">
            <button class="btn-place-order" form="checkoutForm" type="submit">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12L10 17L19 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Place Order
            </button>
        </footer>
    </div>
</div>

<!-- SUCCESS MODAL -->
<div class="success-overlay" id="successOverlay">
    <div class="success-modal">
        <span class="success-icon">🎉</span>
        <div class="success-title">Order Sent!</div>
        <p class="success-msg" id="successMsg">Your order has been sent to the kitchen!</p>
        <button class="btn-success-close" onclick="closeSuccess()">Back to Menu</button>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-top">
            <!-- Brand -->
            <div class="footer-brand">
                <a href="#" class="footer-logo"><span>FAST</span>BITE</a>
                <p class="footer-brand-desc">
                    Fresh ingredients, bold flavours, and lightning-fast service. Order directly from your table — no app, no fuss.
                </p>
                    <div class="footer-social">
                        <a class="social-btn" href="https://instagram.com/" title="Instagram">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        
                        <a class="social-btn" href="https://facebook.com/" title="Facebook">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                        
                        <a class="social-btn" href="https://tiktok.com/" title="TikTok">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                        </a>
                        
                        <a class="social-btn" href="https://twitter.com/" title="X (Twitter)">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z"></path><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path></svg>
                        </a>   
                    </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <div class="footer-col-title">Quick Links</div>
                <ul class="footer-links">
                    <li><a href="#menu">🍽️ Our Menu</a></li>
                    <li><a href="#" onclick="openCart()">🛒 My Cart</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="footer-col">
                <div class="footer-col-title">Categories</div>
                <ul class="footer-links">
                    <li><a href="#menu" onclick="filterMenu(document.querySelector('.filter-tab'),'all')">🍴 All Dishes</a></li>
                    @foreach($categories->take(5) as $cat)
                        <li>
                            <a href="#menu" onclick="filterMenuById('{{ $cat->id }}')">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Hours & Newsletter -->
            <div class="footer-newsletter">
                <div class="footer-newsletter-title">Stay Updated</div>
                <p class="footer-newsletter-sub">Get notified about new dishes and daily specials.</p>
                <div class="newsletter-form">
                    <input class="newsletter-input" type="email" placeholder="your@email.com">
                    <button class="newsletter-btn">Subscribe</button>
                </div>

                <div class="footer-hours">
                    <div class="footer-hours-title">⏰ Opening Hours</div>
                    <div class="footer-hours-row">
                        <span>Mon – Fri</span>
                        <span>7:00 AM – 10:00 PM</span>
                    </div>
                    <div class="footer-hours-row">
                        <span>Sat – Sun</span>
                        <span>8:00 AM – 11:00 PM</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copy">
                © {{ date('Y') }} FastBite. Made with ❤️ for great food.
            </p>
            <div class="footer-badges">
                <span class="footer-badge">🔒 Secure Orders</span>
                <span class="footer-badge">🚀 Fast Service</span>
                <span class="footer-badge">🌿 Fresh Ingredients</span>
            </div>
        </div>
    </div>
</footer>


</body>
</html> 