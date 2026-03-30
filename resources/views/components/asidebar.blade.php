{{--
    components/asidebar.blade.php
    Sidebar with Notification Bell (replaces dark-mode toggle).
    Receives from controller:
      $pendingDeletionCount  – int
      $pendingDeletions      – Collection<DeletionRequest> (admin only)
--}}
@php
    use Illuminate\Support\Facades\Auth;
    $authUser = Auth::user();
    $isAdmin  = $authUser && $authUser->role === 'Admin';

    $navItems = [
        ['group'=>'Main',       'route'=>'dashboard.index',   'match'=>'dashboard.*',   'label'=>'Dashboard',    'icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['group'=>'Catalog',    'route'=>'allproduct.index',  'match'=>'allproduct.*',  'label'=>'Products',     'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['group'=>'Catalog',    'route'=>'allcategory.index', 'match'=>'allcategory.*', 'label'=>'Categories',   'icon'=>'M4 6h16M4 10h16M4 14h16M4 18h16'],
        ['group'=>'Catalog',    'route'=>'menu.index',        'match'=>'menu.*',        'label'=>'Menu',         'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['group'=>'Operations', 'route'=>'reservations.index','match'=>'reservations.*','label'=>'Reservations', 'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1'],
        ['group'=>'Operations', 'route'=>'report.index',      'match'=>'report.*',      'label'=>'Reports',      'icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['group'=>'Admin',      'route'=>'user.index',        'match'=>'user.*',        'label'=>'Users',        'adminOnly'=>true, 'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['group'=>'Admin',      'route'=>'setting.index',     'match'=>'setting.*',     'label'=>'Settings',     'icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
    ];
    $grouped = collect($navItems)->groupBy('group');
@endphp

<style>
/* ── Sidebar base ─────────────────────────────────── */
.no-scrollbar::-webkit-scrollbar { display: none; }

/* ── Notification bell ────────────────────────────── */
.notif-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    width: 100%;
    background: transparent;
    color: #6b7280;
}
.notif-trigger:hover { background: rgba(238,109,60,0.08); color: #EE6D3C; }
.notif-trigger-left  { display: flex; align-items: center; gap: 8px; }

.notif-badge {
    background: #ef4444;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 1px 6px;
    border-radius: 20px;
    min-width: 18px;
    text-align: center;
    line-height: 1.4;
    animation: badge-pulse 1.6s ease-in-out infinite;
}
.notif-badge.zero { background: #d1d5db; color: #6b7280; animation: none; }
@keyframes badge-pulse {
    0%,100% { transform: scale(1); }
    50%      { transform: scale(1.2); }
}
</style>

<div x-data="{ open: false }" class="relative">

    {{-- ── Mobile top bar ──────────────────────────────── --}}
    <div class="fixed top-0 left-0 right-0 bg-[#EE6D3C] text-white px-4 py-3 flex justify-between items-center md:hidden z-40 shadow-md">
        <span class="text-lg font-black tracking-tight">Fast<span class="text-white/70">Bite</span></span>
        <button @click="open = true" class="p-1.5 rounded-lg bg-white/20 hover:bg-white/30 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
    </div>

    {{-- ── Overlay ──────────────────────────────────────── --}}
    <div x-show="open" @click="open = false" x-transition.opacity class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>

    {{-- ── Sidebar ──────────────────────────────────────── --}}
    <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed md:static inset-y-0 left-0 z-40
               w-64 h-full bg-white rounded-2xl shadow-sm border border-orange-100
               flex flex-col transform transition-transform duration-300 ease-in-out
               md:translate-x-0 overflow-hidden" >

        {{-- Logo --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-orange-50">
            <div class="flex items-center gap-2">
                <img src="{{ Vite::asset('resources/images/FASTBITE_LOGO.png') }}"
                     alt="Logo" class="w-10 h-10 object-contain">
                <span class="text-lg font-black text-gray-800 tracking-tight">
                    Fast<span class="text-[#EE6D3C]">Bite</span>
                </span>
            </div>
            <button @click="open = false" class="md:hidden p-1 rounded-lg hover:bg-gray-100 text-gray-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto no-scrollbar">
            @foreach($grouped as $groupName => $items)
                @if(!$loop->first)
                    <div class="pt-2 pb-1 border-t border-gray-100"></div>
                @endif
                <p class="px-4 pb-1 pt-1 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    {{ $groupName }}
                </p>
                @foreach($items as $item)
                    @php
                        if (!empty($item['adminOnly']) && !$isAdmin) continue;
                        $active = request()->routeIs($item['match']);
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200
                           {{ $active
                               ? 'bg-[#EE6D3C] text-white shadow-md shadow-orange-200'
                               : 'text-gray-600 hover:bg-orange-50 hover:text-[#EE6D3C]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span class="flex-1">{{ $item['label'] }}</span>
                        @if($active)
                            <span class="w-1.5 h-1.5 rounded-full bg-white/60 ml-auto"></span>
                        @endif
                    </a>
                @endforeach
            @endforeach
        </nav>

        {{-- Bottom --}}
        <div class="px-4 py-4 border-t border-orange-50 space-y-2">

            {{-- ═══ NOTIFICATION BELL (replaces dark-mode toggle) ═══ --}}
            @php
                $count = $pendingDeletionCount ?? 0;
            @endphp
            <button class="notif-trigger"
                    onclick="fbToggleNotifPanel()"
                    id="fbNotifTriggerBtn"
                    type="button">
                <div class="notif-trigger-left">
                    {{-- Bell icon with subtle ring animation when count > 0 --}}
                    <svg class="w-4 h-4 flex-shrink-0 {{ $count > 0 ? 'animate-[wiggle_1s_ease-in-out_infinite]' : '' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="text-sm font-semibold">Notifications</span>
                </div>
                <span id="fbNotifBadge"
                      class="notif-badge {{ $count === 0 ? 'zero' : '' }}">
                    {{ $count }}
                </span>
            </button>

            {{-- User info --}}
            <div class="flex items-center gap-3 px-3 py-2.5 bg-gray-50 rounded-xl">
                <div class="w-8 h-8 rounded-full bg-[#FFE4DB] text-[#EE6D3C] font-black text-sm flex items-center justify-center flex-shrink-0">
                    {{ strtoupper(substr($authUser->username ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 truncate">{{ $authUser->username ?? 'Admin' }}</p>
                    <p class="text-[10px] text-gray-400 truncate">{{ $authUser->role ?? 'Admin' }}</p>
                </div>
                <span class="w-2 h-2 rounded-full bg-green-400 flex-shrink-0" title="Online"></span>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold
                           text-gray-500 hover:bg-red-50 hover:text-red-500 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>

        </div>
    </aside>
</div>