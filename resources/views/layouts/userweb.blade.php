<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FastBite | Table {{ $tableNumber ?? '—' }} Order</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
<style>
:root {
    --orange: #F4521E;
    --orange-light: #FF7A47;
    --cream: #FFF5EE;
    --dark: #1A0F0A;
    --mid: #3D2B1F;
    --muted: #9B8880;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { background-color: var(--cream); color: var(--dark); font-family: 'DM Sans', sans-serif; overflow-x: hidden; }
::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--cream); }
::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }

/* ─── NAV ─── */
nav { position: sticky; top: 0; z-index: 100; background: rgba(255,245,238,0.95); backdrop-filter: blur(24px); border-bottom: 1px solid rgba(244,82,30,0.12); padding: 0 4%; }
.nav-inner { max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { font-family: 'Bebas Neue', sans-serif; font-size: 1.7rem; letter-spacing: 2px; text-decoration: none; color: var(--dark); white-space: nowrap; }
.logo span { color: var(--orange); }
.nav-links { display: flex; align-items: center; gap: 2rem; list-style: none; }
.nav-links a { text-decoration: none; color: var(--mid); font-weight: 600; font-size: 0.8rem; letter-spacing: 0.12em; text-transform: uppercase; transition: color 0.2s; }
.nav-links a:hover { color: var(--orange); }

.nav-table-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(244,82,30,0.1); border: 1px solid rgba(244,82,30,0.25); color: var(--orange); padding: 0.4rem 0.9rem; border-radius: 50px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; }
.nav-table-badge-dot { width: 7px; height: 7px; background: var(--orange); border-radius: 50%; animation: pulse 1.5s infinite; }
.nav-table-badge-num { font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 1px; line-height: 1; }

.cart-nav-btn { position: relative; background: var(--dark); color: #fff; border: none; border-radius: 12px; padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; letter-spacing: 0.06em; transition: background 0.2s, transform 0.15s; }
.cart-nav-btn:hover { background: var(--mid); transform: translateY(-2px); }
.cart-nav-count { position: absolute; top: -6px; right: -6px; background: var(--orange); color: #fff; width: 18px; height: 18px; border-radius: 50%; font-size: 0.65rem; font-weight: 800; display: flex; align-items: center; justify-content: center; }
.cart-nav-count.hidden { display: none; }

.hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 6px; border: none; background: transparent; }
.hamburger span { display: block; width: 22px; height: 2px; background: var(--dark); border-radius: 2px; transition: all 0.3s; }
.hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

.mobile-nav { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: var(--cream); z-index: 200; flex-direction: column; align-items: center; justify-content: center; gap: 2rem; }
.mobile-nav.open { display: flex; }
.mobile-nav a { font-family: 'Bebas Neue', sans-serif; font-size: 2.2rem; letter-spacing: 2px; text-decoration: none; color: var(--dark); transition: color 0.2s; }
.mobile-nav a:hover { color: var(--orange); }
.mobile-nav .close-nav { position: absolute; top: 20px; right: 20px; font-size: 1.6rem; cursor: pointer; background: none; border: none; color: var(--dark); }


/* ─── SECTION ─── */
.section-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: var(--orange); margin-bottom: 0.6rem; }
.section-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.2rem, 8vw, 4.5rem); line-height: 1; margin-bottom: 0.4rem; }
.section-sub { color: var(--muted); font-size: 0.95rem; }

