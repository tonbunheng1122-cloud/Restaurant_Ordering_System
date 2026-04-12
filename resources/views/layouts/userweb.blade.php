<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>FastBite | Order Food</title>
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

body {
    background-color: var(--cream);
    color: var(--dark);
    font-family: 'DM Sans', sans-serif;
    overflow-x: hidden;
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--cream); }
::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }

/* ─── NAV ─── */
nav {
    position: sticky; top: 0; z-index: 100;
    background: rgba(255,245,238,0.95);
    backdrop-filter: blur(24px);
    border-bottom: 1px solid rgba(244,82,30,0.12);
    padding: 0 4%;
}

.nav-inner {
    max-width: 1400px; margin: 0 auto;
    display: flex; align-items: center; justify-content: space-between;
    height: 60px;
}

.logo {
    font-family: 'Bebas Neue', sans-serif; font-size: 1.7rem;
    letter-spacing: 2px; text-decoration: none; color: var(--dark);
}
.logo span { color: var(--orange); }

.nav-links {
    display: flex; align-items: center; gap: 2rem; list-style: none;
}

.nav-links a {
    text-decoration: none; color: var(--mid); font-weight: 600;
    font-size: 0.8rem; letter-spacing: 0.12em; text-transform: uppercase;
    transition: color 0.2s;
}
.nav-links a:hover { color: var(--orange); }

.nav-cta {
    background: var(--orange); color: #fff; border: none;
    border-radius: 12px; padding: 0.55rem 1.2rem; font-size: 0.8rem;
    font-weight: 700; cursor: pointer; letter-spacing: 0.06em;
    text-decoration: none; display: inline-flex; align-items: center;
    gap: 0.4rem; transition: background 0.2s, transform 0.15s;
    box-shadow: 0 6px 18px rgba(244,82,30,0.35);
}
.nav-cta:hover { background: var(--orange-light); transform: translateY(-2px); }

.hamburger {
    display: none; flex-direction: column; gap: 5px;
    cursor: pointer; padding: 6px; border: none; background: transparent;
}
.hamburger span {
    display: block; width: 22px; height: 2px;
    background: var(--dark); border-radius: 2px; transition: all 0.3s;
}
.hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

.mobile-nav {
    display: none; position: fixed; inset: 0;
    background: var(--dark); z-index: 200;
    flex-direction: column; align-items: center; justify-content: center;
    gap: 2rem;
}
.mobile-nav.open { display: flex; }
.mobile-nav a {
    font-family: 'Bebas Neue', sans-serif; font-size: 2.5rem;
    letter-spacing: 3px; text-decoration: none; color: var(--cream);
    transition: color 0.2s;
}
.mobile-nav a:hover { color: var(--orange); }
.mobile-nav .close-nav {
    position: absolute; top: 20px; right: 20px;
    font-size: 1.6rem; cursor: pointer; background: none; border: none; color: var(--cream);
}
.mobile-nav .nav-cta {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.1rem; letter-spacing: 2px;
    padding: 0.9rem 2.5rem; border-radius: 16px;
}

/* ─── HERO ─── */
.hero {
    max-width: 1400px; margin: 0 auto;
    padding: 5rem 4% 4rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    min-height: calc(100vh - 60px);
}

.hero-left { display: flex; flex-direction: column; gap: 1.8rem; }

.hero-label {
    display: inline-flex; align-items: center; gap: 0.6rem;
    background: rgba(244,82,30,0.1); border: 1px solid rgba(244,82,30,0.25);
    color: var(--orange); padding: 0.45rem 1rem; border-radius: 50px;
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.15em;
    text-transform: uppercase; width: fit-content;
}

.hero-label-dot {
    width: 7px; height: 7px; background: var(--orange); border-radius: 50%;
    animation: pulse 1.5s infinite;
}

.hero-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(3.5rem, 9vw, 6.5rem);
    line-height: 0.95;
    letter-spacing: 1px;
}

.hero-title em {
    font-style: italic;
    font-family: 'Playfair Display', serif;
    color: var(--orange);
    display: block;
}

.hero-desc {
    font-size: 1rem; color: var(--muted); line-height: 1.7; max-width: 420px;
}

.hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; }

.btn-hero-primary {
    background: var(--dark); color: #fff; border: none;
    border-radius: 16px; padding: 1rem 2rem;
    font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;
    letter-spacing: 1px; cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center; gap: 0.6rem;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 10px 30px rgba(26,15,10,0.25);
}
.btn-hero-primary:hover { background: var(--mid); transform: translateY(-3px); }

.btn-hero-secondary {
    background: transparent; color: var(--dark);
    border: 2px solid rgba(26,15,10,0.2);
    border-radius: 16px; padding: 1rem 2rem;
    font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;
    letter-spacing: 1px; cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center; gap: 0.6rem;
    transition: all 0.2s;
}
.btn-hero-secondary:hover {
    border-color: var(--orange); color: var(--orange);
    transform: translateY(-3px);
}

.hero-stats {
    display: flex; gap: 2.5rem; padding-top: 0.5rem;
    border-top: 1px solid rgba(0,0,0,0.07);
}
.stat-item {}
.stat-num {
    font-family: 'Bebas Neue', sans-serif; font-size: 2rem;
    color: var(--dark); line-height: 1;
}
.stat-num span { color: var(--orange); }
.stat-label { font-size: 0.73rem; color: var(--muted); font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; margin-top: 2px; }

