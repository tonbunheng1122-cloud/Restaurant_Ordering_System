@include('partials.theme-head')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Flavor Unleashed</title>

<div class="bg-[var(--admin-bg-primary)] min-h-screen text-[var(--admin-text-primary)]" x-data="{ 
    mobileMenuOpen: false, 
    selectedTable: '{{ old('table_id', $reservation->table_id ?? '') }}', 
    guestCount: '{{ old('guest_count', $reservation->guest_count ?? 1) }}' 
}">
    <div class="flex flex-col md:flex-row md:h-screen md:p-4 md:gap-6 md:overflow-hidden relative">

        @include('components.asidebar')

        <main class="flex-1 overflow-y-auto px-3 pb-4 md:px-0 md:pr-2 custom-scrollbar">
            <div class="bg-[var(--admin-card-bg)] rounded-lg shadow-sm border border-[var(--admin-border)] p-6 md:p-8 mt-3 md:mt-0 mb-8">

                @include('components.alerts')

                <!-- Header -->
                <div class="flex items-center gap-3 mb-8">
                    <h2 class="text-2xl font-bold text-[var(--admin-text-primary)]">
                        {{ isset($reservation) ? 'Edit Reservation' : 'Add New Reservation' }}
                    </h2>
                    <span class="text-xs font-bold bg-[var(--admin-bg-primary)] text-[#EE6D3C] px-3 py-1 rounded-full border border-[#EE6D3C]/20">
                        {{ isset($reservation) ? 'Editing' : 'New' }}
                    </span>
                </div>

                <form action="{{ isset($reservation) ? route('reservations.update', $reservation->id) : route('reservations.store') }}"
                      method="POST">
                    @csrf
                    @if(isset($reservation)) @method('PUT') @endif

                    <div class="flex flex-col lg:flex-row gap-8">

                        <div class="w-full lg:w-2/5 flex flex-col gap-5">

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-[var(--admin-text-secondary)] text-sm uppercase tracking-wide">Full Name *</label>
                                <input type="text" name="full_name" required
                                    value="{{ old('full_name', $reservation->full_name ?? '') }}"
                                    placeholder="Enter full name"
                                    class="w-full px-4 py-3 border border-[var(--admin-border)] bg-[var(--admin-card-bg)] text-[var(--admin-text-primary)] rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                        @error('full_name') border-red-400 @enderror">
                                @error('full_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                             <div class="grid grid-cols-2 gap-4">
                                 <div class="flex flex-col gap-2">
                                    <label class="font-bold text-[var(--admin-text-secondary)] text-sm uppercase tracking-wide">Phone Number *</label>
                                    <input type="tel" name="phone_number" required
                                        value="{{ old('phone_number', $reservation->phone_number ?? '') }}"
                                        placeholder="+1 234 567 8900"
                                        class="w-full px-4 py-3 border border-[var(--admin-border)] rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition bg-[var(--admin-card-bg)] text-[var(--admin-text-primary)]
                                            @error('phone_number') border-red-400 @enderror">
                                    @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="font-bold text-[var(--admin-text-secondary)] text-sm uppercase tracking-wide">Guests *</label>
                                    <input type="number" name="guest_count" required min="1" max="20"
                                        x-model="guestCount"
                                        class="w-full px-4 py-3 border border-[var(--admin-border)] rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition bg-[var(--admin-card-bg)] text-[var(--admin-text-primary)]
                                            @error('guest_count') border-red-400 @enderror">
                                    @error('guest_count') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                 <div class="flex flex-col gap-2">
                                    <label class="font-bold text-[var(--admin-text-secondary)] text-sm uppercase tracking-wide">Date *</label>
                                    <input type="date" name="date" required
                                        value="{{ old('date', $reservation->date ?? '') }}"
                                        class="w-full px-4 py-3 border border-[var(--admin-border)] rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition bg-[var(--admin-card-bg)] text-[var(--admin-text-primary)]
                                            @error('date') border-red-400 @enderror">
                                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="font-bold text-[var(--admin-text-secondary)] text-sm uppercase tracking-wide">Time *</label>
                                    <input type="time" name="time" required
                                        value="{{ old('time', $reservation->time ?? '') }}"
                                        class="w-full px-4 py-3 border border-[var(--admin-border)] rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition bg-[var(--admin-card-bg)] text-[var(--admin-text-primary)]
                                            @error('time') border-red-400 @enderror">
                                    @error('time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-[var(--admin-text-secondary)] text-sm uppercase tracking-wide">Selected Table *</label>
                                <div class="relative">
                                    <input type="text" name="table_id" required readonly
                                        :value="selectedTable"
                                        placeholder="Click a table on the right →"
                                        class="w-full px-4 py-3 border border-[var(--admin-border)] rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-[var(--admin-bg-primary)] cursor-default transition"
                                        :class="selectedTable ? 'border-orange-500 bg-orange-500/10 text-[#EE6D3C] font-black' : 'text-[var(--admin-text-secondary)]'">
                                    <template x-if="selectedTable">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#EE6D3C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                    </template>
                                </div>
                            </div>

                        </div>

                        <div class="w-full lg:flex-1 bg-[var(--admin-bg-primary)] border border-[var(--admin-border)] rounded-2xl p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-8">
                                <h3 class="font-bold text-[var(--admin-text-secondary)] text-sm uppercase tracking-wide">Select Table</h3>
                                <span class="text-xs font-bold bg-[var(--admin-bg-primary)] text-[#EE6D3C] px-3 py-1 rounded-full border border-[#EE6D3C]/20">9 Tables</span>
                            </div>
                            <div class="grid grid-cols-3 gap-y-12 gap-x-6 place-items-center">
                                @for ($i = 1; $i <= 9; $i++)
                                    @php
                                        // Simple logic to vary table sizes visually
                                        $isLarge = in_array($i, [1, 5, 9]);
                                        $capacity = $isLarge ? 4 : 2;
                                    @endphp
                                    <div @click="selectedTable = '{{ $i }}'"
                                         title="Table {{ $i }} ({{ $capacity }} seats)"
                                         class="cursor-pointer group relative rounded-xl shadow-sm flex items-center justify-center transition-all duration-300"
                                         style="width: {{ $isLarge ? '72px' : '64px' }}; height: {{ $isLarge ? '72px' : '64px' }};"
                                         :class="selectedTable == '{{ $i }}'
                                             ? 'bg-[#EE6D3C] scale-110 shadow-lg z-10'
                                             : 'bg-white hover:scale-105 hover:shadow-md hover:bg-orange-50'">
                                        
                                        {{-- Chairs visual decoration --}}
                                        <div class="absolute -top-3 left-1/4 w-1/2 h-2 rounded-t-full transition-colors"
                                             :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-[var(--admin-border)] group-hover:bg-orange-200'"></div>
                                        <div class="absolute -bottom-3 left-1/4 w-1/2 h-2 rounded-b-full transition-colors"
                                             :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-[var(--admin-border)] group-hover:bg-orange-200'"></div>
                                        
                                        @if($isLarge)
                                            <div class="absolute -left-3 top-1/4 w-2 h-1/2 rounded-l-full transition-colors"
                                                 :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-[var(--admin-border)] group-hover:bg-orange-200'"></div>
                                            <div class="absolute -right-3 top-1/4 w-2 h-1/2 rounded-r-full transition-colors"
                                                 :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-[var(--admin-border)] group-hover:bg-orange-200'"></div>
                                        @endif

                                        <div class="flex flex-col items-center">
                                            <span class="font-bold text-xl transition-colors"
                                                  :class="selectedTable == '{{ $i }}' ? 'text-white' : 'text-[var(--admin-text-primary)]'">
                                                {{ $i }}
                                            </span>
                                            <span class="text-[8px] font-bold uppercase tracking-tighter transition-colors"
                                                  :class="selectedTable == '{{ $i }}' ? 'text-orange-200' : 'text-[var(--admin-text-secondary)] group-hover:text-orange-300'">
                                                {{ $capacity }} Seats
                                            </span>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-[var(--admin-border)]">
                        <a href="{{ route('reservations.index') }}"
                            class="px-6 py-3 border border-[var(--admin-border)] text-[var(--admin-text-secondary)] font-bold rounded-xl hover:bg-orange-50/10 transition text-sm text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 bg-[#EE6D3C] hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg transition text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ isset($reservation) ? 'Update Reservation' : 'Confirm Reservation' }}
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>