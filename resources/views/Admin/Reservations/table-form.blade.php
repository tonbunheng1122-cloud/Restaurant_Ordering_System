@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Flavor Unleashed</title>

<div class="bg-[#FFE4DB] min-h-screen" x-data="{ mobileMenuOpen: false, selectedTable: '{{ old('table_id', $reservation->table_id ?? '') }}' }">
    <div class="flex flex-col md:flex-row md:h-screen md:p-4 md:gap-6 md:overflow-hidden relative">

        @include('components.asidebar')

        <main class="flex-1 overflow-y-auto px-3 pb-4 md:px-0 md:pr-2 custom-scrollbar">
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-3 md:mt-0 mb-8">

                @include('components.alerts')

                <!-- Header -->
                <div class="flex items-center gap-3 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ isset($reservation) ? 'Edit Reservation' : 'Add New Reservation' }}
                    </h2>
                    <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">
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
                                <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Full Name *</label>
                                <input type="text" name="full_name" required
                                    value="{{ old('full_name', $reservation->full_name ?? '') }}"
                                    placeholder="Enter full name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                        @error('full_name') border-red-400 @enderror">
                                @error('full_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Phone Number *</label>
                                <input type="tel" name="phone_number" required
                                    value="{{ old('phone_number', $reservation->phone_number ?? '') }}"
                                    placeholder="+1 234 567 8900"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                        @error('phone_number') border-red-400 @enderror">
                                @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-2">
                                    <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Date *</label>
                                    <input type="date" name="date" required
                                        value="{{ old('date', $reservation->date ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                            @error('date') border-red-400 @enderror">
                                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Time *</label>
                                    <input type="time" name="time" required
                                        value="{{ old('time', $reservation->time ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                            @error('time') border-red-400 @enderror">
                                    @error('time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Selected Table *</label>
                                <div class="relative">
                                    <input type="text" name="table_id" required readonly
                                        :value="selectedTable"
                                        placeholder="Click a table on the right →"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm bg-gray-50 cursor-default transition"
                                        :class="selectedTable ? 'border-orange-300 bg-orange-50 text-[#EE6D3C] font-bold' : ''">
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

                        <div class="w-full lg:flex-1 bg-gray-100 border border-gray-100 rounded-2xl p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-8">
                                <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wide">Select Table</h3>
                                <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">9 Tables</span>
                            </div>
                            <div class="grid grid-cols-3 gap-y-12 gap-x-6 place-items-center">
                                @for ($i = 1; $i <= 9; $i++)
                                    <div @click="selectedTable = '{{ $i }}'"
                                         class="cursor-pointer group relative w-16 h-16 rounded-xl shadow-sm flex items-center justify-center transition-all duration-200"
                                         :class="selectedTable == '{{ $i }}'
                                             ? 'bg-[#EE6D3C] scale-110 shadow-md'
                                             : 'bg-white hover:scale-105 hover:shadow-md'">
                                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-7 h-3 rounded-full transition-colors"
                                             :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-white group-hover:bg-orange-200'"></div>
                                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-7 h-3 rounded-full transition-colors"
                                             :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-white group-hover:bg-orange-200'"></div>
                                        <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-3 h-7 rounded-full transition-colors"
                                             :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-white group-hover:bg-orange-200'"></div>
                                        <div class="absolute -right-4 top-1/2 -translate-y-1/2 w-3 h-7 rounded-full transition-colors"
                                             :class="selectedTable == '{{ $i }}' ? 'bg-orange-300' : 'bg-white group-hover:bg-orange-200'"></div>
                                        <span class="font-bold text-xl transition-colors"
                                              :class="selectedTable == '{{ $i }}' ? 'text-white' : 'text-gray-700'">
                                            {{ $i }}
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('reservations.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition text-sm text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 bg-gray-900 hover:bg-gray-700 text-white font-bold rounded-xl transition text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ isset($reservation) ? 'Update Reservation' : 'Save Reservation' }}
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>