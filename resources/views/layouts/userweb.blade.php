    @vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
    <title>FastBite | Flavor Unleashed</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange: #F4521E;
            --orange-light: #FF7A47;
            --cream: #FFF5EE;
            --dark: #1A0F0A;
            --mid: #3D2B1F;
            --muted: #9B8880;
            --card-bg: #FFFFFF;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--cream);
            color: var(--dark);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        /* ---- NOISE TEXTURE OVERLAY ---- */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.4;
        }

        /* ---- SCROLLBAR ---- */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }

        /* ---- NAVBAR ---- */
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 245, 238, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(244, 82, 30, 0.12);
            padding: 0 6%;
        }

        .nav-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 2px;
            text-decoration: none;
            color: var(--dark);
        }
        .logo span { color: var(--orange); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            list-style: none;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--mid);
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--orange); }

        .btn-order {
            background: var(--orange);
            color: #fff !important;
            padding: 0.6rem 1.6rem;
            border-radius: 50px;
            font-weight: 700 !important;
            transition: background 0.2s, transform 0.15s !important;
            box-shadow: 0 4px 20px rgba(244,82,30,0.35);
        }
        .btn-order:hover {
            background: var(--orange-light) !important;
            transform: translateY(-2px);
        }

        /* ---- HERO ---- */
        .hero {
            min-height: calc(100vh - 70px);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 6% 2rem;
            align-items: center;
        }

        .hero-text { position: relative; z-index: 2; }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(244,82,30,0.1);
            border: 1px solid rgba(244,82,30,0.25);
            color: var(--orange);
            padding: 0.45rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.7s ease both;
        }

        .badge-dot {
            width: 7px; height: 7px;
            background: var(--orange);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.1); }
        }

        .hero-headline {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(5rem, 10vw, 9rem);
            line-height: 0.92;
            letter-spacing: 1px;
            animation: fadeUp 0.7s 0.1s ease both;
        }

        .hero-headline .accent {
            color: var(--orange);
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 0.85em;
            display: block;
        }

        .hero-sub {
            color: var(--muted);
            font-size: 1.1rem;
            line-height: 1.7;
            margin: 1.8rem 0 2.5rem;
            max-width: 440px;
            animation: fadeUp 0.7s 0.2s ease both;
        }

        .hero-cta {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            animation: fadeUp 0.7s 0.3s ease both;
        }

        .btn-primary {
            background: var(--dark);
            color: #fff;
            padding: 1rem 2.2rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            transition: background 0.2s, transform 0.50s;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }
        .btn-primary:hover { background: var(--mid); transform: translateY(-2px); }

        .social-proof {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatars {
            display: flex;
        }
        .avatars span {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 2.5px solid var(--cream);
            background: var(--orange);
            margin-left: -10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 800;
            color: #fff;
            overflow: hidden;
        }
        .avatars span:first-child { margin-left: 0; }
        .avatars span img { width: 100%; height: 100%; object-fit: cover; }

        .proof-text { font-size: 0.82rem; font-weight: 600; color: var(--mid); line-height: 1.4; }
        .proof-text strong { color: var(--dark); display: block; }

        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.9s 0.15s ease both;
        }

        .hero-img-wrap {
            position: relative;
            width: 90%;
            max-width: 540px;
        }

        .hero-img-wrap img {
            width: 100%;
            height: 580px;
            object-fit: cover;
            border-radius: 40% 60% 60% 40% / 40% 40% 60% 60%;
            display: block;
            box-shadow: 0 30px 80px rgba(26,15,10,0.2);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-18px); }
        }

        .hero-chip {
            position: absolute;
            background: #fff;
            border-radius: 20px;
            padding: 0.75rem 1.2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .hero-chip.chip-1 {
            top: 12%;
            left: -10%;
            animation: float 6s 1s ease-in-out infinite;
        }

        .hero-chip.chip-2 {
            bottom: 18%;
            right: -5%;
            animation: float 6s 2s ease-in-out infinite;
        }

        .chip-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(244,82,30,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .chip-label { color: var(--muted); font-size: 0.7rem; font-weight: 500; }

        /* ---- TICKER ---- */
        .ticker-bar {
            background: var(--dark);
            color: var(--cream);
            overflow: hidden;
            padding: 0.9rem 0;
        }

        .ticker-inner {
            display: flex;
            gap: 3rem;
            animation: ticker 25s linear infinite;
            width: max-content;
        }

        .ticker-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.05rem;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .ticker-dot { color: var(--orange); font-size: 1.2rem; }

        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* ---- STATS ROW ---- */
        .stats-row {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 6%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); }

        .stat-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            line-height: 1;
            color: var(--orange);
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--muted);
            margin-top: 0.4rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ---- MENU SECTION ---- */
        .menu-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 6% 5rem;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 0.6rem;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .section-sub { color: var(--muted); font-size: 1rem; margin-bottom: 3rem; }

        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .filter-tabs {
            display: flex;
            background: rgba(0,0,0,0.05);
            padding: 5px;
            border-radius: 14px;
            gap: 4px;
        }

        .filter-tab {
            padding: 0.55rem 1.3rem;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            background: transparent;
            color: var(--mid);
            transition: all 0.2s;
            letter-spacing: 0.05em;
        }

        .filter-tab.active {
            background: #fff;
            color: var(--dark);
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }

        .filter-tab:hover:not(.active) { color: var(--orange); }

        /* ---- DISH CARDS ---- */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.8rem;
        }

        .dish-card {
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .dish-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 70px rgba(244,82,30,0.15);
        }

        .dish-img-wrap {
            position: relative;
            overflow: hidden;
        }

        .dish-img-wrap img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .dish-card:hover .dish-img-wrap img { transform: scale(1.08); }

        .dish-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--dark);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .dish-rating {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255,255,255,0.93);
            backdrop-filter: blur(10px);
            font-size: 0.78rem;
            font-weight: 800;
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .dish-body { padding: 1.5rem; }

        .dish-category {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 0.4rem;
        }

        .dish-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
            margin-bottom: 0.4rem;
        }

        .dish-desc {
            font-size: 0.83rem;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 1.2rem;
        }

        .dish-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dish-price {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            color: var(--dark);
            letter-spacing: 1px;
        }

        .add-btn {
            width: 46px; height: 46px;
            border-radius: 14px;
            background: var(--orange);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.15s;
            box-shadow: 0 6px 20px rgba(244,82,30,0.4);
            color: #fff;
        }

        .add-btn:hover { background: var(--orange-light); transform: scale(1.1); }
        .add-btn:active { transform: scale(0.95); }

        .add-btn svg { width: 20px; height: 20px; }

        /* ---- FEATURED BANNER ---- */
        .feature-banner {
            max-width: 1400px;
            margin: 0 auto 5rem;
            padding: 0 6%;
        }

        .feature-inner {
            background: var(--dark);
            border-radius: 32px;
            padding: 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .feature-inner::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(244,82,30,0.25) 0%, transparent 70%);
            top: -100px; right: -100px;
            pointer-events: none;
        }

        .feature-tag {
            display: inline-block;
            background: rgba(244,82,30,0.2);
            color: var(--orange);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            border: 1px solid rgba(244,82,30,0.3);
            margin-bottom: 1.2rem;
        }

        .feature-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            color: #fff;
            line-height: 1;
            margin-bottom: 1rem;
        }

        .feature-title span {
            color: var(--orange);
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }

        .feature-desc { color: rgba(255,255,255,0.55); font-size: 0.95rem; line-height: 1.7; margin-bottom: 2rem; }

        .btn-white {
            background: #fff;
            color: var(--dark);
            padding: 0.9rem 2rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.15s;
        }
        .btn-white:hover { transform: translateY(-2px); }

        .feature-img img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            border-radius: 24px;
            box-shadow: 0 30px 70px rgba(0,0,0,0.4);
        }

        /* ---- TOAST ---- */
        .toast {
            position: fixed;
            top: 88px;
            right: 24px;
            z-index: 9998;
            background: #22c55e;
            color: #fff;
            padding: 1rem 1.6rem;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 10px 40px rgba(34,197,94,0.4);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transform: translateX(140%);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toast.show { transform: translateX(0); }

        /* ---- FOOTER ---- */
        footer {
            background: var(--dark);
            color: rgba(255,255,255,0.6);
            padding: 5rem 6% 2.5rem;
        }

        .footer-inner {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .footer-brand .logo { color: #fff; }
        .footer-brand p { margin-top: 1rem; font-size: 0.88rem; line-height: 1.8; max-width: 280px; }

        .footer-col h5 {
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 1.5rem;
        }

        .footer-col ul { list-style: none; }
        .footer-col li { margin-bottom: 0.9rem; }
        .footer-col a {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.88rem;
            transition: color 0.2s;
        }
        .footer-col a:hover { color: var(--orange); }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
        }

        /* ---- ANIMATIONS ---- */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ---- RESPONSIVE ---- */
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; text-align: center; padding-top: 2rem; }
            .hero-visual { display: none; }
            .hero-cta { justify-content: center; flex-wrap: wrap; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .menu-grid { grid-template-columns: 1fr 1fr; }
            .feature-inner { grid-template-columns: 1fr; }
            .feature-img { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .nav-links { display: none; }
        }

        @media (max-width: 600px) {
            .menu-grid { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Toast -->
    <div class="toast" id="toast">
        <span>✅</span>
        <span id="toast-text">Item added!</span>
    </div>

    <!-- Navbar -->
    <nav>
        <div class="nav-inner">
            <a href="#" class="logo"><span>FAST</span>BITE</a>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="{{ route('login') }}" class="btn-order">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero -->
    <section id="home">
        <div class="hero">
            <div class="hero-text">
                <div class="badge">
                    <span class="badge-dot"></span>
                    Now open in your city
                </div>
                <h1 class="hero-headline">
                    Flavor
                    <span class="accent">Unleashed.</span>
                </h1>
                <p class="hero-sub">The best chefs in the city, delivered to your door in under 30 minutes. Fresh, fast, and unforgettable.</p>
                <div class="hero-cta">
                    <a href="#menu" class="btn-primary">
                        Explore Menu
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <div class="social-proof">
                        <div class="avatars">
                            <span><img src="https://i.pravatar.cc/40?img=1" alt=""></span>
                            <span><img src="https://i.pravatar.cc/40?img=5" alt=""></span>
                            <span><img src="https://i.pravatar.cc/40?img=9" alt=""></span>
                            <span style="background:var(--orange);font-size:0.6rem;">4.9★</span>
                        </div>
                        <div class="proof-text">
                            <strong>10k+ Happy Foodies</strong>
                            Join our growing community
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-img-wrap">
                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=85" alt="Hero Food">
                    <div class="hero-chip chip-1">
                        <div class="chip-icon">⚡</div>
                        <div>
                            <div style="font-weight:700;font-size:0.9rem;">30 min</div>
                            <div class="chip-label">Avg. Delivery</div>
                        </div>
                    </div>
                    <div class="hero-chip chip-2">
                        <div class="chip-icon">🍕</div>
                        <div>
                            <div style="font-weight:700;font-size:0.9rem;">200+ Dishes</div>
                            <div class="chip-label">On the menu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ticker -->
    <div class="ticker-bar">
        <div class="ticker-inner" id="ticker">
            <span class="ticker-item"><span class="ticker-dot">●</span> Fresh Ingredients Daily</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> 30 Minute Delivery</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> 200+ Menu Items</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> Top Rated Chefs</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> Zero Compromise Quality</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> Contactless Delivery</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> Fresh Ingredients Daily</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> 30 Minute Delivery</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> 200+ Menu Items</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> Top Rated Chefs</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> Zero Compromise Quality</span>
            <span class="ticker-item"><span class="ticker-dot">●</span> Contactless Delivery</span>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card reveal">
            <div class="stat-num">10K+</div>
            <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-card reveal" style="transition-delay:0.1s">
            <div class="stat-num">200+</div>
            <div class="stat-label">Dishes Available</div>
        </div>
        <div class="stat-card reveal" style="transition-delay:0.2s">
            <div class="stat-num">4.9★</div>
            <div class="stat-label">Average Rating</div>
        </div>
        <div class="stat-card reveal" style="transition-delay:0.3s">
            <div class="stat-num">&lt;30</div>
            <div class="stat-label">Minutes Delivery</div>
        </div>
    </div>

    <!-- Menu Section -->
    <section id="menu" class="menu-section">
        <div class="menu-header">
            <div class="reveal">
                <div class="section-label">Our Menu</div>
                <h2 class="section-title">Popular Dishes</h2>
                <p class="section-sub">Hand-picked favorites by our community</p>
            </div>
            <div class="filter-tabs reveal">
                <button class="filter-tab active" onclick="filterMenu(this,'all')">All</button>
                <button class="filter-tab" onclick="filterMenu(this,'pizza')">Pizza</button>
                <button class="filter-tab" onclick="filterMenu(this,'burger')">Burgers</button>
                <button class="filter-tab" onclick="filterMenu(this,'sushi')">Sushi</button>
            </div>
        </div>

        <div class="menu-grid" id="menu-grid">

            <div class="dish-card reveal" data-category="pizza">
                <div class="dish-img-wrap">
                    <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=700&q=80" alt="Truffle Pizza">
                    <div class="dish-badge">Chef's Pick</div>
                    <div class="dish-rating">⭐ 4.8</div>
                </div>
                <div class="dish-body">
                    <div class="dish-category">Pizza</div>
                    <div class="dish-name">Truffle Pizza</div>
                    <div class="dish-desc">Wild mushrooms, truffle oil, and hand-pulled mozzarella on a thin crust.</div>
                    <div class="dish-footer">
                        <div class="dish-price">$18</div>
                        <button class="add-btn" onclick="addToCart('Truffle Pizza', 18)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="dish-card reveal" data-category="burger" style="transition-delay:0.1s">
                <div class="dish-img-wrap">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=700&q=80" alt="Smash Burger">
                    <div class="dish-badge">Best Seller</div>
                    <div class="dish-rating">⭐ 4.9</div>
                </div>
                <div class="dish-body">
                    <div class="dish-category">Burger</div>
                    <div class="dish-name">Double Smash</div>
                    <div class="dish-desc">Two crispy smash patties, aged cheddar, caramelized onions, and secret sauce.</div>
                    <div class="dish-footer">
                        <div class="dish-price">$14</div>
                        <button class="add-btn" onclick="addToCart('Double Smash Burger', 14)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="dish-card reveal" data-category="sushi" style="transition-delay:0.2s">
                <div class="dish-img-wrap">
                    <img src="https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?auto=format&fit=crop&w=700&q=80" alt="Dragon Roll">
                    <div class="dish-badge">New</div>
                    <div class="dish-rating">⭐ 4.7</div>
                </div>
                <div class="dish-body">
                    <div class="dish-category">Sushi</div>
                    <div class="dish-name">Dragon Roll</div>
                    <div class="dish-desc">Avocado-topped tempura shrimp roll with spicy mayo and eel sauce.</div>
                    <div class="dish-footer">
                        <div class="dish-price">$22</div>
                        <button class="add-btn" onclick="addToCart('Dragon Roll', 22)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="dish-card reveal" data-category="pizza" style="transition-delay:0.05s">
                <div class="dish-img-wrap">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=700&q=80" alt="Margherita">
                    <div class="dish-rating">⭐ 4.6</div>
                </div>
                <div class="dish-body">
                    <div class="dish-category">Pizza</div>
                    <div class="dish-name">Classic Margherita</div>
                    <div class="dish-desc">San Marzano tomato, fresh basil, and buffalo mozzarella on a wood-fired base.</div>
                    <div class="dish-footer">
                        <div class="dish-price">$15</div>
                        <button class="add-btn" onclick="addToCart('Classic Margherita', 15)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="dish-card reveal" data-category="burger" style="transition-delay:0.15s">
                <div class="dish-img-wrap">
                    <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=700&q=80" alt="BBQ Burger">
                    <div class="dish-rating">⭐ 4.8</div>
                </div>
                <div class="dish-body">
                    <div class="dish-category">Burger</div>
                    <div class="dish-name">Smoky BBQ</div>
                    <div class="dish-desc">Slow-cooked pulled pork, jalapeño slaw, smoked gouda, and hickory BBQ.</div>
                    <div class="dish-footer">
                        <div class="dish-price">$16</div>
                        <button class="add-btn" onclick="addToCart('Smoky BBQ Burger', 16)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Feature Banner -->
    <div class="feature-banner">
        <div class="feature-inner reveal">
            <div>
                <div class="feature-tag">🔥 Limited Time Offer</div>
                <h3 class="feature-title">Get Your First<br><span>Delivery Free</span></h3>
                <p class="feature-desc">New to FastBite? Your first order ships on us. No minimum spend, no catch. Just incredible food at your door.</p>
                <a href="#" class="btn-white">Claim Free Delivery →</a>
            </div>
            <div class="feature-img">
                <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=800&q=85" alt="Food spread">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#" class="logo"><span>FAST</span>BITE</a>
                    <p>Revolutionizing urban dining by bringing the city's finest kitchens directly to your doorstep. Fast, fresh, unforgettable.</p>
                </div>
                <div class="footer-col">
                    <h5>Explore</h5>
                    <ul>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Latest Menu</a></li>
                        <li><a href="#">Partner With Us</a></li>
                        <li><a href="#">Rewards</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Get the App</h5>
                    <ul>
                        <li><a href="#">iOS App</a></li>
                        <li><a href="#">Android App</a></li>
                        <li><a href="#">Track Your Order</a></li>
                        <li><a href="#">Gift Cards</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© 2026 FastBite. All rights reserved.</span>
                <span style="color:rgba(255,255,255,0.3)">Made with ❤️ for food lovers</span>
            </div>
        </div>
    </footer>

    <script>
        // Toast
        function addToCart(name, price) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-text').textContent = `${name} added!`;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // Filter tabs
        function filterMenu(btn, category) {
            document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.querySelectorAll('.dish-card').forEach(card => {
                const match = category === 'all' || card.dataset.category === category;
                card.style.opacity = match ? '1' : '0.25';
                card.style.pointerEvents = match ? 'auto' : 'none';
                card.style.transform = match ? '' : 'scale(0.97)';
                card.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
            });
        }

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