/* ─── HERO RIGHT: FLOATING DISH CARDS ─── */
.hero-right {
    position: relative;
    height: 520px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-visual {
    position: relative; width: 100%; height: 100%;
}

.hero-main-img {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 340px; height: 340px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 30px 80px rgba(244,82,30,0.25), 0 0 0 16px rgba(244,82,30,0.08);
    animation: floatMain 5s ease-in-out infinite;
}

.hero-float-card {
    position: absolute;
    background: #fff;
    border-radius: 20px;
    padding: 1rem;
    box-shadow: 0 16px 48px rgba(0,0,0,0.12);
    display: flex; align-items: center; gap: 0.8rem;
    min-width: 170px;
    animation: floatCard 6s ease-in-out infinite;
}

.hero-float-card:nth-child(2) {
    top: 40px; left: 0;
    animation-delay: 0s; animation-duration: 6s;
}
.hero-float-card:nth-child(3) {
    bottom: 80px; left: 10px;
    animation-delay: 1.5s; animation-duration: 7s;
}
.hero-float-card:nth-child(4) {
    top: 60px; right: 0;
    animation-delay: 0.8s; animation-duration: 5.5s;
}
.hero-float-card:nth-child(5) {
    bottom: 60px; right: 10px;
    animation-delay: 2.2s; animation-duration: 6.5s;
}

.float-card-emoji { font-size: 2rem; }

.float-card-info {}
.float-card-name {
    font-weight: 700; font-size: 0.82rem; color: var(--dark);
    line-height: 1.2; white-space: nowrap;
}
.float-card-price {
    font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem;
    color: var(--orange); margin-top: 1px;
}

.hero-bg-circle {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 420px; height: 420px;
    background: radial-gradient(circle, rgba(244,82,30,0.08) 0%, transparent 70%);
    border-radius: 50%;
    z-index: -1;
}

/* ─── CATEGORIES STRIP ─── */
.categories-strip {
    background: var(--dark); padding: 2.5rem 4%;
}

.categories-inner {
    max-width: 1400px; margin: 0 auto;
    display: flex; align-items: center; gap: 2rem;
    overflow-x: auto; scrollbar-width: none;
}
.categories-inner::-webkit-scrollbar { display: none; }

.cat-strip-label {
    font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem;
    letter-spacing: 2px; color: rgba(255,255,255,0.3);
    white-space: nowrap; flex-shrink: 0;
}

.cat-strip-divider {
    width: 1px; height: 36px; background: rgba(255,255,255,0.1); flex-shrink: 0;
}

.cat-strip-items { display: flex; gap: 0.7rem; flex-shrink: 0; }

.cat-chip {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.7); padding: 0.5rem 1rem; border-radius: 50px;
    font-size: 0.8rem; font-weight: 600; cursor: pointer; white-space: nowrap;
    text-decoration: none; transition: all 0.2s;
}
.cat-chip:hover {
    background: var(--orange); border-color: var(--orange); color: #fff;
    transform: translateY(-2px);
}
.cat-chip-count {
    background: rgba(255,255,255,0.12); padding: 0.1rem 0.45rem;
    border-radius: 50px; font-size: 0.68rem; font-weight: 700;
}

/* ─── SECTION ─── */
.section-label {
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.15em;
    text-transform: uppercase; color: var(--orange); margin-bottom: 0.6rem;
}
.section-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.2rem, 8vw, 4.5rem); line-height: 1; margin-bottom: 0.4rem;
}
.section-sub { color: var(--muted); font-size: 0.95rem; }

/* ─── HOW IT WORKS ─── */
.how-section {
    max-width: 1400px; margin: 0 auto;
    padding: 5rem 4%;
}

.how-grid {
    display: grid; grid-template-columns: repeat(3,1fr); gap: 2rem;
    margin-top: 3rem;
}

.how-card {
    background: #fff; border-radius: 24px; padding: 2rem;
    border: 1px solid rgba(0,0,0,0.05);
    position: relative; overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}
.how-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 60px rgba(244,82,30,0.1);
}

.how-step-num {
    font-family: 'Bebas Neue', sans-serif; font-size: 5rem; line-height: 1;
    color: rgba(244,82,30,0.08); position: absolute; top: 1rem; right: 1.5rem;
    letter-spacing: -2px;
}

.how-icon {
    width: 56px; height: 56px; background: rgba(244,82,30,0.1);
    border-radius: 16px; display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; margin-bottom: 1.2rem;
}

.how-card-title {
    font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem;
    letter-spacing: 0.5px; margin-bottom: 0.6rem;
}
.how-card-desc { font-size: 0.85rem; color: var(--muted); line-height: 1.65; }

/* ─── MENU ─── */
.menu-section {
    max-width: 1400px; margin: 0 auto; padding: 4rem 4%;
}

.menu-header {
    display: flex; justify-content: space-between; align-items: flex-end;
    margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1.2rem;
}

.filter-tabs {
    display: flex; background: rgba(0,0,0,0.05); padding: 4px;
    border-radius: 12px; gap: 3px; overflow-x: auto; scrollbar-width: none;
}
.filter-tabs::-webkit-scrollbar { display: none; }

.filter-tab {
    padding: 0.5rem 1rem; border-radius: 9px; font-size: 0.78rem;
    font-weight: 700; cursor: pointer; border: none; background: transparent;
    color: var(--mid); transition: all 0.2s; white-space: nowrap; flex-shrink: 0;
}
.filter-tab.active { background: #fff; color: var(--dark); box-shadow: 0 2px 12px rgba(0,0,0,0.1); }
.filter-tab:hover:not(.active) { color: var(--orange); }

.menu-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem; }