/* ─── MENU ─── */
.menu-section { max-width: 1400px; margin: 0 auto; padding: 4rem 4%; }
.menu-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1.2rem; }
.filter-tabs { display: flex; background: rgba(0,0,0,0.05); padding: 4px; border-radius: 12px; gap: 3px; overflow-x: auto; scrollbar-width: none; }
.filter-tabs::-webkit-scrollbar { display: none; }
.filter-tab { padding: 0.5rem 1rem; border-radius: 9px; font-size: 0.78rem; font-weight: 700; cursor: pointer; border: none; background: transparent; color: var(--mid); transition: all 0.2s; white-space: nowrap; flex-shrink: 0; }
.filter-tab.active { background: #fff; color: var(--dark); box-shadow: 0 2px 12px rgba(0,0,0,0.1); }
.filter-tab:hover:not(.active) { color: var(--orange); }

.menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.dish-card { background: #fff; border-radius: 24px; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); transition: transform 0.3s, box-shadow 0.3s; }
.dish-card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(244,82,30,0.12); }
.dish-img-wrap { position: relative; overflow: hidden; }
.dish-img-wrap img { width: 100%; height: 220px; object-fit: cover; display: block; transition: transform 0.5s; }
.dish-card:hover .dish-img-wrap img { transform: scale(1.07); }
.dish-badge { position: absolute; top: 10px; left: 10px; background: var(--dark); color: #fff; font-size: 0.65rem; font-weight: 700; padding: 0.28rem 0.7rem; border-radius: 50px; letter-spacing: 0.08em; text-transform: uppercase; }
.stock-badge { position: absolute; top: 10px; right: 10px; background: #ef4444; color: #fff; font-size: 0.65rem; font-weight: 700; padding: 0.28rem 0.7rem; border-radius: 50px; }
.low-badge { position: absolute; top: 10px; right: 10px; background: #f59e0b; color: #fff; font-size: 0.65rem; font-weight: 700; padding: 0.28rem 0.7rem; border-radius: 50px; }
.dish-body { padding: 1.3rem; }
.dish-category { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--orange); margin-bottom: 0.35rem; }
.dish-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.5px; margin-bottom: 0.35rem; }
.dish-desc { font-size: 0.8rem; color: var(--muted); line-height: 1.5; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.dish-footer { display: flex; align-items: center; justify-content: space-between; }
.dish-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--dark); }
.dish-qty-label { font-size: 0.7rem; color: var(--muted); font-weight: 600; }
.add-btn { width: 42px; height: 42px; border-radius: 12px; background: var(--orange); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s, transform 0.15s; box-shadow: 0 6px 18px rgba(244,82,30,0.4); color: #fff; flex-shrink: 0; }
.add-btn:hover { background: var(--orange-light); transform: scale(1.1); }
.add-btn svg { width: 18px; height: 18px; }
.add-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }
.dish-qty-controls { display: flex; align-items: center; gap: 0.5rem; }
.qty-btn { width: 32px; height: 32px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.12); background: var(--cream); cursor: pointer; font-size: 1.1rem; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.qty-btn:hover { background: rgba(244,82,30,0.1); border-color: var(--orange); color: var(--orange); }
.qty-display { font-size: 0.9rem; font-weight: 700; min-width: 20px; text-align: center; }
.no-products { grid-column: 1/-1; text-align: center; padding: 5rem 2rem; color: var(--muted); }
.no-products-icon { font-size: 3rem; margin-bottom: 1rem; display: block; }

/* ─── CART DRAWER ─── */
.cart-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 300; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.cart-overlay.open { opacity: 1; pointer-events: auto; }
.cart-drawer { position: fixed; top: 0; right: -420px; width: 420px; max-width: 100vw; height: 100vh; background: var(--cream); z-index: 301; display: flex; flex-direction: column; transition: right 0.35s cubic-bezier(0.4,0,0.2,1); box-shadow: -20px 0 60px rgba(0,0,0,0.15); }
.cart-drawer.open { right: 0; }
.cart-header { padding: 1.5rem 1.5rem 1.2rem; border-bottom: 1px solid rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: space-between; background: #fff; }
.cart-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.6rem; letter-spacing: 1px; }
.cart-close { width: 36px; height: 36px; border-radius: 10px; background: var(--cream); border: 1px solid rgba(0,0,0,0.1); cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
.cart-close:hover { background: rgba(244,82,30,0.1); }
.cart-items { flex: 1; overflow-y: auto; padding: 1.2rem 1.5rem; }
.cart-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; gap: 1rem; color: var(--muted); }
.cart-empty-icon { font-size: 3rem; }
.cart-item { display: flex; gap: 1rem; align-items: center; padding: 1rem 0; border-bottom: 1px solid rgba(0,0,0,0.06); }
.cart-item:last-child { border-bottom: none; }
.cart-item-img { width: 60px; height: 60px; border-radius: 12px; object-fit: cover; flex-shrink: 0; }
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-name { font-weight: 700; font-size: 0.9rem; color: var(--dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cart-item-price { font-size: 0.82rem; color: var(--orange); font-weight: 700; margin-top: 2px; }
.cart-item-controls { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
.cart-qty-btn { width: 28px; height: 28px; border-radius: 7px; border: 1px solid rgba(0,0,0,0.12); background: var(--cream); cursor: pointer; font-size: 1rem; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.cart-qty-btn:hover { background: rgba(244,82,30,0.1); border-color: var(--orange); color: var(--orange); }
.cart-item-qty { font-size: 0.9rem; font-weight: 700; min-width: 20px; text-align: center; }
.cart-item-remove { width: 28px; height: 28px; border-radius: 7px; border: none; background: transparent; cursor: pointer; color: #ef4444; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
.cart-item-remove:hover { background: rgba(239,68,68,0.1); }
.cart-footer { padding: 1.2rem 1.5rem; background: #fff; border-top: 1px solid rgba(0,0,0,0.08); }
.cart-subtotal { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.cart-subtotal-label { font-size: 0.82rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; }
.cart-subtotal-value { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--dark); }
.btn-checkout { width: 100%; background: var(--orange); color: #fff; border: none; border-radius: 14px; padding: 1rem; font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: 1px; cursor: pointer; transition: background 0.2s, transform 0.15s; box-shadow: 0 6px 20px rgba(244,82,30,0.4); }
.btn-checkout:hover { background: var(--orange-light); transform: translateY(-2px); }
.btn-checkout:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }
.cart-item-count { font-size: 0.75rem; color: var(--muted); margin-top: 0.2rem; }

/* ─── CHECKOUT MODAL ─── */
.checkout-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 400; display: flex; align-items: center; justify-content: center; padding: 1rem; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.checkout-overlay.open { opacity: 1; pointer-events: auto; }
.checkout-modal { background: #fff; border-radius: 28px; width: 100%; max-width: 560px; max-height: 90vh; overflow-y: auto; box-shadow: 0 30px 80px rgba(0,0,0,0.2); transform: scale(0.95) translateY(20px); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
.checkout-overlay.open .checkout-modal { transform: scale(1) translateY(0); }
.checkout-modal-header { background: var(--dark); padding: 2rem 2rem 1.5rem; border-radius: 28px 28px 0 0; position: relative; }
.checkout-modal-title { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; letter-spacing: 1px; color: #fff; }
.checkout-modal-sub { font-size: 0.82rem; color: rgba(255,255,255,0.5); margin-top: 0.3rem; }
.checkout-modal-close { position: absolute; top: 1.5rem; right: 1.5rem; width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.1); border: none; cursor: pointer; color: #fff; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
.checkout-modal-close:hover { background: rgba(255,255,255,0.2); }
.checkout-modal-body { padding: 2rem; }
.checkout-section-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 0.5px; color: var(--dark); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
.checkout-section-title::after { content: ''; flex: 1; height: 1px; background: rgba(0,0,0,0.08); margin-left: 0.5rem; }
.form-group { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1rem; }
.form-group label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--mid); }
.form-group input,
.form-group textarea { width: 100%; padding: 0.85rem 1rem; border: 1.5px solid rgba(0,0,0,0.1); border-radius: 12px; font-family: 'DM Sans', sans-serif; font-size: 0.9rem; color: var(--dark); background: var(--cream); transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
.form-group input:focus,
.form-group textarea:focus { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(244,82,30,0.1); }
.form-group textarea { resize: none; height: 90px; }
.checkout-order-summary { background: var(--cream); border-radius: 16px; padding: 1.2rem; margin-bottom: 1.5rem; }
.checkout-order-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; padding: 0.4rem 0; border-bottom: 1px solid rgba(0,0,0,0.06); }
.checkout-order-row:last-child { border-bottom: none; padding-top: 0.8rem; margin-top: 0.4rem; }
.checkout-order-name { color: var(--mid); font-weight: 500; }
.checkout-order-qty { background: rgba(244,82,30,0.1); color: var(--orange); font-weight: 700; font-size: 0.72rem; padding: 0.15rem 0.5rem; border-radius: 50px; margin-left: 0.4rem; }
.checkout-order-price { font-weight: 700; color: var(--dark); }
.checkout-total-row { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; }
.checkout-total-row .checkout-order-name { color: var(--dark); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.5px; }
.checkout-total-row .checkout-order-price { color: var(--orange); font-size: 1.5rem; }
.btn-place-order { width: 100%; background: var(--orange); color: #fff; border: none; border-radius: 14px; padding: 1.1rem; font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; letter-spacing: 1px; cursor: pointer; transition: background 0.2s, transform 0.15s; box-shadow: 0 6px 24px rgba(244,82,30,0.4); display: flex; align-items: center; justify-content: center; gap: 0.6rem; }
.btn-place-order:hover { background: var(--orange-light); transform: translateY(-2px); }
.required-star { color: var(--orange); }

/* ─── SUCCESS MODAL ─── */
.success-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 500; display: flex; align-items: center; justify-content: center; padding: 1rem; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.success-overlay.open { opacity: 1; pointer-events: auto; }
.success-modal { background: #fff; border-radius: 28px; width: 100%; max-width: 400px; padding: 3rem 2rem; text-align: center; box-shadow: 0 30px 80px rgba(0,0,0,0.2); transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1); }
.success-overlay.open .success-modal { transform: scale(1); }
.success-icon { font-size: 4rem; margin-bottom: 1rem; display: block; animation: bounceIn 0.5s 0.1s ease both; }
.success-title { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; letter-spacing: 1px; margin-bottom: 0.5rem; }
.success-msg { font-size: 0.9rem; color: var(--muted); line-height: 1.6; margin-bottom: 2rem; }
.btn-success-close { background: var(--dark); color: #fff; border: none; border-radius: 14px; padding: 0.9rem 2rem; font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 1px; cursor: pointer; transition: background 0.2s; }
.btn-success-close:hover { background: var(--mid); }

/* ─── TOAST ─── */
.toast { position: fixed; top: 80px; right: 20px; z-index: 9998; background: #22c55e; color: #fff; padding: 0.9rem 1.4rem; border-radius: 14px; font-weight: 600; font-size: 0.88rem; box-shadow: 0 10px 40px rgba(34,197,94,0.4); display: flex; align-items: center; gap: 0.6rem; transform: translateX(200px); opacity: 0; transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s; pointer-events: none; }
.toast.show { transform: translateX(0); opacity: 1; }

/* ─── MENU PAGINATION ─── */
.menu-pagination { display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 2.5rem; flex-wrap: wrap; }
.page-btn { width: 40px; height: 40px; border-radius: 10px; border: 1.5px solid rgba(0,0,0,0.1); background: #fff; cursor: pointer; font-size: 0.85rem; font-weight: 700; color: var(--mid); transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
.page-btn:hover { border-color: var(--orange); color: var(--orange); }
.page-btn.active { background: var(--orange); border-color: var(--orange); color: #fff; box-shadow: 0 4px 14px rgba(244,82,30,0.4); }
.page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
.page-info { font-size: 0.78rem; color: var(--muted); font-weight: 600; padding: 0 0.5rem; }

/* ─── ANIMATIONS ─── */
@keyframes fadeUp   { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn   { from { opacity: 0; } to { opacity: 1; } }
@keyframes pulse    { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.1); } }
@keyframes ticker   { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
@keyframes bounceIn { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
.reveal { opacity: 0; transform: translateY(36px); transition: opacity 0.65s ease, transform 0.65s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }

/* ─── RESPONSIVE ─── */
@media (max-width: 1024px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .menu-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .nav-links { display: none; }
    .hamburger { display: flex; }
    .table-banner { padding: 2rem 4% 2rem; }
    .table-banner-chips { display: none; }
    .stats-row { grid-template-columns: 1fr 1fr; padding: 2rem 4%; }
    .menu-grid { grid-template-columns: 1fr; }
    .menu-header { flex-direction: column; align-items: flex-start; }
    .cart-drawer { width: 100%; right: -100%; }
    .toast { left: 12px; right: 12px; top: 70px; }
}
@media (max-width: 420px) {
    .stats-row { grid-template-columns: 1fr 1fr; gap: 0.7rem; }
}
</style>
</head>
<body>

<!-- TOAST -->
<div class="toast" id="toast">✓ <span id="toast-text"></span></div>

<!-- MOBILE NAV -->
<div class="mobile-nav" id="mobileNav">
    <button class="close-nav" id="closeNav">✕</button>
    <a href="/" onclick="closeMobileNav()">Home</a>
    <a href="#menu" onclick="closeMobileNav()">Menu</a>
</div>

<!-- NAV -->
<nav>
    <div class="nav-inner">
        <a href="/" class="logo"><span>FAST</span>BITE</a>
        <ul class="nav-links">
            <li><a href="/">Home</a></li>
            <li><a href="#menu">Menu</a></li>
            <li>
                <button class="cart-nav-btn" onclick="openCart()">
                    🛒 Cart
                    <span class="cart-nav-count hidden" id="cartNavCount">0</span>
                </button>
            </li>
            <li>
                <div class="nav-table-badge">
                    <span class="nav-table-badge-dot"></span>
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                </div>
            </li>
        </ul>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <button class="cart-nav-btn" onclick="openCart()" style="display:none;" id="mobileCartBtn">
                🛒 <span class="cart-nav-count hidden" id="mobileCartCount">0</span>
            </button>
            <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
        </div>
    </div>
</nav>

<!-- ═══════════ CART DRAWER ═══════════ -->
<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
<div class="cart-drawer" id="cartDrawer">
    <div class="cart-header">
        <div>
            <div class="cart-title">Your Order 🛒</div>
            <div class="cart-item-count" id="cartItemCount">0 items · Table {{ $tableNumber ?? '?' }}</div>
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

<!-- ═══════════ CHECKOUT MODAL ═══════════ -->
<div class="checkout-overlay" id="checkoutOverlay">
    <div class="checkout-modal">
        <div class="checkout-modal-header">
            <div class="checkout-modal-title">Confirm Order</div>
            <div class="checkout-modal-sub">Table {{ $tableNumber ?? '?' }} · Review your items before sending to the kitchen</div>
            <button class="checkout-modal-close" onclick="closeCheckout()">✕</button>
        </div>
        <div class="checkout-modal-body">

            <div class="checkout-section-title">Order Summary</div>
            <div class="checkout-order-summary" id="checkoutSummary"></div>

            <div class="checkout-section-title">Your Details</div>

            <div class="form-group">
                <label>Your Name <span class="required-star">*</span></label>
                <input type="text" id="ckName" placeholder="e.g. John Doe" required>
            </div>

            <div class="form-group">
                <label>Special Notes (optional)</label>
                <textarea id="ckNotes" placeholder="Allergies, spice level, no onions…"></textarea>
            </div>

            <button class="btn-place-order" onclick="placeOrder()">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Send to Kitchen
            </button>
        </div>
    </div>
</div>

<!-- ═══════════ SUCCESS MODAL ═══════════ -->
<div class="success-overlay" id="successOverlay">
    <div class="success-modal">
        <span class="success-icon">🎉</span>
        <div class="success-title">Order Sent!</div>
        <p class="success-msg" id="successMsg">Your order has been sent to the kitchen. Sit back and enjoy!</p>
        <button class="btn-success-close" onclick="closeSuccess()">Back to Menu</button>
    </div>
</div>

<!-- ═══════════ MENU ═══════════ -->
<section id="menu" class="menu-section">
    <div class="menu-header">
        <div class="reveal">
            <div class="section-label">Our Menu</div>
            <h2 class="section-title">Popular Dishes</h2>
            <p class="section-sub">{{ $products->count() }} dishes across {{ $categories->count() }} categories</p>
        </div>

        <div class="filter-tabs reveal">
            <button class="filter-tab active" onclick="filterMenu(this,'all')">All</button>
            @foreach($categories as $cat)
                <button class="filter-tab" onclick="filterMenu(this,'{{ $cat->id }}')">
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
                        @if(!$isOut)
                        <div id="dish-action-{{ $product->id }}">
                            <button class="add-btn"
                                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $imagePath }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                        @else
                        <div id="dish-action-{{ $product->id }}">
                            <button class="add-btn" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            </button>
                        </div>
                        @endif
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

<script>
/* ══════════════════════════════════════
   CART STATE
══════════════════════════════════════ */
let cart = [];

function addToCart(id, name, price, image) {
    const existing = cart.find(i => i.id === id);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id, name, price: parseFloat(price), image, qty: 1 });
    }
    updateCartUI();
    updateDishAction(id);
    showToast(`${name} added to cart! 🛒`);
}

function removeFromCart(id) {
    cart = cart.filter(i => i.id !== id);
    updateCartUI();
    updateDishAction(id);
}

function changeQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
    updateCartUI();
    updateDishAction(id);
}

function updateDishAction(id) {
    const item = cart.find(i => i.id === id);
    const el   = document.getElementById('dish-action-' + id);
    if (!el) return;
    const card  = el.closest('.dish-card');
    const name  = card ? card.dataset.name  : '';
    const price = card ? card.dataset.price : 0;
    const image = card ? card.dataset.image : '';
    if (!item || item.qty === 0) {
        el.innerHTML = `
            <button class="add-btn" onclick="addToCart(${id}, '${name}', ${price}, '${image}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </button>`;
    } else {
        el.innerHTML = `
            <div class="dish-qty-controls">
                <button class="qty-btn" onclick="changeQty(${id}, -1)">−</button>
                <span class="qty-display">${item.qty}</span>
                <button class="qty-btn" onclick="changeQty(${id}, 1)">+</button>
            </div>`;
    }
}

/* ══════════════════════════════════════
   CART UI
══════════════════════════════════════ */
function updateCartUI() {
    const total    = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const totalQty = cart.reduce((s, i) => s + i.qty, 0);
    const isEmpty  = cart.length === 0;

    document.getElementById('cartNavCount').textContent    = totalQty;
    document.getElementById('mobileCartCount').textContent = totalQty;
    document.getElementById('cartNavCount').classList.toggle('hidden', isEmpty);
    document.getElementById('mobileCartCount').classList.toggle('hidden', isEmpty);

    document.getElementById('cartItemCount').textContent =
        (totalQty === 0 ? '0 items' : `${totalQty} item${totalQty > 1 ? 's' : ''}`) + ' · Table {{ $tableNumber ?? "?" }}';

    document.getElementById('cartTotal').textContent = '$' + total.toFixed(2);
    document.getElementById('checkoutBtn').disabled  = isEmpty;

    const itemsEl = document.getElementById('cartItems');
    const emptyEl = document.getElementById('cartEmpty');
    emptyEl.style.display = isEmpty ? 'flex' : 'none';
    itemsEl.querySelectorAll('.cart-item').forEach(e => e.remove());

    cart.forEach(item => {
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="cart-item-img">
            <div class="cart-item-info">
                <div class="cart-item-name">${item.name}</div>
                <div class="cart-item-price">$${(item.price * item.qty).toFixed(2)}</div>
            </div>
            <div class="cart-item-controls">
                <button class="cart-qty-btn" onclick="changeQty(${item.id}, -1)">−</button>
                <span class="cart-item-qty">${item.qty}</span>
                <button class="cart-qty-btn" onclick="changeQty(${item.id}, 1)">+</button>
                <button class="cart-item-remove" onclick="removeFromCart(${item.id})">🗑</button>
            </div>`;
        itemsEl.appendChild(div);
    });
}

/* ══════════════════════════════════════
   CART DRAWER
══════════════════════════════════════ */
function openCart() {
    document.getElementById('cartDrawer').classList.add('open');
    document.getElementById('cartOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeCart() {
    document.getElementById('cartDrawer').classList.remove('open');
    document.getElementById('cartOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ══════════════════════════════════════
   CHECKOUT MODAL
══════════════════════════════════════ */
function openCheckout() {
    if (cart.length === 0) return;
    closeCart();
    const summary = document.getElementById('checkoutSummary');
    const total   = cart.reduce((s, i) => s + i.price * i.qty, 0);
    let html = '';
    cart.forEach(item => {
        html += `
        <div class="checkout-order-row">
            <span class="checkout-order-name">
                ${item.name}
                <span class="checkout-order-qty">×${item.qty}</span>
            </span>
            <span class="checkout-order-price">$${(item.price * item.qty).toFixed(2)}</span>
        </div>`;
    });
    html += `
    <div class="checkout-order-row checkout-total-row">
        <span class="checkout-order-name">Total</span>
        <span class="checkout-order-price">$${total.toFixed(2)}</span>
    </div>`;
    summary.innerHTML = html;
    document.getElementById('checkoutOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeCheckout() {
    document.getElementById('checkoutOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ══════════════════════════════════════
   PLACE ORDER
══════════════════════════════════════ */
function placeOrder() {
    const name = document.getElementById('ckName').value.trim();
    if (!name) {
        const el = document.getElementById('ckName');
        el.style.borderColor = '#ef4444';
        el.style.boxShadow   = '0 0 0 3px rgba(239,68,68,0.15)';
        el.focus();
        showToast('⚠️ Please enter your name', true);
        el.addEventListener('input', () => { el.style.borderColor = ''; el.style.boxShadow = ''; }, { once: true });
        return;
    }
    const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
    document.getElementById('successMsg').textContent =
        `Thank you, ${name}! Your order of $${total.toFixed(2)} has been sent to the kitchen. We'll bring it to Table {{ $tableNumber ?? '?' }} shortly.`;

    closeCheckout();
    const prevCart = [...cart];
    cart = [];
    updateCartUI();
    prevCart.forEach(i => updateDishAction(i.id));
    document.getElementById('ckName').value  = '';
    document.getElementById('ckNotes').value = '';

    setTimeout(() => {
        document.getElementById('successOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }, 200);
}

function closeSuccess() {
    document.getElementById('successOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ══════════════════════════════════════
   TOAST
══════════════════════════════════════ */
function showToast(msg, isError = false) {
    const toast = document.getElementById('toast');
    document.getElementById('toast-text').textContent = msg;
    toast.style.background = isError ? '#ef4444' : '#22c55e';
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 3000);
}

/* ══════════════════════════════════════
   HAMBURGER
══════════════════════════════════════ */
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav  = document.getElementById('closeNav');
function openMobileNav()  { mobileNav.classList.add('open'); hamburger.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeMobileNav() { mobileNav.classList.remove('open'); hamburger.classList.remove('open'); document.body.style.overflow = ''; }
hamburger.addEventListener('click', openMobileNav);
closeNav.addEventListener('click',  closeMobileNav);

function checkMobileCart() {
    document.getElementById('mobileCartBtn').style.display = window.innerWidth <= 768 ? 'flex' : 'none';
}
checkMobileCart();
window.addEventListener('resize', checkMobileCart);

/* ══════════════════════════════════════
   SCROLL REVEAL
══════════════════════════════════════ */
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeCart(); closeCheckout(); closeSuccess(); }
});

/* ══════════════════════════════════════
   MENU PAGINATION + FILTER
══════════════════════════════════════ */
const PER_PAGE  = 6;
let currentPage = 1;
let activeCatId = 'all';

function getFilteredCards() {
    return [...document.querySelectorAll('#menuGrid .dish-card')].filter(card => {
        return activeCatId === 'all' || card.dataset.category == activeCatId;
    });
}

function renderPage() {
    const cards = getFilteredCards();
    const total = cards.length;
    const pages = Math.ceil(total / PER_PAGE);
    const start = (currentPage - 1) * PER_PAGE;
    const end   = start + PER_PAGE;

    document.querySelectorAll('#menuGrid .dish-card').forEach(card => card.style.display = 'none');
    cards.forEach((card, i) => { card.style.display = (i >= start && i < end) ? '' : 'none'; });

    let noMsg = document.getElementById('noProductsMsg');
    if (total === 0) {
        if (!noMsg) {
            noMsg = document.createElement('div');
            noMsg.id = 'noProductsMsg';
            noMsg.className = 'no-products';
            noMsg.innerHTML = `<span class="no-products-icon">🔍</span><p style="font-weight:600;">No dishes in this category yet</p>`;
            document.getElementById('menuGrid').appendChild(noMsg);
        }
        noMsg.style.display = '';
    } else if (noMsg) {
        noMsg.style.display = 'none';
    }

    const pag = document.getElementById('menuPagination');
    if (pages <= 1) { pag.innerHTML = ''; return; }
    let html = `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>‹</button>`;
    for (let p = 1; p <= pages; p++) {
        html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
    }
    html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage === pages ? 'disabled' : ''}>›</button>`;
    const from = start + 1, to = Math.min(end, total);
    html += `<span class="page-info">Showing ${from}–${to} of ${total}</span>`;
    pag.innerHTML = html;
}

function goPage(page) {
    const pages = Math.ceil(getFilteredCards().length / PER_PAGE);
    if (page < 1 || page > pages) return;
    currentPage = page;
    renderPage();
    document.getElementById('menu').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function filterMenu(btn, categoryId) {
    document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    activeCatId = categoryId;
    currentPage = 1;
    renderPage();
}

renderPage();
</script>
</body>
</html>