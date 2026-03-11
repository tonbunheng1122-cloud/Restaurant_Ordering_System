@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Flavor Unleashed</title>
<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false, activeTab: 'All' }">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden relative">
        
        <aside > 
            @include('components.asidebar')
        </aside>
        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">
            <header class="flex items-center gap-4 mb-2 xl:hidden">
                <button @click="mobileMenuOpen = true" class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </header>
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8"
                x-data="{
                    activeTab: 'All',
                    search: '',
                    matchRow(text) { return this.search === '' || text.toLowerCase().includes(this.search.toLowerCase()) }}">

    {{-- ── Header ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-bold text-gray-800">Reports</h2>
            <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">Dec 2025</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative w-full md:w-80">
                <input
                    type="text"
                    placeholder="Search this table"
                    x-model="search"
                    class="w-full pl-4 pr-10 py-3 bg-white border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 transition text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button class="flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold px-4 py-3 rounded-xl transition whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
        </div>
    </div>

    {{-- ── Tabs ── --}}
    <div class="flex overflow-x-auto gap-6 border-b-2 border-black mb-6 no-scrollbar">
        @php $tabs = ['All', 'Products', 'Top Selling', 'Table']; @endphp
        @foreach($tabs as $tab)
            <button
                @click="activeTab = '{{ $tab }}'"
                :class="activeTab === '{{ $tab }}' ? 'text-[#EE6D3C] border-b-4 border-[#EE6D3C]' : 'text-black hover:text-[#EE6D3C]'"
                class="pb-3 px-1 text-lg font-bold whitespace-nowrap transition-all duration-200">
                {{ $tab }}
            </button>
        @endforeach
    </div>

    <div class="overflow-x-auto">

        {{-- ══ ALL ══ --}}
        <table x-show="activeTab === 'All'" class="w-full text-left min-w-[800px]">
            <thead>
                <tr class="text-black font-extrabold text-lg border-b-2 border-gray-100">
                    <th class="py-4">Date</th>
                    <th class="py-4">ID</th>
                    <th class="py-4">Image</th>
                    <th class="py-4">Name</th>
                    <th class="py-4">Paid</th>
                    <th class="py-4">Status</th>
                    <th class="py-4">Payment Status</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-blue-100">
                @php
                    $orders = [
                        ['date'=>'10-12-25','id'=>'001','emoji'=>'🍜','name'=>'Spicy Korean Ramen',   'price'=>'$9.99', 'status'=>'Completed','payment'=>'Paid'],
                        ['date'=>'10-12-25','id'=>'002','emoji'=>'🍔','name'=>'Beef Burger XL',        'price'=>'$12.50','status'=>'Completed','payment'=>'Paid'],
                        ['date'=>'10-12-25','id'=>'003','emoji'=>'🍕','name'=>'Margherita Pizza',      'price'=>'$14.00','status'=>'Pending',  'payment'=>'Unpaid'],
                        ['date'=>'09-12-25','id'=>'004','emoji'=>'🥩','name'=>'BBQ Steak Platter',     'price'=>'$24.99','status'=>'Completed','payment'=>'Paid'],
                        ['date'=>'09-12-25','id'=>'005','emoji'=>'🍣','name'=>'Salmon Sushi Roll',     'price'=>'$18.50','status'=>'Cancelled','payment'=>'Unpaid'],
                        ['date'=>'09-12-25','id'=>'006','emoji'=>'🌮','name'=>'Chicken Taco Trio',     'price'=>'$11.00','status'=>'Completed','payment'=>'Paid'],
                        ['date'=>'08-12-25','id'=>'007','emoji'=>'🍝','name'=>'Million Dollar Lasagna','price'=>'$16.75','status'=>'Pending',  'payment'=>'Paid'],
                    ];
                    $statusBadge = [
                        'Completed' => 'border border-green-500 text-green-500',
                        'Pending'   => 'border border-amber-400 text-amber-500',
                        'Cancelled' => 'border border-red-400   text-red-500',
                    ];
                    $payBadge = [
                        'Paid'   => 'border border-green-500 text-green-500',
                        'Unpaid' => 'border border-red-400   text-red-500',
                    ];
                @endphp
                @foreach($orders as $o)
                <tr class="text-black font-bold text-base hover:bg-orange-50 transition"
                    x-show="matchRow('{{ $o['date'].' '.$o['id'].' '.$o['name'].' '.$o['price'].' '.$o['status'].' '.$o['payment'] }}')">
                    <td class="py-4 text-gray-500 font-medium">{{ $o['date'] }}</td>
                    <td class="py-4 text-gray-300 text-sm font-bold">#{{ $o['id'] }}</td>
                    <td class="py-4">
                        <div class="w-14 h-14 rounded-xl bg-[#FFE4DB] flex items-center justify-center text-2xl">{{ $o['emoji'] }}</div>
                    </td>
                    <td class="py-4">{{ $o['name'] }}</td>
                    <td class="py-4 font-extrabold">{{ $o['price'] }}</td>
                    <td class="py-4">
                        <span class="px-4 py-1 rounded-lg text-sm font-bold {{ $statusBadge[$o['status']] }}">{{ $o['status'] }}</span>
                    </td>
                    <td class="py-4">
                        <span class="px-6 py-1 rounded-lg text-sm font-bold {{ $payBadge[$o['payment']] }}">{{ $o['payment'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ══ PRODUCTS ══ --}}
        <table x-show="activeTab === 'Products'" style="display:none" class="w-full text-left min-w-[800px]">
            <thead>
                <tr class="text-black font-extrabold text-lg border-b-2 border-gray-100">
                    <th class="py-4">Code</th>
                    <th class="py-4">Product Name</th>
                    <th class="py-4">Category</th>
                    <th class="py-4">Stock</th>
                    <th class="py-4">Price</th>
                    <th class="py-4">Stock Status</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-green-100">
                @php
                    $products = [
                        ['code'=>'PRO-01','emoji'=>'🍜','name'=>'Spicy Korean Ramen',   'cat'=>'Noodles','stock'=>88, 'price'=>'$9.99', 'stockStatus'=>'In Stock'],
                        ['code'=>'PRO-02','emoji'=>'🍔','name'=>'Beef Burger XL',        'cat'=>'Burgers','stock'=>142,'price'=>'$12.50','stockStatus'=>'In Stock'],
                        ['code'=>'PRO-03','emoji'=>'🍕','name'=>'Margherita Pizza',      'cat'=>'Pizza',  'stock'=>12, 'price'=>'$14.00','stockStatus'=>'Low Stock'],
                        ['code'=>'PRO-04','emoji'=>'🥩','name'=>'BBQ Steak Platter',     'cat'=>'Mains',  'stock'=>34, 'price'=>'$24.99','stockStatus'=>'In Stock'],
                        ['code'=>'PRO-05','emoji'=>'🍣','name'=>'Salmon Sushi Roll',     'cat'=>'Sushi',  'stock'=>0,  'price'=>'$18.50','stockStatus'=>'Out of Stock'],
                        ['code'=>'PRO-06','emoji'=>'🍝','name'=>'Million Dollar Lasagna','cat'=>'Pasta',  'stock'=>60, 'price'=>'$16.75','stockStatus'=>'In Stock'],
                    ];
                    $stockBadge = [
                        'In Stock'     => 'border border-green-500 text-green-500',
                        'Low Stock'    => 'border border-amber-400  text-amber-500',
                        'Out of Stock' => 'border border-red-400    text-red-500',
                    ];
                @endphp
                @foreach($products as $p)
                <tr class="text-black font-bold text-base hover:bg-green-50 transition"
                    x-show="matchRow('{{ $p['code'].' '.$p['name'].' '.$p['cat'].' '.$p['stockStatus'] }}')">
                    <td class="py-4 text-gray-300 text-sm font-bold">{{ $p['code'] }}</td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#FFE4DB] flex items-center justify-center text-lg">{{ $p['emoji'] }}</div>
                            {{ $p['name'] }}
                        </div>
                    </td>
                    <td class="py-4 text-gray-500 font-medium">{{ $p['cat'] }}</td>
                    <td class="py-4">{{ $p['stock'] }}</td>
                    <td class="py-4 font-extrabold">{{ $p['price'] }}</td>
                    <td class="py-4">
                        <span class="px-3 py-1 rounded-lg text-sm font-bold {{ $stockBadge[$p['stockStatus']] }}">{{ $p['stockStatus'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ══ TOP SELLING ══ --}}
        <table x-show="activeTab === 'Top Selling'" style="display:none" class="w-full text-left min-w-[800px]">
            <thead>
                <tr class="text-black font-extrabold text-lg border-b-2 border-gray-100">
                    <th class="py-4">Rank</th>
                    <th class="py-4">Product</th>
                    <th class="py-4">Category</th>
                    <th class="py-4">Sales Count</th>
                    <th class="py-4 w-40">Progress</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-red-100">
                @php
                    $topSelling = [
                        ['rank'=>'#1','badge'=>'bg-amber-100 text-amber-700',  'emoji'=>'🍝','name'=>'Million Dollar Lasagna','cat'=>'Pasta',  'sales'=>'450 Units','pct'=>100],
                        ['rank'=>'#2','badge'=>'bg-gray-100  text-gray-600',   'emoji'=>'🍔','name'=>'Beef Burger XL',        'cat'=>'Burgers','sales'=>'390 Units','pct'=>87],
                        ['rank'=>'#3','badge'=>'bg-orange-100 text-orange-700','emoji'=>'🍜','name'=>'Spicy Korean Ramen',    'cat'=>'Noodles','sales'=>'340 Units','pct'=>76],
                        ['rank'=>'#4','badge'=>'bg-gray-50   text-gray-400',   'emoji'=>'🥩','name'=>'BBQ Steak Platter',    'cat'=>'Mains',  'sales'=>'280 Units','pct'=>62],
                        ['rank'=>'#5','badge'=>'bg-gray-50   text-gray-400',   'emoji'=>'🌮','name'=>'Chicken Taco Trio',    'cat'=>'Mexican','sales'=>'210 Units','pct'=>47],
                        ['rank'=>'#6','badge'=>'bg-gray-50   text-gray-400',   'emoji'=>'🍕','name'=>'Margherita Pizza',     'cat'=>'Pizza',  'sales'=>'180 Units','pct'=>40],
                    ];
                @endphp
                @foreach($topSelling as $t)
                <tr class="text-black font-bold text-base hover:bg-red-50 transition"
                    x-show="matchRow('{{ $t['rank'].' '.$t['name'].' '.$t['cat'].' '.$t['sales'] }}')">
                    <td class="py-4">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm font-extrabold {{ $t['badge'] }}">{{ $t['rank'] }}</span>
                    </td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#FFE4DB] flex items-center justify-center text-lg">{{ $t['emoji'] }}</div>
                            {{ $t['name'] }}
                        </div>
                    </td>
                    <td class="py-4 text-gray-500 font-medium">{{ $t['cat'] }}</td>
                    <td class="py-4 font-extrabold">{{ $t['sales'] }}</td>
                    <td class="py-4">
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#EE6D3C] rounded-full" style="width: {{ $t['pct'] }}%"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ══ TABLE ══ --}}
        <div x-show="activeTab === 'Table'" style="display:none">

            {{-- Stats strip --}}
            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                    <p class="text-2xl font-extrabold text-gray-800">10</p>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mt-1">Total Tables</p>
                </div>
                <div class="bg-amber-50 rounded-xl p-4 text-center border border-amber-100">
                    <p class="text-2xl font-extrabold text-amber-500">2</p>
                    <p class="text-xs font-bold uppercase tracking-widest text-amber-400 mt-1">Occupied</p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 text-center border border-green-100">
                    <p class="text-2xl font-extrabold text-green-500">3</p>
                    <p class="text-xs font-bold uppercase tracking-widest text-green-400 mt-1">Available</p>
                </div>
            </div>

            {{-- Floor map --}}
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                <p class="text-sm font-bold text-gray-500 mb-4">🪑 Floor View</p>
                <div class="grid grid-cols-5 gap-3">
                    @php
                        $floorTables = [
                            ['no'=>1, 'status'=>'occupied'], ['no'=>2, 'status'=>'occupied'],
                            ['no'=>3, 'status'=>'available'],['no'=>4, 'status'=>'reserved'],
                            ['no'=>5, 'status'=>'occupied'], ['no'=>6, 'status'=>'available'],
                            ['no'=>7, 'status'=>'occupied'], ['no'=>8, 'status'=>'occupied'],
                            ['no'=>9, 'status'=>'reserved'], ['no'=>10,'status'=>'available'],
                        ];
                        $tableColor = [
                            'occupied'  => 'bg-red-100   text-red-500',
                            'available' => 'bg-green-100  text-green-600',
                            'reserved'  => 'bg-amber-100  text-amber-600',
                        ];
                    @endphp
                    @foreach($floorTables as $ft)
                    <div class="aspect-square rounded-xl flex flex-col items-center justify-center cursor-pointer hover:scale-105 transition-transform {{ $tableColor[$ft['status']] }}">
                        <span class="text-base font-extrabold">{{ $ft['no'] }}</span>
                        <span class="text-[9px] font-bold capitalize mt-0.5">{{ $ft['status'] }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex gap-5 mt-4 flex-wrap">
                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                        <div class="w-3 h-3 rounded bg-red-200"></div> Occupied
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                        <div class="w-3 h-3 rounded bg-green-200"></div> Available
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                        <div class="w-3 h-3 rounded bg-amber-200"></div> Reserved
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
        </main>
    </div>
</div>