.dish-card {
    background: #fff; border-radius: 24px; overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}
.dish-card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(244,82,30,0.12); }

.dish-img-wrap { position: relative; overflow: hidden; }
.dish-img-wrap img {
    width: 100%; height: 220px; object-fit: cover; display: block;
    transition: transform 0.5s;
}
.dish-card:hover .dish-img-wrap img { transform: scale(1.07); }

.dish-badge {
    position: absolute; top: 10px; left: 10px;
    background: var(--dark); color: #fff; font-size: 0.65rem; font-weight: 700;
    padding: 0.28rem 0.7rem; border-radius: 50px; letter-spacing: 0.08em; text-transform: uppercase;
}
.stock-badge, .low-badge {
    position: absolute; top: 10px; right: 10px;
    color: #fff; font-size: 0.65rem; font-weight: 700;
    padding: 0.28rem 0.7rem; border-radius: 50px;
}
.stock-badge { background: #ef4444; }
.low-badge { background: #f59e0b; }

.dish-body { padding: 1.3rem; }
.dish-category {
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--orange); margin-bottom: 0.35rem;
}
.dish-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.5px; margin-bottom: 0.35rem; }
.dish-desc {
    font-size: 0.8rem; color: var(--muted); line-height: 1.5; margin-bottom: 1rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.dish-footer { display: flex; align-items: center; justify-content: space-between; }
.dish-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--dark); }
.dish-qty-label { font-size: 0.7rem; color: var(--muted); font-weight: 600; }

.add-btn {
    width: 42px; height: 42px; border-radius: 12px; background: var(--orange);
    border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 6px 18px rgba(244,82,30,0.4); color: #fff; flex-shrink: 0;
}
.add-btn:hover { background: var(--orange-light); transform: scale(1.1); }
.add-btn svg { width: 18px; height: 18px; }
.add-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

.dish-qty-controls { display: flex; align-items: center; gap: 0.5rem; }
.qty-btn {
    width: 32px; height: 32px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.12);
    background: var(--cream); cursor: pointer; font-size: 1.1rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.qty-btn:hover { background: rgba(244,82,30,0.1); border-color: var(--orange); color: var(--orange); }
.qty-display { font-size: 0.9rem; font-weight: 700; min-width: 20px; text-align: center; }

.no-products { grid-column: 1/-1; text-align: center; padding: 5rem 2rem; color: var(--muted); }
.no-products-icon { font-size: 3rem; margin-bottom: 1rem; display: block; }

/* ─── MENU PAGINATION ─── */
.menu-pagination {
    display: flex; justify-content: center; align-items: center;
    gap: 0.5rem; margin-top: 2.5rem; flex-wrap: wrap;
}
.page-btn {
    width: 40px; height: 40px; border-radius: 10px; border: 1.5px solid rgba(0,0,0,0.1);
    background: #fff; cursor: pointer; font-size: 0.85rem; font-weight: 700; color: var(--mid);
    transition: all 0.2s; display: flex; align-items: center; justify-content: center;
}
.page-btn:hover { border-color: var(--orange); color: var(--orange); }
.page-btn.active { background: var(--orange); border-color: var(--orange); color: #fff; box-shadow: 0 4px 14px rgba(244,82,30,0.4); }
.page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
.page-info { font-size: 0.78rem; color: var(--muted); font-weight: 600; padding: 0 0.5rem; }

/* ─── CART DRAWER ─── */
.cart-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.4);
    z-index: 300; opacity: 0; pointer-events: none; transition: opacity 0.3s;
}
.cart-overlay.open { opacity: 1; pointer-events: auto; }

.cart-drawer {
    position: fixed; top: 0; right: -420px; width: 420px;
    max-width: 100vw; height: 100vh; background: var(--cream);
    z-index: 301; display: flex; flex-direction: column;
    transition: right 0.35s cubic-bezier(0.4,0,0.2,1);
    box-shadow: -20px 0 60px rgba(0,0,0,0.15);
}
.cart-drawer.open { right: 0; }

.cart-header {
    padding: 1.5rem 1.5rem 1.2rem; border-bottom: 1px solid rgba(0,0,0,0.08);
    display: flex; align-items: center; justify-content: space-between; background: #fff;
}
.cart-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.6rem; letter-spacing: 1px; }
.cart-close {
    width: 36px; height: 36px; border-radius: 10px; background: var(--cream);
    border: 1px solid rgba(0,0,0,0.1); cursor: pointer; font-size: 1.1rem;
    display: flex; align-items: center; justify-content: center; transition: background 0.2s;
}
.cart-close:hover { background: rgba(244,82,30,0.1); }

.cart-items { flex: 1; overflow-y: auto; padding: 1.2rem 1.5rem; }
.cart-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; gap: 1rem; color: var(--muted); }
.cart-empty-icon { font-size: 3rem; }

