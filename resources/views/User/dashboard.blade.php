@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    [x-cloak] { display: none !important; }

    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #EE6D3C;
    }

    .metric-icon {
        background: linear-gradient(135deg, #EE6D3C, #ff8c42);
        color: white;
    }

    .chart-container {
        position: relative;
        height: 250px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<title>FastBite | Dashboard</title>

<div class="bg-[#FFE4DB] min-h-screen" x-data="dashboardData()" x-init="init()">
    <div class="flex flex-col md:flex-row md:h-screen md:p-4 md:gap-6 overflow-hidden relative">

        <!-- Sidebar (includes its own mobile header & overlay) -->
        @include('components.asidebar')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto px-3 pb-4 md:px-0 md:pr-2 custom-scrollbar">

            <!-- Header Card -->
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mb-6 mt-3 md:mt-0">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-orange-50 text-[#EE6D3C]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
                            <p class="text-gray-500 text-sm">Welcome back, {{ Auth::user()->username ?? 'Admin' }}! Here's a summary of your restaurant's performance.</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="bg-gray-50 rounded-xl px-4 py-2 text-sm text-gray-600">
                            <span>Last updated: </span>
                            <span class="font-semibold" x-text="currentTime"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="stat-card rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg metric-icon flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                            +{{ $revenueChange }}% from yesterday
                        </span>
                    </div>
                </div>

                <!-- Today's Orders -->
                <div class="stat-card rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg metric-icon flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Today's Orders</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $todayOrders }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">
                            +{{ $ordersChange }}% from yesterday
                        </span>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="stat-card rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg metric-icon flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Products</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        Across {{ $totalCategories }} categories
                    </div>
                </div>
            </div>

            <!-- Charts and Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                <!-- Sales Chart -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Sales Overview</h3>
                            <p class="text-sm text-gray-600">Last 30 days performance</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#EE6D3C]"></div>
                            <span class="text-sm font-medium text-gray-700">Revenue</span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Recent Products -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Recent Products</h3>
                            <p class="text-sm text-gray-600">Latest additions to your menu</p>
                        </div>
                        <a href="{{ route('menu.index') }}"
                           class="text-sm font-medium text-[#EE6D3C] hover:text-orange-700 transition">
                            Order now →
                        </a>
                    </div>
                    <div class="space-y-4 max-h-64 overflow-y-auto custom-scrollbar">
                        @foreach($recentProducts as $product)
                        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="/storage/{{ $product->image }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $product->category->name ?? 'No Category' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-[#EE6D3C]">${{ number_format($product->price, 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $product->qty }} in stock</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        function dashboardData() {
            return {
                currentTime: '',

                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                    this.initChart();
                },

                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                },

                initChart() {
                    const ctx = document.getElementById('salesChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($salesLabels),
                            datasets: [{
                                label: 'Sales ($)',
                                data: @json($salesValues),
                                borderColor: '#EE6D3C',
                                backgroundColor: 'rgba(238, 109, 60, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#EE6D3C',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(0,0,0,0.05)' },
                                    ticks: {
                                        callback: function(value) { return '$' + value; }
                                    }
                                },
                                x: { grid: { display: false } }
                            },
                            elements: { point: { hoverBorderWidth: 3 } }
                        }
                    });
                }
            }
        }
    </script>
</div>