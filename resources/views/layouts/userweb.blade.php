<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FastBite × Mix Follow | Flavor Unleashed</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
<style>
:root {
    --orange: #F4521E;
    --orange-light: #FF7A47;
    --cream: #FFF5EE;
    --dark: #1A0F0A;
    --mid: #3D2B1F;
    --muted: #9B8880;
    --mix-purple: #7C3AED;
    --mix-purple-light: #A78BFA;
    --mix-gradient: linear-gradient(135deg, #7C3AED 0%, #F4521E 100%);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { background-color: var(--cream); color: var(--dark); font-family: 'DM Sans', sans-serif; overflow-x: hidden; }
body::before { content: ''; position: fixed; inset: 0; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.035'/%3E%3C/svg%3E"); pointer-events: none; z-index: 9999; opacity: 0.4; }
::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--cream); }
::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }

/* ─── MIX STRIP ─── */
.mix-strip {
    background: var(--mix-gradient);
    padding: 0.6rem 4%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.mix-strip::after { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(255,255,255,0.04) 60px, rgba(255,255,255,0.04) 61px); pointer-events: none; }
.mix-strip-pill { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 0.2rem 0.7rem; border-radius: 50px; font-size: 0.62rem; font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; flex-shrink: 0; position: relative; z-index: 1; white-space: nowrap; }
.mix-strip-text { color: rgba(255,255,255,0.92); font-size: 0.76rem; font-weight: 500; position: relative; z-index: 1; text-align: center; line-height: 1.4; }
.mix-strip-text strong { color: #fff; font-weight: 800; }
.mix-strip-btn { background: #fff; color: var(--mix-purple); padding: 0.28rem 0.9rem; border-radius: 50px; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; text-decoration: none; flex-shrink: 0; position: relative; z-index: 1; white-space: nowrap; }
.mix-strip-sep { display: none; }

/* ─── NAV ─── */
nav { position: sticky; top: 0; z-index: 100; background: rgba(255,245,238,0.92); backdrop-filter: blur(24px); border-bottom: 1px solid rgba(244,82,30,0.12); padding: 0 4%; }
.nav-inner { max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { font-family: 'Bebas Neue', sans-serif; font-size: 1.7rem; letter-spacing: 2px; text-decoration: none; color: var(--dark); white-space: nowrap; }
.logo span { color: var(--orange); }
.nav-mix-badge { display: inline-flex; align-items: center; gap: 0.3rem; background: var(--mix-gradient); color: #fff; padding: 0.15rem 0.55rem; border-radius: 50px; font-size: 0.55rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; margin-left: 0.4rem; vertical-align: middle; }
.nav-links { display: flex; align-items: center; gap: 2rem; list-style: none; }
.nav-links a { text-decoration: none; color: var(--mid); font-weight: 600; font-size: 0.8rem; letter-spacing: 0.12em; text-transform: uppercase; transition: color 0.2s; }
.nav-links a:hover { color: var(--orange); }
.nav-links a.mix-nav { color: var(--mix-purple); }
.btn-order { background: var(--orange); color: #fff !important; padding: 0.55rem 1.3rem; border-radius: 50px; font-weight: 700 !important; box-shadow: 0 4px 20px rgba(244,82,30,0.35); transition: background 0.2s, transform 0.15s !important; }
.btn-order:hover { background: var(--orange-light) !important; transform: translateY(-2px); }

/* Hamburger */
.hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 6px; border: none; background: transparent; }
.hamburger span { display: block; width: 22px; height: 2px; background: var(--dark); border-radius: 2px; transition: all 0.3s; }
.hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* Mobile nav drawer */
.mobile-nav { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: var(--cream); z-index: 200; flex-direction: column; align-items: center; justify-content: center; gap: 2rem; }
.mobile-nav.open { display: flex; }
.mobile-nav a { font-family: 'Bebas Neue', sans-serif; font-size: 2.2rem; letter-spacing: 2px; text-decoration: none; color: var(--dark); transition: color 0.2s; }
.mobile-nav a:hover, .mobile-nav a.mix-nav { color: var(--mix-purple); }
.mobile-nav a.mix-nav { color: var(--mix-purple); }
.mobile-nav .close-nav { position: absolute; top: 20px; right: 20px; font-size: 1.6rem; cursor: pointer; background: none; border: none; color: var(--dark); }
.mobile-nav .btn-order-mobile { background: var(--orange); color: #fff; padding: 0.9rem 2.5rem; border-radius: 50px; font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 700; letter-spacing: 0; text-decoration: none; }

/* ─── HERO ─── */
.hero { min-height: calc(100svh - 100px); display: grid; grid-template-columns: 1fr 1fr; max-width: 1400px; margin: 0 auto; padding: 3rem 6% 2rem; align-items: center; gap: 2rem; }
.hero-text { position: relative; z-index: 2; }
.hero-mix-pill { display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(244,82,30,0.1)); border: 1px solid rgba(124,58,237,0.2); color: var(--mix-purple); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.72rem; font-weight: 700; margin-bottom: 0.8rem; animation: fadeUp 0.7s ease both; text-decoration: none; transition: background 0.2s; }
.hero-mix-pill:hover { background: linear-gradient(135deg, rgba(124,58,237,0.18), rgba(244,82,30,0.18)); }
.badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(244,82,30,0.1); border: 1px solid rgba(244,82,30,0.25); color: var(--orange); padding: 0.4rem 0.9rem; border-radius: 50px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1.2rem; animation: fadeUp 0.7s 0.05s ease both; }
.badge-dot { width: 7px; height: 7px; background: var(--orange); border-radius: 50%; animation: pulse 1.5s infinite; }
.hero-headline { font-family: 'Bebas Neue', sans-serif; font-size: clamp(4rem, 10vw, 9rem); line-height: 0.92; letter-spacing: 1px; animation: fadeUp 0.7s 0.1s ease both; }
.hero-headline .accent { color: var(--orange); font-family: 'Playfair Display', serif; font-style: italic; font-size: 0.85em; display: block; }
.hero-sub { color: var(--muted); font-size: 1rem; line-height: 1.7; margin: 1.4rem 0 2rem; max-width: 440px; animation: fadeUp 0.7s 0.2s ease both; }
.hero-cta { display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap; animation: fadeUp 0.7s 0.3s ease both; }
.btn-primary { background: var(--dark); color: #fff; padding: 0.9rem 1.8rem; border-radius: 14px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: background 0.2s, transform 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
.btn-primary:hover { background: var(--mid); transform: translateY(-2px); }
.btn-mix-hero { background: var(--mix-gradient); color: #fff; padding: 0.9rem 1.6rem; border-radius: 14px; font-weight: 700; font-size: 0.88rem; text-decoration: none; transition: opacity 0.2s, transform 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 6px 24px rgba(124,58,237,0.3); }
.btn-mix-hero:hover { opacity: 0.9; transform: translateY(-2px); }
.hero-visual { position: relative; display: flex; justify-content: center; align-items: center; animation: fadeIn 0.9s 0.15s ease both; }
.hero-img-wrap { position: relative; width: 90%; max-width: 540px; }
.hero-img-wrap img { width: 100%; height: 500px; object-fit: cover; border-radius: 40% 60% 60% 40% / 40% 40% 60% 60%; display: block; box-shadow: 0 30px 80px rgba(26,15,10,0.2); animation: float 6s ease-in-out infinite; }
.hero-chip { position: absolute; background: #fff; border-radius: 16px; padding: 0.65rem 1rem; box-shadow: 0 8px 30px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 0.65rem; font-size: 0.8rem; font-weight: 600; }
.hero-chip.chip-1 { top: 12%; left: -10%; animation: float 6s 1s ease-in-out infinite; }
.hero-chip.chip-2 { bottom: 18%; right: -5%; animation: float 6s 2s ease-in-out infinite; }
.hero-chip.chip-3 { top: 45%; left: -16%; animation: float 6s 3s ease-in-out infinite; }
.chip-icon { width: 38px; height: 38px; border-radius: 10px; background: rgba(244,82,30,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
.chip-icon.mix { background: linear-gradient(135deg, rgba(124,58,237,0.15), rgba(244,82,30,0.1)); }
.chip-label { color: var(--muted); font-size: 0.67rem; font-weight: 500; }

/* ─── TICKER ─── */
.ticker-bar { background: var(--dark); color: var(--cream); overflow: hidden; padding: 0.85rem 0; }
.ticker-inner { display: flex; gap: 3rem; animation: ticker 30s linear infinite; width: max-content; }
.ticker-item { display: flex; align-items: center; gap: 0.6rem; font-family: 'Bebas Neue', sans-serif; font-size: 1rem; letter-spacing: 2px; white-space: nowrap; }
.ticker-dot { color: var(--orange); font-size: 1rem; }
.ticker-dot.mix { color: var(--mix-purple-light); }

/* ─── STATS ─── */
.stats-row { max-width: 1400px; margin: 0 auto; padding: 3rem 4%; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem; }
.stat-card { background: #fff; border-radius: 20px; padding: 1.6rem; border: 1px solid rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; }
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); }
.stat-card.mix-stat { background: linear-gradient(135deg, rgba(124,58,237,0.05), rgba(244,82,30,0.05)); border-color: rgba(124,58,237,0.12); }
.stat-num { font-family: 'Bebas Neue', sans-serif; font-size: 3rem; line-height: 1; color: var(--orange); }
.stat-num.mix { background: var(--mix-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.stat-label { font-size: 0.78rem; font-weight: 600; color: var(--muted); margin-top: 0.3rem; letter-spacing: 0.04em; text-transform: uppercase; }
.stat-sub { font-size: 0.67rem; color: var(--mix-purple); font-weight: 600; margin-top: 0.25rem; }

/* ─── MIX HERO BAND ─── */
.mix-hero-band { background: var(--mix-gradient); position: relative; overflow: hidden; padding: 4rem 6%; }
.mix-hero-band::before { content: ''; position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); top: -200px; right: -100px; pointer-events: none; }
.mix-hero-band::after { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(45deg, transparent, transparent 30px, rgba(255,255,255,0.02) 30px, rgba(255,255,255,0.02) 31px); pointer-events: none; }
.mix-hero-band-inner { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 1fr auto; align-items: center; gap: 3rem; position: relative; z-index: 1; }
.mix-hero-band-label { font-size: 0.7rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgba(255,255,255,0.7); margin-bottom: 0.7rem; display: flex; align-items: center; gap: 0.5rem; }
.mix-hero-band-label::before { content: ''; display: inline-block; width: 20px; height: 1px; background: rgba(255,255,255,0.4); }
.mix-hero-band-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2rem, 5vw, 3.8rem); color: #fff; line-height: 1; margin-bottom: 0.8rem; letter-spacing: 1px; }
.mix-hero-band-sub { color: rgba(255,255,255,0.72); font-size: 0.92rem; line-height: 1.7; max-width: 580px; }
.mix-hero-band-actions { display: flex; flex-direction: column; gap: 0.8rem; align-items: stretch; flex-shrink: 0; min-width: 200px; }
.mix-btn-white { background: #fff; color: var(--mix-purple); padding: 0.85rem 1.6rem; border-radius: 14px; font-weight: 800; font-size: 0.88rem; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: opacity 0.2s, transform 0.15s; box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
.mix-btn-white:hover { opacity: 0.95; transform: translateY(-2px); }
.mix-btn-ghost { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 0.85rem 1.6rem; border-radius: 14px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background 0.2s, transform 0.15s; }
.mix-btn-ghost:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); }
.mix-hero-band-stats { display: flex; gap: 2rem; margin-top: 2rem; flex-wrap: wrap; }
.mix-hero-stat-num { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; color: #fff; line-height: 1; }
.mix-hero-stat-label { font-size: 0.68rem; font-weight: 600; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.07em; }

/* ─── SECTION HELPERS ─── */
.section-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: var(--orange); margin-bottom: 0.6rem; }
.section-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.2rem, 8vw, 4.5rem); line-height: 1; margin-bottom: 0.4rem; }
.section-sub { color: var(--muted); font-size: 0.95rem; }
.mix-section-eyebrow { display: inline-block; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: var(--mix-purple); margin-bottom: 0.6rem; background: rgba(124,58,237,0.08); border: 1px solid rgba(124,58,237,0.15); padding: 0.32rem 0.8rem; border-radius: 50px; }

/* ─── PERKS ─── */
.perks-section { max-width: 1400px; margin: 0 auto; padding: 4rem 4%; }
.perks-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem; margin-top: 2rem; }
.perk-card { background: #fff; border-radius: 20px; padding: 1.8rem 1.4rem; border: 1px solid rgba(0,0,0,0.05); text-align: center; transition: transform 0.2s, box-shadow 0.2s; position: relative; overflow: hidden; }
.perk-card::before { content: ''; position: absolute; bottom: -30px; right: -30px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(124,58,237,0.07) 0%, transparent 70%); pointer-events: none; }
.perk-card:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(124,58,237,0.1); }
.perk-icon { font-size: 2rem; margin-bottom: 0.8rem; display: block; }
.perk-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
.perk-desc { font-size: 0.8rem; color: var(--muted); line-height: 1.6; }

/* ─── HOW IT WORKS ─── */
.how-section { max-width: 1400px; margin: 0 auto; padding: 0 4% 4rem; }
.how-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem; position: relative; }
.how-grid::before { content: ''; position: absolute; top: 46px; left: calc(16.66% + 1rem); right: calc(16.66% + 1rem); height: 1px; background: linear-gradient(90deg, var(--mix-purple), var(--orange)); opacity: 0.25; }
.how-card { background: #fff; border-radius: 20px; padding: 2rem 1.6rem; border: 1px solid rgba(0,0,0,0.05); text-align: center; }
.how-num { width: 50px; height: 50px; border-radius: 50%; background: var(--mix-gradient); color: #fff; font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; box-shadow: 0 6px 24px rgba(124,58,237,0.35); }
.how-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; margin-bottom: 0.5rem; }
.how-desc { font-size: 0.82rem; color: var(--muted); line-height: 1.7; }

/* ─── MENU ─── */
.menu-section { max-width: 1400px; margin: 0 auto; padding: 2rem 4% 4rem; }
.menu-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1.2rem; }
.filter-tabs { display: flex; background: rgba(0,0,0,0.05); padding: 4px; border-radius: 12px; gap: 3px; flex-wrap: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: none; max-width: 100%; }
.filter-tabs::-webkit-scrollbar { display: none; }
.filter-tab { padding: 0.5rem 1rem; border-radius: 9px; font-size: 0.78rem; font-weight: 700; cursor: pointer; border: none; background: transparent; color: var(--mid); transition: all 0.2s; letter-spacing: 0.04em; white-space: nowrap; flex-shrink: 0; }
.filter-tab.active { background: #fff; color: var(--dark); box-shadow: 0 2px 12px rgba(0,0,0,0.1); }
.filter-tab:hover:not(.active) { color: var(--orange); }
.filter-tab.mix-tab.active { background: var(--mix-gradient); color: #fff; box-shadow: 0 4px 16px rgba(124,58,237,0.3); }
.menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.dish-card { background: #fff; border-radius: 24px; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
.dish-card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(244,82,30,0.12); }
.dish-card.mix-exclusive { border-color: rgba(124,58,237,0.2); }
.dish-card.mix-exclusive:hover { box-shadow: 0 24px 60px rgba(124,58,237,0.15); }
.dish-img-wrap { position: relative; overflow: hidden; }
.dish-img-wrap img { width: 100%; height: 220px; object-fit: cover; display: block; transition: transform 0.5s ease; }
.dish-card:hover .dish-img-wrap img { transform: scale(1.07); }
.dish-badge { position: absolute; top: 10px; left: 10px; background: var(--dark); color: #fff; font-size: 0.65rem; font-weight: 700; padding: 0.28rem 0.7rem; border-radius: 50px; letter-spacing: 0.08em; text-transform: uppercase; }
.dish-badge.mix { background: var(--mix-gradient); }
.dish-rating { position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.93); backdrop-filter: blur(10px); font-size: 0.75rem; font-weight: 800; padding: 0.3rem 0.7rem; border-radius: 50px; }
.dish-body { padding: 1.3rem; }
.dish-category { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--orange); margin-bottom: 0.35rem; }
.dish-category.mix { color: var(--mix-purple); }
.dish-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.5px; margin-bottom: 0.35rem; }
.dish-desc { font-size: 0.8rem; color: var(--muted); line-height: 1.5; margin-bottom: 1rem; }
.dish-footer { display: flex; align-items: center; justify-content: space-between; }
.dish-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--dark); letter-spacing: 1px; }
.dish-price-mix { font-size: 0.65rem; font-weight: 700; color: var(--mix-purple); display: block; letter-spacing: 0.06em; }
.add-btn { width: 42px; height: 42px; border-radius: 12px; background: var(--orange); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s, transform 0.15s; box-shadow: 0 6px 18px rgba(244,82,30,0.4); color: #fff; flex-shrink: 0; }
.add-btn:hover { background: var(--orange-light); transform: scale(1.1); }
.add-btn.mix { background: var(--mix-gradient); box-shadow: 0 6px 18px rgba(124,58,237,0.35); }
.add-btn svg { width: 18px; height: 18px; }

/* ─── TESTIMONIALS ─── */
.testimonials-section { background: var(--dark); padding: 4rem 4%; }
.testimonials-inner { max-width: 1400px; margin: 0 auto; }
.testimonials-label { font-size: 0.68rem; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: var(--mix-purple-light); margin-bottom: 0.6rem; }
.testimonials-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2rem, 6vw, 3.5rem); color: #fff; margin-bottom: 2.5rem; line-height: 1; }
.testimonials-title span { color: var(--orange); font-family: 'Playfair Display', serif; font-style: italic; }
.testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }
.testi-card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.8rem; transition: border-color 0.2s; }
.testi-card:hover { border-color: rgba(124,58,237,0.35); }
.testi-stars { color: #FBBF24; font-size: 0.82rem; margin-bottom: 0.9rem; letter-spacing: 2px; }
.testi-text { color: rgba(255,255,255,0.75); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.4rem; }
.testi-author { display: flex; align-items: center; gap: 0.8rem; }
.testi-avatar { width: 38px; height: 38px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
.testi-avatar img { width: 100%; height: 100%; object-fit: cover; }
.testi-name { font-size: 0.83rem; font-weight: 700; color: #fff; }
.testi-via { font-size: 0.7rem; color: var(--mix-purple-light); font-weight: 600; }

/* ─── REWARDS ─── */
.rewards-section { max-width: 1400px; margin: 4rem auto; padding: 0 4%; }
.rewards-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
.rewards-card-stack { position: relative; height: 380px; }
.reward-card-bg { position: absolute; width: 90%; height: 200px; border-radius: 24px; top: 15px; left: 5%; background: linear-gradient(135deg, #5B21B6, #7C3AED); transform: rotate(-3deg); opacity: 0.5; }
.reward-card-mid { position: absolute; width: 90%; height: 200px; border-radius: 24px; top: 8px; left: 5%; background: linear-gradient(135deg, #6D28D9, var(--mix-purple)); transform: rotate(-1.5deg); opacity: 0.7; }
.reward-card-front { position: absolute; width: 90%; border-radius: 24px; top: 0; left: 5%; background: var(--mix-gradient); padding: 1.8rem; box-shadow: 0 20px 60px rgba(124,58,237,0.4); }
.reward-card-logo { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; color: rgba(255,255,255,0.9); letter-spacing: 2px; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.4rem; }
.reward-card-logo span { color: rgba(255,255,255,0.6); font-size: 0.85rem; }
.reward-card-points { font-family: 'Bebas Neue', sans-serif; font-size: 2.8rem; color: #fff; line-height: 1; }
.reward-card-points-label { font-size: 0.68rem; font-weight: 600; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.1em; }
.reward-card-bottom { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 1.3rem; padding-top: 1.3rem; border-top: 1px solid rgba(255,255,255,0.15); }
.reward-card-name { font-size: 0.8rem; font-weight: 700; color: rgba(255,255,255,0.8); }
.reward-card-tier { background: rgba(255,255,255,0.2); color: #fff; padding: 0.18rem 0.65rem; border-radius: 50px; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; }
.reward-mini-cards { position: absolute; bottom: 0; left: 0; right: 0; display: flex; gap: 0.8rem; }
.reward-mini { flex: 1; background: #fff; border-radius: 16px; padding: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.05); text-align: center; }
.reward-mini-icon { font-size: 1.3rem; margin-bottom: 0.4rem; display: block; }
.reward-mini-title { font-size: 0.7rem; font-weight: 700; color: var(--dark); margin-bottom: 0.15rem; }
.reward-mini-sub { font-size: 0.6rem; color: var(--muted); }
.rewards-eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: var(--mix-purple); margin-bottom: 0.9rem; background: rgba(124,58,237,0.08); border: 1px solid rgba(124,58,237,0.15); padding: 0.3rem 0.85rem; border-radius: 50px; }
.rewards-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.2rem, 5vw, 4rem); line-height: 1; margin-bottom: 0.9rem; }
.rewards-title span { color: var(--orange); font-family: 'Playfair Display', serif; font-style: italic; }
.rewards-desc { color: var(--muted); font-size: 0.92rem; line-height: 1.75; margin-bottom: 1.8rem; }
.rewards-list { list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem; }
.rewards-list li { display: flex; align-items: flex-start; gap: 0.8rem; }
.rewards-list-icon { width: 32px; height: 32px; border-radius: 9px; background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(244,82,30,0.08)); display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; margin-top: 1px; }
.rewards-list-text { font-size: 0.86rem; color: var(--mid); line-height: 1.6; }
.rewards-list-text strong { color: var(--dark); display: block; font-size: 0.88rem; margin-bottom: 0.1rem; }
.btn-mix-primary { display: inline-flex; align-items: center; gap: 0.6rem; background: var(--mix-gradient); color: #fff; padding: 0.95rem 2rem; border-radius: 14px; font-weight: 700; font-size: 0.92rem; text-decoration: none; transition: opacity 0.2s, transform 0.15s; box-shadow: 0 8px 28px rgba(124,58,237,0.35); }
.btn-mix-primary:hover { opacity: 0.9; transform: translateY(-2px); }

/* ─── FEATURE BANNER ─── */
.feature-banner { max-width: 1400px; margin: 0 auto 4rem; padding: 0 4%; }
.feature-inner { background: var(--dark); border-radius: 28px; padding: 3rem; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; overflow: hidden; position: relative; }
.feature-inner::before { content: ''; position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(244,82,30,0.25) 0%, transparent 70%); top: -100px; right: -100px; pointer-events: none; }
.feature-tag { display: inline-block; background: rgba(244,82,30,0.2); color: var(--orange); font-size: 0.7rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; padding: 0.35rem 0.9rem; border-radius: 50px; border: 1px solid rgba(244,82,30,0.3); margin-bottom: 1rem; }
.feature-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.2rem, 5vw, 3.5rem); color: #fff; line-height: 1; margin-bottom: 1rem; }
.feature-title span { color: var(--orange); font-family: 'Playfair Display', serif; font-style: italic; }
.feature-desc { color: rgba(255,255,255,0.55); font-size: 0.92rem; line-height: 1.7; margin-bottom: 1.8rem; }
.btn-white { background: #fff; color: var(--dark); padding: 0.85rem 1.8rem; border-radius: 13px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-block; transition: transform 0.15s; }
.btn-white:hover { transform: translateY(-2px); }
.feature-img img { width: 100%; height: 300px; object-fit: cover; border-radius: 20px; box-shadow: 0 30px 70px rgba(0,0,0,0.4); }

/* ─── TOAST ─── */
.toast { position: fixed; top: 100px; right: 16px; left: 16px; z-index: 9998; background: #22c55e; color: #fff; padding: 0.9rem 1.4rem; border-radius: 14px; font-weight: 600; font-size: 0.88rem; box-shadow: 0 10px 40px rgba(34,197,94,0.4); display: flex; align-items: center; gap: 0.6rem; transform: translateY(-120px); transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
.toast.show { transform: translateY(0); }

/* ─── FOOTER ─── */
footer { background: var(--dark); color: rgba(255,255,255,0.6); padding: 4rem 4% 2rem; }
.footer-inner { max-width: 1400px; margin: 0 auto; }
.footer-mix-cta { background: var(--mix-gradient); border-radius: 20px; padding: 2.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; margin-bottom: 3.5rem; position: relative; overflow: hidden; }
.footer-mix-cta::before { content: ''; position: absolute; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); top: -100px; right: 200px; pointer-events: none; }
.footer-mix-cta-text { position: relative; z-index: 1; }
.footer-mix-cta-eyebrow { font-size: 0.65rem; font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; color: rgba(255,255,255,0.65); margin-bottom: 0.4rem; }
.footer-mix-cta-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(1.4rem, 3vw, 2rem); color: #fff; line-height: 1.15; letter-spacing: 1px; }
.footer-mix-cta-actions { display: flex; gap: 0.8rem; position: relative; z-index: 1; flex-shrink: 0; }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2.5rem; margin-bottom: 3.5rem; }
.footer-brand .logo { color: #fff; }
.footer-brand p { margin-top: 0.9rem; font-size: 0.85rem; line-height: 1.8; max-width: 280px; color: rgba(255,255,255,0.5); }
.footer-col h5 { font-size: 0.75rem; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; color: #fff; margin-bottom: 1.3rem; }
.footer-col ul { list-style: none; }
.footer-col li { margin-bottom: 0.8rem; }
.footer-col a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.85rem; transition: color 0.2s; }
.footer-col a:hover { color: var(--orange); }
.footer-col a.mix-link:hover { color: var(--mix-purple-light); }
.footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.8rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; flex-wrap: wrap; gap: 0.6rem; }
.footer-mix-badge-bottom { background: var(--mix-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 800; }

/* ─── ANIMATIONS ─── */
@keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
@keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.1); } }
@keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
.reveal { opacity: 0; transform: translateY(36px); transition: opacity 0.65s ease, transform 0.65s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }

/* ═══════════════════════════════════════
   TABLET — 768px to 1024px
   ═══════════════════════════════════════ */
@media (max-width: 1024px) {
    .nav-links { gap: 1.5rem; }
    .nav-links a { font-size: 0.72rem; }
    .hero { padding: 2.5rem 4% 2rem; }
    .perks-grid { grid-template-columns: repeat(2, 1fr); }
    .testi-grid { grid-template-columns: 1fr 1fr; }
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    .stats-row { grid-template-columns: repeat(2, 1fr); }
}

/* ═══════════════════════════════════════
   MOBILE — under 768px
   ═══════════════════════════════════════ */
@media (max-width: 768px) {
    /* Nav */
    .nav-links { display: none; }
    .hamburger { display: flex; }
    .nav-inner { height: 56px; }
    .logo { font-size: 1.5rem; }
    .nav-mix-badge { display: none; }

    /* Mix strip */
    .mix-strip { padding: 0.55rem 4%; gap: 0.5rem; }
    .mix-strip-pill { font-size: 0.58rem; padding: 0.18rem 0.6rem; }
    .mix-strip-text { font-size: 0.7rem; }
    .mix-strip-btn { font-size: 0.62rem; padding: 0.24rem 0.75rem; }

    /* Hero — single column, centered */
    .hero {
        grid-template-columns: 1fr;
        min-height: auto;
        padding: 2rem 4% 2.5rem;
        text-align: center;
        gap: 0;
    }
    .hero-visual { display: none; }
    .hero-cta { justify-content: center; flex-direction: column; align-items: center; gap: 0.8rem; }
    .btn-primary, .btn-mix-hero { width: 100%; max-width: 300px; justify-content: center; }
    .hero-sub { margin-left: auto; margin-right: auto; font-size: 0.92rem; }
    .hero-mix-pill { font-size: 0.66rem; }

    /* Stats */
    .stats-row { grid-template-columns: 1fr 1fr; gap: 0.85rem; padding: 2rem 4%; }
    .stat-card { padding: 1.2rem; border-radius: 16px; }
    .stat-num { font-size: 2.4rem; }
    .stat-label { font-size: 0.7rem; }

    /* Mix band */
    .mix-hero-band { padding: 3rem 4%; }
    .mix-hero-band-inner { grid-template-columns: 1fr; gap: 2rem; }
    .mix-hero-band-actions { flex-direction: column; min-width: unset; }
    .mix-hero-band-stats { gap: 1.2rem; }
    .mix-hero-stat-num { font-size: 1.7rem; }

    /* Perks */
    .perks-section { padding: 3rem 4%; }
    .perks-grid { grid-template-columns: 1fr 1fr; gap: 0.9rem; }
    .perk-card { padding: 1.4rem 1rem; border-radius: 16px; }
    .perk-icon { font-size: 1.7rem; }
    .perk-title { font-size: 1rem; }
    .perk-desc { font-size: 0.75rem; }

    /* How */
    .how-section { padding: 0 4% 3rem; }
    .how-grid { grid-template-columns: 1fr; gap: 1rem; }
    .how-grid::before { display: none; }

    /* Menu */
    .menu-section { padding: 1.5rem 4% 3rem; }
    .menu-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .filter-tabs { width: 100%; }
    .filter-tab { padding: 0.45rem 0.85rem; font-size: 0.74rem; }
    .menu-grid { grid-template-columns: 1fr; gap: 1.2rem; }
    .dish-img-wrap img { height: 200px; }
    .dish-body { padding: 1.1rem; }
    .dish-name { font-size: 1.3rem; }

    /* Rewards */
    .rewards-section { margin: 2.5rem auto; padding: 0 4%; }
    .rewards-inner { grid-template-columns: 1fr; gap: 2.5rem; }
    .rewards-card-stack { height: 310px; }
    .reward-card-front { padding: 1.4rem; }
    .reward-card-logo { font-size: 1.1rem; margin-bottom: 0.9rem; }
    .reward-card-points { font-size: 2.2rem; }
    .reward-mini-cards { gap: 0.6rem; }
    .reward-mini { padding: 0.85rem 0.6rem; border-radius: 14px; }
    .reward-mini-icon { font-size: 1.1rem; }
    .reward-mini-title { font-size: 0.65rem; }
    .reward-mini-sub { font-size: 0.56rem; }

    /* Feature banner */
    .feature-banner { padding: 0 4%; margin-bottom: 3rem; }
    .feature-inner { grid-template-columns: 1fr; padding: 2.5rem 1.8rem; gap: 0; border-radius: 20px; }
    .feature-img { display: none; }
    .feature-title { font-size: 2.4rem; }

    /* Testimonials */
    .testimonials-section { padding: 3rem 4%; }
    .testi-grid { grid-template-columns: 1fr; gap: 1rem; }

    /* Footer */
    footer { padding: 3rem 4% 2rem; }
    .footer-mix-cta { flex-direction: column; text-align: center; padding: 2rem 1.5rem; border-radius: 16px; }
    .footer-mix-cta-actions { justify-content: center; flex-direction: column; width: 100%; }
    .footer-mix-cta-actions a { text-align: center; }
    .footer-mix-cta-title { font-size: 1.4rem; }
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 1.8rem; margin-bottom: 2.5rem; }
    .footer-bottom { flex-direction: column; text-align: center; gap: 0.4rem; }

    /* Toast — full width on mobile */
    .toast { left: 12px; right: 12px; top: 70px; font-size: 0.84rem; border-radius: 12px; }
}

/* ═══════════════════════════════════════
   SMALL MOBILE — under 420px
   ═══════════════════════════════════════ */
@media (max-width: 420px) {
    .mix-strip { padding: 0.5rem 3%; flex-direction: column; gap: 0.4rem; }
    .mix-strip-text { font-size: 0.66rem; }

    .perks-grid { grid-template-columns: 1fr; }
    .stats-row { grid-template-columns: 1fr 1fr; gap: 0.7rem; }
    .stat-num { font-size: 2rem; }

    .footer-grid { grid-template-columns: 1fr; }
    .footer-brand p { max-width: 100%; }

    .btn-primary, .btn-mix-hero { max-width: 100%; font-size: 0.85rem; padding: 0.85rem 1.4rem; }
    .mix-hero-band-stats { gap: 1rem; }
    .mix-hero-stat-num { font-size: 1.5rem; }
    .mix-hero-stat-label { font-size: 0.6rem; }

    .reward-mini-cards { gap: 0.5rem; }
    .how-card { padding: 1.6rem 1.2rem; }
}
</style>
</head>
<body>



<!-- MOBILE NAV DRAWER -->
<div class="mobile-nav" id="mobileNav">
    <button class="close-nav" id="closeNav" aria-label="Close menu">✕</button>
    <a href="#home" onclick="closeMobileNav()">Home</a>
    <a href="#menu" onclick="closeMobileNav()">Menu</a>
    <a href="#mix-join" class="mix-nav" onclick="closeMobileNav()">🎵 Mix Follow</a>
    <a href="#mix-rewards" onclick="closeMobileNav()">Rewards</a>
    <a href="{{ route('login') }}" class="btn-order-mobile" onclick="closeMobileNav()">Login</a>
</div>

<!-- MIX STRIP -->
<div class="mix-strip">
    <div class="mix-strip-pill">🎵 Mix Follow</div>
    <div class="mix-strip-text"><strong>FASTBITE × Mix Follow</strong> — Follow for flash deals &amp; rewards</div>
    <a href="#mix-rewards" class="mix-strip-btn">Follow &amp; Earn →</a>
</div>

<!-- NAV -->
<nav>
    <div class="nav-inner">
        <a href="#" class="logo"><span>FAST</span>BITE <span class="nav-mix-badge">🎵 Mix</span></a>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#mix-join" class="mix-nav">🎵 Mix Follow</a></li>
            <li><a href="#mix-rewards">Rewards</a></li>
            <li><a href="{{ route('login') }}" class="btn-order">Login</a></li>
        </ul>
        <button class="hamburger" id="hamburger" aria-label="Open menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- HERO -->
<section id="home">
    <div class="hero">
        <div class="hero-text">
            <a href="#mix-join" class="hero-mix-pill">🎵 Now on Mix Follow — Follow &amp; get 20% off</a>
            <div class="badge"><span class="badge-dot"></span>Now open in your city</div>
            <h1 class="hero-headline">Flavor<span class="accent">Unleashed.</span></h1>
            <p class="hero-sub">The best chefs in the city, delivered to your door in under 30 minutes. Fresh, fast, and unforgettable.</p>
            <div class="hero-cta">
                <a href="#menu" class="btn-primary">
                    Explore Menu
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#mix-join" class="btn-mix-hero">🎵 Follow on Mix Follow</a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-img-wrap">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=85" alt="Hero Food">
                <div class="hero-chip chip-1">
                    <div class="chip-icon">⚡</div>
                    <div><div style="font-weight:700;font-size:0.88rem;">30 min</div><div class="chip-label">Avg. Delivery</div></div>
                </div>
                <div class="hero-chip chip-3">
                    <div class="chip-icon mix">🎵</div>
                    <div><div style="font-weight:700;font-size:0.88rem;">24K Followers</div><div class="chip-label">On Mix Follow</div></div>
                </div>
                <div class="hero-chip chip-2">
                    <div class="chip-icon">🍕</div>
                    <div><div style="font-weight:700;font-size:0.88rem;">200+ Dishes</div><div class="chip-label">On the menu</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TICKER -->
<div class="ticker-bar">
    <div class="ticker-inner">
        <span class="ticker-item"><span class="ticker-dot">●</span> Fresh Ingredients Daily</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Mix Follow Exclusive Drops</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> 30 Minute Delivery</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Earn Mix Follow Points</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> 200+ Menu Items</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Followers Get 20% Off</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> Top Rated Chefs</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Mix Follow × FastBite</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> Contactless Delivery</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> Fresh Ingredients Daily</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Mix Follow Exclusive Drops</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> 30 Minute Delivery</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Earn Mix Follow Points</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> 200+ Menu Items</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Followers Get 20% Off</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> Top Rated Chefs</span>
        <span class="ticker-item"><span class="ticker-dot mix">●</span> Mix Follow × FastBite</span>
        <span class="ticker-item"><span class="ticker-dot">●</span> Contactless Delivery</span>
    </div>
</div>

<!-- STATS -->
<div class="stats-row">
    <div class="stat-card reveal"><div class="stat-num">10K+</div><div class="stat-label">Happy Customers</div></div>
    <div class="stat-card reveal" style="transition-delay:0.1s"><div class="stat-num">200+</div><div class="stat-label">Dishes Available</div></div>
    <div class="stat-card mix-stat reveal" style="transition-delay:0.2s"><div class="stat-num mix">24K+</div><div class="stat-label">Mix Follow Followers</div><div class="stat-sub">🎵 Growing daily</div></div>
    <div class="stat-card mix-stat reveal" style="transition-delay:0.3s"><div class="stat-num mix">20%</div><div class="stat-label">Mix Follower Discount</div><div class="stat-sub">🎵 On every order</div></div>
</div>

<!-- MIX FOLLOW HERO BAND -->
<div id="mix-join" class="mix-hero-band">
    <div class="mix-hero-band-inner reveal">
        <div>
            <div class="mix-hero-band-label">Official Partnership</div>
            <h2 class="mix-hero-band-title">FastBite is Now<br>on Mix Follow</h2>
            <p class="mix-hero-band-sub">We've joined Mix Follow — the platform where food lovers and creators connect. Follow us to unlock exclusive menu drops, follower-only discounts, and behind-the-scenes kitchen access. Be part of our 24,000+ strong community.</p>
            <div class="mix-hero-band-stats">
                <div><div class="mix-hero-stat-num">24K+</div><div class="mix-hero-stat-label">Followers</div></div>
                <div><div class="mix-hero-stat-num">150+</div><div class="mix-hero-stat-label">Posts</div></div>
                <div><div class="mix-hero-stat-num">20%</div><div class="mix-hero-stat-label">Off for followers</div></div>
                <div><div class="mix-hero-stat-num">4.9★</div><div class="mix-hero-stat-label">Avg. rating</div></div>
            </div>
        </div>
        <div class="mix-hero-band-actions">
            <a href="#" class="mix-btn-white">🎵 Follow FastBite</a>
            <a href="#mix-rewards" class="mix-btn-ghost">View Rewards →</a>
        </div>
    </div>
</div>

<!-- PERKS -->
<section class="perks-section">
    <div class="reveal">
        <div class="mix-section-eyebrow">🎵 Mix Follow Benefits</div>
        <h2 class="section-title">Why Follow Us?</h2>
        <p class="section-sub">Followers get way more than great food</p>
    </div>
    <div class="perks-grid">
        <div class="perk-card reveal"><span class="perk-icon">💸</span><div class="perk-title">20% Off Every Order</div><p class="perk-desc">Mix Follow members unlock a permanent 20% discount applied automatically at checkout. No codes, no fuss.</p></div>
        <div class="perk-card reveal" style="transition-delay:0.1s"><span class="perk-icon">🔐</span><div class="perk-title">Exclusive Secret Menu</div><p class="perk-desc">Followers get access to dishes that never appear on the public menu — chef's experiments, limited collabs, and more.</p></div>
        <div class="perk-card reveal" style="transition-delay:0.2s"><span class="perk-icon">⚡</span><div class="perk-title">Flash Deal Alerts</div><p class="perk-desc">Be first to know when we drop time-limited deals. Mix Follow notifications mean you'll never miss a steal again.</p></div>
        <div class="perk-card reveal" style="transition-delay:0.3s"><span class="perk-icon">🏆</span><div class="perk-title">Points &amp; Rewards</div><p class="perk-desc">Every order earns Mix Follow points. Stack them up and redeem for free meals, merch, and priority delivery slots.</p></div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
    <div class="reveal">
        <div class="mix-section-eyebrow">🎵 Getting Started</div>
        <h2 class="section-title">How Mix Follow Works</h2>
        <p class="section-sub">Three simple steps to unlock your perks</p>
    </div>
    <div class="how-grid">
        <div class="how-card reveal"><div class="how-num">1</div><div class="how-title">Create Mix Account</div><p class="how-desc">Sign up for Mix Follow for free in under 60 seconds. No credit card required — just your love of great food.</p></div>
        <div class="how-card reveal" style="transition-delay:0.1s"><div class="how-num">2</div><div class="how-title">Follow FastBite</div><p class="how-desc">Search for FastBite on Mix Follow and hit Follow. Instantly unlock your 20% discount and secret menu access.</p></div>
        <div class="how-card reveal" style="transition-delay:0.2s"><div class="how-num">3</div><div class="how-title">Order &amp; Earn</div><p class="how-desc">Link your Mix account at checkout. Every order earns points. The more you eat, the more you earn — it's that simple.</p></div>
    </div>
</section>

<!-- MENU -->
<section id="menu" class="menu-section">
    <div class="menu-header">
        <div class="reveal">
            <div class="section-label">Our Menu</div>
            <h2 class="section-title">Popular Dishes</h2>
            <p class="section-sub">Some Mix Follow exclusive 🎵 — only for followers</p>
        </div>
        <div class="filter-tabs reveal">
            <button class="filter-tab active" onclick="filterMenu(this,'all')">All</button>
            <button class="filter-tab" onclick="filterMenu(this,'pizza')">Pizza</button>
            <button class="filter-tab" onclick="filterMenu(this,'burger')">Burgers</button>
            <button class="filter-tab" onclick="filterMenu(this,'sushi')">Sushi</button>
            <button class="filter-tab mix-tab" onclick="filterMenu(this,'mix')">🎵 Mix Only</button>
        </div>
    </div>
    <div class="menu-grid" id="menu-grid">
        <div class="dish-card reveal" data-category="pizza">
            <div class="dish-img-wrap"><img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=700&q=80" alt="Truffle Pizza"><div class="dish-badge">Chef's Pick</div><div class="dish-rating">⭐ 4.8</div></div>
            <div class="dish-body"><div class="dish-category">Pizza</div><div class="dish-name">Truffle Pizza</div><div class="dish-desc">Wild mushrooms, truffle oil, and hand-pulled mozzarella on a thin crust.</div>
            <div class="dish-footer"><div><div class="dish-price">$18.90</div></div><button class="add-btn" onclick="addToCart('Truffle Pizza')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></button></div></div>
        </div>
        <div class="dish-card reveal" data-category="burger" style="transition-delay:0.1s">
            <div class="dish-img-wrap"><img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=700&q=80" alt="Smash Burger"><div class="dish-badge">Best Seller</div><div class="dish-rating">⭐ 4.9</div></div>
            <div class="dish-body"><div class="dish-category">Burger</div><div class="dish-name">Double Smash</div><div class="dish-desc">Two crispy smash patties, aged cheddar, caramelized onions, and secret sauce.</div>
            <div class="dish-footer"><div><div class="dish-price">$14.50</div></div><button class="add-btn" onclick="addToCart('Double Smash')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></button></div></div>
        </div>
        <div class="dish-card reveal" data-category="sushi" style="transition-delay:0.2s">
            <div class="dish-img-wrap"><img src="https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?auto=format&fit=crop&w=700&q=80" alt="Dragon Roll"><div class="dish-badge">New</div><div class="dish-rating">⭐ 4.7</div></div>
            <div class="dish-body"><div class="dish-category">Sushi</div><div class="dish-name">Dragon Roll</div><div class="dish-desc">Avocado-topped tempura shrimp roll with spicy mayo and eel sauce.</div>
            <div class="dish-footer"><div><div class="dish-price">$21.00</div></div><button class="add-btn" onclick="addToCart('Dragon Roll')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></button></div></div>
        </div>
        <div class="dish-card mix-exclusive reveal" data-category="mix pizza" style="transition-delay:0.05s">
            <div class="dish-img-wrap"><img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=700&q=80" alt="Black Garlic Margherita"><div class="dish-badge mix">🎵 Mix Exclusive</div><div class="dish-rating">⭐ 4.9</div></div>
            <div class="dish-body"><div class="dish-category mix">🎵 Mix Follow Only</div><div class="dish-name">Black Garlic Margherita</div><div class="dish-desc">Fermented black garlic cream, wild arugula, shaved parmesan — only available to Mix followers.</div>
            <div class="dish-footer"><div><div class="dish-price">$17.00</div><div class="dish-price-mix">🎵 $13.60 for followers</div></div><button class="add-btn mix" onclick="addToCart('Black Garlic Margherita')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></button></div></div>
        </div>
        <div class="dish-card mix-exclusive reveal" data-category="mix burger" style="transition-delay:0.12s">
            <div class="dish-img-wrap"><img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=700&q=80" alt="Collab Burger"><div class="dish-badge mix">🎵 Mix Drop</div><div class="dish-rating">⭐ 5.0</div></div>
            <div class="dish-body"><div class="dish-category mix">🎵 Mix Follow Only</div><div class="dish-name">The Collab Burger</div><div class="dish-desc">A limited-edition creation developed live with our Mix Follow community — wagyu patty, truffle aioli, crispy shallots.</div>
            <div class="dish-footer"><div><div class="dish-price">$22.00</div><div class="dish-price-mix">🎵 $17.60 for followers</div></div><button class="add-btn mix" onclick="addToCart('The Collab Burger')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></button></div></div>
        </div>
        <div class="dish-card reveal" data-category="burger" style="transition-delay:0.15s">
            <div class="dish-img-wrap"><img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=700&q=80" alt="Smoky BBQ"><div class="dish-rating">⭐ 4.8</div></div>
            <div class="dish-body"><div class="dish-category">Burger</div><div class="dish-name">Smoky BBQ</div><div class="dish-desc">Slow-cooked pulled pork, jalapeño slaw, smoked gouda, and hickory BBQ.</div>
            <div class="dish-footer"><div><div class="dish-price">$16.80</div></div><button class="add-btn" onclick="addToCart('Smoky BBQ')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></button></div></div>
        </div>
    </div>
</section>

<!-- REWARDS -->
<section id="mix-rewards" class="rewards-section">
    <div class="rewards-inner">
        <div class="reveal">
            <div class="rewards-card-stack">
                <div class="reward-card-bg"></div>
                <div class="reward-card-mid"></div>
                <div class="reward-card-front">
                    <div class="reward-card-logo">FASTBITE <span>× MIX FOLLOW</span></div>
                    <div class="reward-card-points">2,450</div>
                    <div class="reward-card-points-label">Mix Points Balance</div>
                    <div class="reward-card-bottom">
                        <div class="reward-card-name">Your Name Here</div>
                        <div class="reward-card-tier">Gold Member</div>
                    </div>
                </div>
                <div class="reward-mini-cards">
                    <div class="reward-mini"><span class="reward-mini-icon">🍕</span><div class="reward-mini-title">Free Pizza</div><div class="reward-mini-sub">500 pts</div></div>
                    <div class="reward-mini"><span class="reward-mini-icon">🚀</span><div class="reward-mini-title">Priority Delivery</div><div class="reward-mini-sub">200 pts</div></div>
                    <div class="reward-mini"><span class="reward-mini-icon">🎁</span><div class="reward-mini-title">Mystery Box</div><div class="reward-mini-sub">1000 pts</div></div>
                </div>
            </div>
        </div>
        <div class="reveal" style="transition-delay:0.15s">
            <div class="rewards-eyebrow">🎵 Mix Follow Rewards</div>
            <h2 class="rewards-title">Every Bite<br>Earns <span>Points</span></h2>
            <p class="rewards-desc">Link your Mix Follow account to FastBite and watch the points pile up. Every dollar spent earns 10 Mix Points — redeemable for free food, perks, and exclusive experiences.</p>
            <ul class="rewards-list">
                <li><div class="rewards-list-icon">🍽️</div><div class="rewards-list-text"><strong>10 pts per $1 spent</strong>Earn on every order with no cap on how much you can stack.</div></li>
                <li><div class="rewards-list-icon">⭐</div><div class="rewards-list-text"><strong>Tiered membership (Bronze → Gold → Legend)</strong>The more you order, the higher your tier — and the better your perks.</div></li>
                <li><div class="rewards-list-icon">🎉</div><div class="rewards-list-text"><strong>Bonus events &amp; challenges</strong>Complete Mix Follow challenges for bonus points — follow a chef, share a dish, refer a friend.</div></li>
                <li><div class="rewards-list-icon">🎁</div><div class="rewards-list-text"><strong>Redeem for real rewards</strong>Free meals, priority delivery, mystery boxes, meet-the-chef experiences.</div></li>
            </ul>
            <a href="#" class="btn-mix-primary">🎵 Join &amp; Start Earning</a>
        </div>
    </div>
</section>

<!-- FEATURE BANNER -->
<div class="feature-banner">
    <div class="feature-inner reveal">
        <div>
            <div class="feature-tag">🔥 Limited Time</div>
            <h3 class="feature-title">First <span>Delivery Free</span></h3>
            <p class="feature-desc">New to FastBite? Your first order ships on us. Mix Follow members get an extra bonus — double points on order #1.</p>
            <a href="#" class="btn-white">Claim Free Delivery →</a>
        </div>
        <div class="feature-img"><img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=800&q=85" alt="Food spread"></div>
    </div>
</div>

<!-- TESTIMONIALS -->
<section class="testimonials-section">
    <div class="testimonials-inner">
        <div class="testimonials-label reveal">🎵 Mix Follow Community</div>
        <h2 class="testimonials-title reveal">What Our <span>Followers</span> Say</h2>
        <div class="testi-grid">
            <div class="testi-card reveal"><div class="testi-stars">★★★★★</div><p class="testi-text">"I followed FastBite on Mix Follow and got 20% off instantly. The Black Garlic Margherita is a revelation — never would've found it without being a follower."</p><div class="testi-author"><div class="testi-avatar"><img src="https://i.pravatar.cc/40?img=3" alt=""></div><div><div class="testi-name">Sarah K.</div><div class="testi-via">🎵 via Mix Follow</div></div></div></div>
            <div class="testi-card reveal" style="transition-delay:0.1s"><div class="testi-stars">★★★★★</div><p class="testi-text">"The Collab Burger was literally designed by the community on Mix Follow — I voted for the wagyu patty. Feels amazing being part of the process."</p><div class="testi-author"><div class="testi-avatar"><img src="https://i.pravatar.cc/40?img=7" alt=""></div><div><div class="testi-name">Marcus T.</div><div class="testi-via">🎵 via Mix Follow</div></div></div></div>
            <div class="testi-card reveal" style="transition-delay:0.2s"><div class="testi-stars">★★★★★</div><p class="testi-text">"I've redeemed 3 free meals already from Mix Points. It's the best loyalty program I've ever used — and FastBite's food is genuinely top-tier."</p><div class="testi-author"><div class="testi-avatar"><img src="https://i.pravatar.cc/40?img=12" alt=""></div><div><div class="testi-name">Priya M.</div><div class="testi-via">🎵 via Mix Follow</div></div></div></div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <div class="footer-mix-cta reveal">
            <div class="footer-mix-cta-text">
                <div class="footer-mix-cta-eyebrow">🎵 Join our Mix Follow community</div>
                <div class="footer-mix-cta-title">24,000+ Followers Can't Be Wrong —<br>Follow FastBite Today</div>
            </div>
            <div class="footer-mix-cta-actions">
                <a href="#" class="mix-btn-white">🎵 Follow on Mix Follow</a>
                <a href="#mix-rewards" class="mix-btn-ghost">View Rewards</a>
            </div>
        </div>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#" class="logo"><span>FAST</span>BITE</a>
                <p>Revolutionizing urban dining — bringing the city's finest kitchens to your doorstep. Now in official partnership with Mix Follow.</p>
            </div>
            <div class="footer-col">
                <h5>Explore</h5>
                <ul>
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Latest Menu</a></li>
                    <li><a href="#">Partner With Us</a></li>
                    <li><a href="#mix-rewards">Rewards</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>Mix Follow</h5>
                <ul>
                    <li><a href="#mix-join" class="mix-link">Follow FastBite</a></li>
                    <li><a href="#mix-rewards" class="mix-link">Earn Points</a></li>
                    <li><a href="#menu" class="mix-link">Exclusive Dishes</a></li>
                    <li><a href="#" class="mix-link">Flash Deals</a></li>
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
        </div>
        <div class="footer-bottom">
            <span>© 2026 FastBite. All rights reserved.</span>
            <span>In official partnership with <span class="footer-mix-badge-bottom">🎵 Mix Follow</span></span>
        </div>
    </div>
</footer>

<script>
// ── Toast ──
function addToCart(name) {
    const toast = document.getElementById('toast');
    document.getElementById('toast-text').textContent = `${name} added to cart!`;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

// ── Menu filter ──
function filterMenu(btn, category) {
    document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.dish-card').forEach(card => {
        const cats = card.dataset.category || '';
        const match = category === 'all' || cats.includes(category);
        card.style.opacity = match ? '1' : '0.2';
        card.style.pointerEvents = match ? 'auto' : 'none';
        card.style.transform = match ? '' : 'scale(0.96)';
        card.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
    });
}

// ── Hamburger / Mobile nav ──
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
const closeNav  = document.getElementById('closeNav');

function openMobileNav() {
    mobileNav.classList.add('open');
    hamburger.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMobileNav() {
    mobileNav.classList.remove('open');
    hamburger.classList.remove('open');
    document.body.style.overflow = '';
}
hamburger.addEventListener('click', openMobileNav);
closeNav.addEventListener('click', closeMobileNav);
mobileNav.addEventListener('click', (e) => { if (e.target === mobileNav) closeMobileNav(); });

// ── Scroll reveal ──
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
    });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
</body>
</html>