.cart-item {
    display: flex; gap: 1rem; align-items: center;
    padding: 1rem 0; border-bottom: 1px solid rgba(0,0,0,0.06);
}
.cart-item:last-child { border-bottom: none; }
.cart-item-img { width: 60px; height: 60px; border-radius: 12px; object-fit: cover; flex-shrink: 0; }
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-name { font-weight: 700; font-size: 0.9rem; color: var(--dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cart-item-price { font-size: 0.82rem; color: var(--orange); font-weight: 700; margin-top: 2px; }
.cart-item-controls { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
.cart-qty-btn {
    width: 28px; height: 28px; border-radius: 7px; border: 1px solid rgba(0,0,0,0.12);
    background: var(--cream); cursor: pointer; font-size: 1rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.cart-qty-btn:hover { background: rgba(244,82,30,0.1); border-color: var(--orange); color: var(--orange); }
.cart-item-qty { font-size: 0.9rem; font-weight: 700; min-width: 20px; text-align: center; }
.cart-item-remove {
    width: 28px; height: 28px; border-radius: 7px; border: none;
    background: transparent; cursor: pointer; color: #ef4444; font-size: 1rem;
    display: flex; align-items: center; justify-content: center; transition: background 0.2s;
}
.cart-item-remove:hover { background: rgba(239,68,68,0.1); }

.cart-footer { padding: 1.2rem 1.5rem; background: #fff; border-top: 1px solid rgba(0,0,0,0.08); }
.cart-subtotal { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.cart-subtotal-label { font-size: 0.82rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; }
.cart-subtotal-value { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--dark); }

.btn-checkout {
    width: 100%; background: var(--orange); color: #fff; border: none;
    border-radius: 14px; padding: 1rem;
    font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: 1px;
    cursor: pointer; transition: background 0.2s, transform 0.15s;
    box-shadow: 0 6px 20px rgba(244,82,30,0.4);
}
.btn-checkout:hover { background: var(--orange-light); transform: translateY(-2px); }
.btn-checkout:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }
.cart-item-count { font-size: 0.75rem; color: var(--muted); margin-top: 0.2rem; }

.cart-nav-btn {
    position: relative; background: var(--dark); color: #fff; border: none;
    border-radius: 12px; padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; gap: 0.5rem;
    letter-spacing: 0.06em; transition: background 0.2s, transform 0.15s;
}
.cart-nav-btn:hover { background: var(--mid); transform: translateY(-2px); }
.cart-nav-count {
    position: absolute; top: -6px; right: -6px; background: var(--orange); color: #fff;
    width: 18px; height: 18px; border-radius: 50%; font-size: 0.65rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
}
.cart-nav-count.hidden { display: none; }

/* ─── CHECKOUT MODAL ─── */
.checkout-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 400;
    display: flex; align-items: center; justify-content: center; padding: 1rem;
    opacity: 0; pointer-events: none; transition: opacity 0.3s;
}
.checkout-overlay.open { opacity: 1; pointer-events: auto; }

.checkout-modal {
    background: #fff; border-radius: 28px; width: 100%; max-width: 560px;
    max-height: 90vh; overflow-y: auto; box-shadow: 0 30px 80px rgba(0,0,0,0.2);
    transform: scale(0.95) translateY(20px);
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
}
.checkout-overlay.open .checkout-modal { transform: scale(1) translateY(0); }

.checkout-modal-header {
    background: var(--dark); padding: 2rem 2rem 1.5rem;
    border-radius: 28px 28px 0 0; position: relative;
}
.checkout-modal-title { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; letter-spacing: 1px; color: #fff; }
.checkout-modal-sub { font-size: 0.82rem; color: rgba(255,255,255,0.5); margin-top: 0.3rem; }
.checkout-modal-close {
    position: absolute; top: 1.5rem; right: 1.5rem; width: 36px; height: 36px;
    border-radius: 10px; background: rgba(255,255,255,0.1); border: none;
    cursor: pointer; color: #fff; font-size: 1.1rem;
    display: flex; align-items: center; justify-content: center; transition: background 0.2s;
}
.checkout-modal-close:hover { background: rgba(255,255,255,0.2); }

.checkout-modal-body { padding: 2rem; }
.checkout-section-title {
    font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 0.5px;
    color: var(--dark); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;
}
.checkout-section-title::after { content: ''; flex: 1; height: 1px; background: rgba(0,0,0,0.08); margin-left: 0.5rem; }

.form-group { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1rem; }
.form-group label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--mid); }
.form-group input, .form-group textarea {
    width: 100%; padding: 0.85rem 1rem; border: 1.5px solid rgba(0,0,0,0.1);
    border-radius: 12px; font-family: 'DM Sans', sans-serif; font-size: 0.9rem;
    color: var(--dark); background: var(--cream); transition: border-color 0.2s, box-shadow 0.2s; outline: none;
}
.form-group input:focus, .form-group textarea:focus { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(244,82,30,0.1); }
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

.btn-place-order {
    width: 100%; background: var(--orange); color: #fff; border: none;
    border-radius: 14px; padding: 1.1rem;
    font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; letter-spacing: 1px;
    cursor: pointer; transition: background 0.2s, transform 0.15s;
    box-shadow: 0 6px 24px rgba(244,82,30,0.4);
    display: flex; align-items: center; justify-content: center; gap: 0.6rem;
}
.btn-place-order:hover { background: var(--orange-light); transform: translateY(-2px); }
.required-star { color: var(--orange); }

/* ─── SUCCESS MODAL ─── */
.success-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 500;
    display: flex; align-items: center; justify-content: center; padding: 1rem;
    opacity: 0; pointer-events: none; transition: opacity 0.3s;
}
.success-overlay.open { opacity: 1; pointer-events: auto; }
.success-modal {
    background: #fff; border-radius: 28px; width: 100%; max-width: 400px;
    padding: 3rem 2rem; text-align: center; box-shadow: 0 30px 80px rgba(0,0,0,0.2);
    transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.success-overlay.open .success-modal { transform: scale(1); }
.success-icon { font-size: 4rem; margin-bottom: 1rem; display: block; animation: bounceIn 0.5s 0.1s ease both; }
.success-title { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; letter-spacing: 1px; margin-bottom: 0.5rem; }
.success-msg { font-size: 0.9rem; color: var(--muted); line-height: 1.6; margin-bottom: 2rem; }
.btn-success-close {
    background: var(--dark); color: #fff; border: none; border-radius: 14px;
    padding: 0.9rem 2rem; font-family: 'Bebas Neue', sans-serif;
    font-size: 1.1rem; letter-spacing: 1px; cursor: pointer; transition: background 0.2s;
}
.btn-success-close:hover { background: var(--mid); }

/* ─── TOAST ─── */
.toast {
    position: fixed; top: 80px; right: 20px; z-index: 9998;
    background: #22c55e; color: #fff; padding: 0.9rem 1.4rem; border-radius: 14px;
    font-weight: 600; font-size: 0.88rem; box-shadow: 0 10px 40px rgba(34,197,94,0.4);
    display: flex; align-items: center; gap: 0.6rem;
    transform: translateX(200px); opacity: 0;
    transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s;
    pointer-events: none;
}
.toast.show { transform: translateX(0); opacity: 1; }

/* ─── FOOTER ─── */
.footer {
    background: var(--dark);
    padding-top: 5rem;
    margin-top: 6rem;
    position: relative;
    overflow: hidden;
}

.footer::before {
    content: 'FASTBITE';
    position: absolute; top: -1.5rem; left: 50%;
    transform: translateX(-50%);
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(5rem, 14vw, 11rem);
    letter-spacing: 0.05em; color: rgba(255,255,255,0.025);
    white-space: nowrap; pointer-events: none;
}

.footer-inner {
    max-width: 1400px; margin: 0 auto; padding: 0 4%;
}

.footer-top {
    display: grid;
    grid-template-columns: 1.8fr 1fr 1fr 1.2fr;
    gap: 3rem;
    padding-bottom: 4rem;
    border-bottom: 1px solid rgba(255,255,255,0.07);
}

.footer-brand {}
.footer-logo {
    font-family: 'Bebas Neue', sans-serif; font-size: 2.2rem;
    letter-spacing: 3px; color: #fff; text-decoration: none; display: block; margin-bottom: 1rem;
}
.footer-logo span { color: var(--orange); }
.footer-brand-desc {
    font-size: 0.85rem; color: rgba(255,255,255,0.45); line-height: 1.75; max-width: 280px;
    margin-bottom: 1.5rem;
}

.footer-social { display: flex; gap: 0.7rem; }
.social-btn {
    width: 40px; height: 40px; border-radius: 12px;
    background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.6); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; transition: all 0.2s; text-decoration: none;
}
.social-btn:hover { background: var(--orange); border-color: var(--orange); color: #fff; transform: translateY(-2px); }

.footer-col {}
.footer-col-title {
    font-size: 0.7rem; font-weight: 700; letter-spacing: 0.15em;
    text-transform: uppercase; color: rgba(255,255,255,0.35);
    margin-bottom: 1.2rem;
}
.footer-links { list-style: none; display: flex; flex-direction: column; gap: 0.75rem; }
.footer-links a {
    text-decoration: none; color: rgba(255,255,255,0.6); font-size: 0.88rem;
    font-weight: 500; transition: color 0.2s; display: inline-flex; align-items: center; gap: 0.4rem;
}
.footer-links a:hover { color: var(--orange); }

.footer-newsletter {}
.footer-newsletter-title {
    font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; letter-spacing: 1px;
    color: #fff; margin-bottom: 0.5rem;
}
.footer-newsletter-sub { font-size: 0.82rem; color: rgba(255,255,255,0.4); margin-bottom: 1.2rem; line-height: 1.6; }

.newsletter-form { display: flex; gap: 0; }
.newsletter-input {
    flex: 1; padding: 0.85rem 1rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-right: none;
    border-radius: 12px 0 0 12px;
    color: #fff; font-family: 'DM Sans', sans-serif; font-size: 0.85rem;
    outline: none; transition: border-color 0.2s;
}
.newsletter-input::placeholder { color: rgba(255,255,255,0.25); }
.newsletter-input:focus { border-color: var(--orange); }
.newsletter-btn {
    background: var(--orange); color: #fff; border: none;
    border-radius: 0 12px 12px 0; padding: 0 1.2rem;
    font-family: 'Bebas Neue', sans-serif; font-size: 0.95rem; letter-spacing: 1px;
    cursor: pointer; transition: background 0.2s; white-space: nowrap;
}
.newsletter-btn:hover { background: var(--orange-light); }

.footer-hours {
    background: rgba(244,82,30,0.08); border: 1px solid rgba(244,82,30,0.15);
    border-radius: 14px; padding: 1rem 1.2rem; margin-top: 1.2rem;
}
.footer-hours-title { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--orange); margin-bottom: 0.6rem; }
.footer-hours-row {
    display: flex; justify-content: space-between;
    font-size: 0.8rem; color: rgba(255,255,255,0.55); margin-bottom: 0.3rem;
}
.footer-hours-row:last-child { margin-bottom: 0; }
.footer-hours-row span:last-child { color: rgba(255,255,255,0.8); font-weight: 600; }

.footer-bottom {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.8rem 0; flex-wrap: wrap; gap: 1rem;
}
.footer-copy { font-size: 0.78rem; color: rgba(255,255,255,0.25); }
.footer-copy a { color: var(--orange); text-decoration: none; }
.footer-copy a:hover { text-decoration: underline; }

.footer-badges { display: flex; gap: 0.6rem; align-items: center; }
.footer-badge {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 8px; padding: 0.4rem 0.8rem;
    font-size: 0.7rem; color: rgba(255,255,255,0.35); font-weight: 600; letter-spacing: 0.06em;
}

/* ─── ANIMATIONS ─── */
@keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
@keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.1); } }
@keyframes bounceIn { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
@keyframes floatMain { 0%, 100% { transform: translate(-50%,-50%) translateY(0); } 50% { transform: translate(-50%,-50%) translateY(-16px); } }
@keyframes floatCard { 0%, 100% { transform: translateY(0) rotate(0deg); } 33% { transform: translateY(-10px) rotate(1deg); } 66% { transform: translateY(-5px) rotate(-1deg); } }

.reveal { opacity: 0; transform: translateY(36px); transition: opacity 0.65s ease, transform 0.65s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }

/* ─── RESPONSIVE ─── */
@media (max-width: 1100px) {
    .footer-top { grid-template-columns: 1fr 1fr; gap: 2rem; }
    .footer-brand { grid-column: 1/-1; }
    .hero { grid-template-columns: 1fr; min-height: auto; padding: 4rem 4% 3rem; }
    .hero-right { display: none; }
    .how-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 1024px) { .menu-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 768px) {
    .nav-links { display: none; }
    .hamburger { display: flex; }
    .menu-grid { grid-template-columns: 1fr; }
    .menu-header { flex-direction: column; align-items: flex-start; }
    .cart-drawer { width: 100%; right: -100%; }
    .toast { left: 12px; right: 12px; top: 70px; }
    .how-grid { grid-template-columns: 1fr; }
    .footer-top { grid-template-columns: 1fr; }
    .footer-brand { grid-column: auto; }
    .hero-title { font-size: 3rem; }
    .hero-stats { gap: 1.5rem; }
}
@media (max-width: 420px) { .section-title { font-size: 2rem; } }
</style>
</head>
<body>

<!-- TOAST -->
<div class="toast" id="toast">✓ <span id="toast-text"></span></div>

<!-- MOBILE NAV -->
<div class="mobile-nav" id="mobileNav">
    <button class="close-nav" id="closeNav">✕</button>
    <a href="#" onclick="closeMobileNav()">Home</a>
    <a href="#menu" onclick="closeMobileNav()">Menu</a>
    <a href="#how" onclick="closeMobileNav()">How It Works</a>
    <a class="nav-cta" href="#menu" onclick="closeMobileNav()">🛒 Order Now</a>
</div>

<!-- NAV -->
<nav>
    <div class="nav-inner">
        <a href="#" class="logo"><span>FAST</span>BITE</a>

        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#how">How It Works</a></li>
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

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <div class="hero-label reveal">
            <span class="hero-label-dot"></span>
            Now Serving · Table Ready
        </div>

        <h1 class="hero-title reveal" style="transition-delay:0.1s">
            Real Food,
            <em>Real Fast.</em>
            No Wait.
        </h1>

        <p class="hero-desc reveal" style="transition-delay:0.2s">
            Scan, browse, and order straight from your table. Fresh ingredients, bold flavours — delivered directly to you.
        </p>

        <div class="hero-actions reveal" style="transition-delay:0.3s">
            <a class="btn-hero-primary" href="#menu">
                🍽️ Browse Menu
            </a>
            <a class="btn-hero-secondary" href="#how">
                How It Works ↓
            </a>
        </div>

        <div class="hero-stats reveal" style="transition-delay:0.4s">
            <div class="stat-item">
                <div class="stat-num">{{ $products->count() }}<span>+</span></div>
                <div class="stat-label">Dishes</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">{{ $categories->count() }}<span>+</span></div>
                <div class="stat-label">Categories</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">15<span>m</span></div>
                <div class="stat-label">Avg. Ready Time</div>
            </div>
        </div>
    </div>

    <div class="hero-right">
        <div class="hero-visual">
            <div class="hero-bg-circle"></div>

            <img
                class="hero-main-img"
                src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&q=80"
                alt="Featured Dish"
            >

            <div class="hero-float-card">
                <span class="float-card-emoji">🍔</span>
                <div class="float-card-info">
                    <div class="float-card-name">Classic Burger</div>
                    <div class="float-card-price">$9.90</div>
                </div>
            </div>

            <div class="hero-float-card">
                <span class="float-card-emoji">🍕</span>
                <div class="float-card-info">
                    <div class="float-card-name">Margherita</div>
                    <div class="float-card-price">$12.50</div>
                </div>
            </div>

            <div class="hero-float-card">
                <span class="float-card-emoji">🌮</span>
                <div class="float-card-info">
                    <div class="float-card-name">Street Tacos</div>
                    <div class="float-card-price">$7.90</div>
                </div>
            </div>

            <div class="hero-float-card">
                <span class="float-card-emoji">🥗</span>
                <div class="float-card-info">
                    <div class="float-card-name">Garden Bowl</div>
                    <div class="float-card-price">$8.50</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CATEGORIES STRIP -->
<div class="categories-strip">
    <div class="categories-inner">
        <span class="cat-strip-label">CATEGORIES</span>
        <div class="cat-strip-divider"></div>
        <div class="cat-strip-items">
            <a class="cat-chip" href="#menu" onclick="filterMenu(document.querySelector('.filter-tab'),'all')">
                All <span class="cat-chip-count">{{ $products->count() }}</span>
            </a>
            @foreach($categories as $cat)
                <a class="cat-chip" href="#menu" onclick="filterMenuById('{{ $cat->id }}')">
                    {{ $cat->name }}
                    <span class="cat-chip-count">{{ $cat->products_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- HOW IT WORKS -->
<section id="how" class="how-section">
    <div class="reveal">
        <div class="section-label">Simple Process</div>
        <h2 class="section-title">How It Works</h2>
        <p class="section-sub">Order in three easy steps — no app needed.</p>
    </div>

    <div class="how-grid">
        <div class="how-card reveal" style="transition-delay:0.1s">
            <div class="how-step-num">01</div>
            <div class="how-icon">🔍</div>
            <div class="how-card-title">Browse the Menu</div>
            <p class="how-card-desc">Explore our {{ $products->count() }} fresh dishes across {{ $categories->count() }} categories. Filter by cuisine, check availability in real-time.</p>
        </div>

        <div class="how-card reveal" style="transition-delay:0.2s">
            <div class="how-step-num">02</div>
            <div class="how-icon">🛒</div>
            <div class="how-card-title">Add to Cart</div>
            <p class="how-card-desc">Tap the + button to add dishes to your cart. Adjust quantities anytime and add special notes for the kitchen.</p>
        </div>

        <div class="how-card reveal" style="transition-delay:0.3s">
            <div class="how-step-num">03</div>
            <div class="how-icon">✅</div>
            <div class="how-card-title">Send to Kitchen</div>
            <p class="how-card-desc">Confirm your order with your name and we'll bring it straight to your table. Sit back and enjoy!</p>
        </div>
    </div>
</section>

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
<div class="checkout-overlay" id="checkoutOverlay">
    <div class="checkout-modal">
        <div class="checkout-modal-header">
            <div class="checkout-modal-title">Confirm Order</div>
            <div class="checkout-modal-sub">Review your items before sending to the kitchen</div>
            <button class="checkout-modal-close" onclick="closeCheckout()">✕</button>
        </div>
        <div class="checkout-modal-body">
            <div class="checkout-section-title">Order Summary</div>
            <div class="checkout-order-summary" id="checkoutSummary"></div>
            <div class="checkout-section-title">Order Details</div>
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
                    <a class="social-btn" href="#" title="Instagram">📸</a>
                    <a class="social-btn" href="#" title="Facebook">👍</a>
                    <a class="social-btn" href="#" title="TikTok">🎵</a>
                    <a class="social-btn" href="#" title="Twitter / X">🐦</a>   
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <div class="footer-col-title">Quick Links</div>
                <ul class="footer-links">
                    <li><a href="#">🏠 Home</a></li>
                    <li><a href="#menu">🍽️ Our Menu</a></li>
                    <li><a href="#how">ℹ️ How It Works</a></li>
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

<script>
let cart = [];
let isPlacingOrder = false;
const orderStoreUrl = '{{ route('order.store') }}';
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

/* ─── CART LOGIC ─── */
function addToCart(id, name, price, image) {
    const existing = cart.find(i => i.id === id);
    if (existing) { existing.qty++; }
    else { cart.push({ id, name, price: parseFloat(price), image, qty: 1 }); }
    updateCartUI(); updateDishAction(id); showToast(`${name} added to cart! 🛒`);
}

function removeFromCart(id) { cart = cart.filter(i => i.id !== id); updateCartUI(); updateDishAction(id); }

function changeQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
    updateCartUI(); updateDishAction(id);
}

function updateDishAction(id) {
    const item = cart.find(i => i.id === id);
    const el = document.getElementById('dish-action-' + id);
    if (!el) return;
    const card = el.closest('.dish-card');
    const name = card ? card.dataset.name : '';
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

/* ─── CART UI ─── */
function updateCartUI() {
    const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const totalQty = cart.reduce((s, i) => s + i.qty, 0);
    const isEmpty = cart.length === 0;

    document.getElementById('cartNavCount').textContent = totalQty;
    document.getElementById('mobileCartCount').textContent = totalQty;
    document.getElementById('cartNavCount').classList.toggle('hidden', isEmpty);
    document.getElementById('mobileCartCount').classList.toggle('hidden', isEmpty);
    document.getElementById('cartItemCount').textContent = totalQty === 0 ? '0 items' : `${totalQty} item${totalQty > 1 ? 's' : ''}`;
    document.getElementById('cartTotal').textContent = '$' + total.toFixed(2);
    document.getElementById('checkoutBtn').disabled = isEmpty;

    const itemsEl = document.getElementById('cartItems');
    document.getElementById('cartEmpty').style.display = isEmpty ? 'flex' : 'none';
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

/* ─── CART DRAWER ─── */
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

/* ─── CHECKOUT ─── */
function openCheckout() {
    if (cart.length === 0) return;
    closeCart();
    const summary = document.getElementById('checkoutSummary');
    const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
    let html = '';
    cart.forEach(item => {
        html += `<div class="checkout-order-row">
            <span class="checkout-order-name">${item.name}<span class="checkout-order-qty">×${item.qty}</span></span>
            <span class="checkout-order-price">$${(item.price * item.qty).toFixed(2)}</span>
        </div>`;
    });
    html += `<div class="checkout-order-row checkout-total-row">
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

/* ─── PLACE ORDER ─── */
function placeOrder() {
    if (isPlacingOrder || cart.length === 0) return;

    const name = document.getElementById('ckName').value.trim();
    const notes = document.getElementById('ckNotes').value.trim();
    const button = document.querySelector('.btn-place-order');

    if (!name) {
        const el = document.getElementById('ckName');
        el.style.borderColor = '#ef4444';
        el.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
        el.focus();
        showToast('⚠️ Please enter your name', true);
        el.addEventListener('input', () => { el.style.borderColor = ''; el.style.boxShadow = ''; }, { once: true });
        return;
    }

    const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const cartSnapshot = cart.map(item => ({ ...item }));

    isPlacingOrder = true;
    if (button) {
        button.disabled = true;
        button.dataset.originalText = button.innerHTML;
        button.innerHTML = 'Sending...';
    }

    fetch(orderStoreUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            name,
            notes,
            total,
            cart: cartSnapshot,
        }),
    })
        .then(async response => {
            const data = await response.json().catch(() => ({}));
            if (!response.ok) {
                throw new Error(data.error || data.message || 'Order failed. Please try again.');
            }
            return data;
        })
        .then(data => {
            document.getElementById('successMsg').textContent =
                `Thank you, ${name}! Your order #${data.order_id} of $${total.toFixed(2)} has been sent to the kitchen. We'll bring it to you shortly.`;
            closeCheckout();
            cart = [];
            updateCartUI();
            cartSnapshot.forEach(item => updateDishAction(item.id));
            document.getElementById('ckName').value = '';
            document.getElementById('ckNotes').value = '';
            setTimeout(() => {
                document.getElementById('successOverlay').classList.add('open');
                document.body.style.overflow = 'hidden';
            }, 200);
        })
        .catch(error => {
            showToast(error.message || 'Order failed. Please try again.', true);
        })
        .finally(() => {
            isPlacingOrder = false;
            if (button) {
                button.disabled = false;
                button.innerHTML = button.dataset.originalText || button.innerHTML;
            }
        });
}
function closeSuccess() {
    document.getElementById('successOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ─── TOAST ─── */
function showToast(msg, isError = false) {
    const toast = document.getElementById('toast');
    document.getElementById('toast-text').textContent = msg;
    toast.style.background = isError ? '#ef4444' : '#22c55e';
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 3000);
}

/* ─── MOBILE NAV ─── */
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNavBtn = document.getElementById('closeNav');

function openMobileNav() { mobileNav.classList.add('open'); hamburger.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeMobileNav() { mobileNav.classList.remove('open'); hamburger.classList.remove('open'); document.body.style.overflow = ''; }
function toggleMobileNav() { mobileNav.classList.contains('open') ? closeMobileNav() : openMobileNav(); }

hamburger.addEventListener('click', toggleMobileNav);
closeNavBtn.addEventListener('click', closeMobileNav);

function checkMobileCart() {
    document.getElementById('mobileCartBtn').style.display = window.innerWidth <= 768 ? 'flex' : 'none';
}
checkMobileCart();
window.addEventListener('resize', checkMobileCart);

/* ─── SCROLL REVEAL ─── */
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeCart(); closeCheckout(); closeSuccess(); closeMobileNav(); }
});

/* ─── MENU PAGINATION + FILTER ─── */
const PER_PAGE = 6;
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
    const end = start + PER_PAGE;

    document.querySelectorAll('#menuGrid .dish-card').forEach(card => card.style.display = 'none');
    cards.forEach((card, i) => { card.style.display = (i >= start && i < end) ? '' : 'none'; });

    let noMsg = document.getElementById('noProductsMsg');
    if (total === 0) {
        if (!noMsg) {
            noMsg = document.createElement('div');
            noMsg.id = 'noProductsMsg'; noMsg.className = 'no-products';
            noMsg.innerHTML = `<span class="no-products-icon">🔍</span><p style="font-weight:600;">No dishes in this category yet</p>`;
            document.getElementById('menuGrid').appendChild(noMsg);
        }
        noMsg.style.display = '';
    } else if (noMsg) { noMsg.style.display = 'none'; }

    const pag = document.getElementById('menuPagination');
    if (pages <= 1) { pag.innerHTML = ''; return; }

    let html = `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>‹</button>`;
    for (let p = 1; p <= pages; p++) {
        html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
    }
    html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage === pages ? 'disabled' : ''}>›</button>`;
    html += `<span class="page-info">Showing ${start + 1}–${Math.min(end, total)} of ${total}</span>`;
    pag.innerHTML = html;
}

function goPage(page) {
    const pages = Math.ceil(getFilteredCards().length / PER_PAGE);
    if (page < 1 || page > pages) return;
    currentPage = page; renderPage();
    document.getElementById('menu').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function filterMenu(btn, categoryId) {
    document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    activeCatId = categoryId; currentPage = 1; renderPage();
}

/* ─── Helper: filter by category id from external links ─── */
function filterMenuById(catId) {
    const tab = document.querySelector(`.filter-tab[data-cat-id="${catId}"]`);
    filterMenu(tab, catId);
    setTimeout(() => {
        document.getElementById('menu').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
}

renderPage();
</script>
</body>
</html>