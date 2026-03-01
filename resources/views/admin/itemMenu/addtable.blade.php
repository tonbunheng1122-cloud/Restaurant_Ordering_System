@vite('resources/css/app.css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ffccbc; border-radius: 10px; }
</style>
<div class="bg-[#FFE4DB] min-h-screen">
    <div class="flex flex-col lg:flex-row min-h-screen p-3 sm:p-4 gap-4 sm:gap-6">
        <aside class="hidden xl:block xl:w-64 flex-shrink-0"> 
            @include('components.asidebar')
        </aside>
        <main class="flex-1 w-full min-w-0 overflow-y-auto custom-scrollbar py-4">
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 overflow-hidden p-4 sm:p-6 lg:p-8 mb-8">
                
                <div class="flex items-center gap-4 mb-6 sm:mb-8">
                    <a href="{{ route('alltable.index') }}" class="bg-[#EE6D3C] text-white p-2 rounded-xl mr-4 hover:scale-105 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl text-gray-800 font-extrabold tracking-tight">
                        {{ isset($reservation) ? 'Edit Table' : 'Add New Table' }}
                    </h2>
                </div>
                <form action="{{ isset($reservation) ? route('reservations.update', $reservation->id) : route('reservations.store') }}" method="POST">
                    @csrf
                    @if(isset($reservation))
                        @method('PUT')
                    @endif
                    <div class="flex flex-col lg:flex-row gap-6 lg:gap-10">

                        <div class="w-full lg:w-1/3 space-y-5">
                            <div class="space-y-1">
                                <label class="block text-gray-500 font-bold ml-1">Full Name</label>
                                <input type="text" name="full_name" required
                                       value="{{ old('full_name', $reservation->full_name ?? '') }}"
                                       class="w-full bg-[#E9EEF2] border-none rounded-xl p-3 focus:ring-2 focus:ring-orange-400 outline-none transition">
                            </div>   
                            <div class="space-y-1">
                                <label class="block text-gray-500 font-bold ml-1">Phone Number</label>
                                <input type="tel" name="phone_number" required
                                       value="{{ old('phone_number', $reservation->phone_number ?? '') }}"
                                       class="w-full bg-[#E9EEF2] border-none rounded-xl p-3 focus:ring-2 focus:ring-orange-400 outline-none transition">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-gray-500 font-bold ml-1">Date</label>
                                <input type="date" name="date" required
                                       value="{{ old('date', $reservation->date ?? '') }}"
                                       class="w-full bg-[#E9EEF2] border-none rounded-xl p-3 focus:ring-2 focus:ring-orange-400 outline-none transition">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-gray-500 font-bold ml-1">Time</label>
                                <input type="time" name="time" required
                                       value="{{ old('time', $reservation->time ?? '') }}"
                                       class="w-full bg-[#E9EEF2] border-none rounded-xl p-3 focus:ring-2 focus:ring-orange-400 outline-none transition">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-gray-500 font-bold ml-1">TableID</label>
                                <input type="text" id="tableIdDisplay" name="table_id" required
                                       value="{{ old('table_id', $reservation->table_id ?? '') }}"
                                       class="w-full bg-[#E9EEF2] border-none rounded-xl p-3 focus:ring-orange-400 outline-none transition"
                                       placeholder="Click a table on the right">
                            </div>
                            <div class="flex gap-4 pt-6">
                                <button type="submit" class="bg-[#EE6D3C] text-white px-12 py-3 rounded-xl font-bold text-xl hover:bg-[#d45a2d] transition-all transform active:scale-95 shadow-md">
                                    {{ isset($reservation) ? 'Update' : 'Submit' }}
                                </button>
                                <a href="{{ route('alltable.index') }}" class="bg-[#D1D1D1] text-white px-12 py-3 rounded-xl font-bold text-xl hover:bg-gray-400 transition-all flex items-center justify-center">
                                    Cancel
                                </a>
                            </div>
                        </div>
                        <div class="w-full lg:w-2/3 bg-[#D9D9D9] rounded-[2rem] p-6 sm:p-8 lg:p-10 min-h-[500px]">
                            <h3 class="text-xl font-bold text-gray-700 mb-8 sm:mb-12">Select Table</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-y-10 sm:gap-y-16 gap-x-6 sm:gap-x-8 place-items-center">
                                @for ($i = 1; $i <= 9; $i++)
                                    @php 
                                        $styleClass = $i <= 3 ? 'relative flex items-center justify-center' : ($i <= 6 ? 'relative w-16 h-16' : 'relative w-28 h-16');
                                    @endphp
                                    <div onclick="document.getElementById('tableIdDisplay').value = '{{ $i }}'" 
                                         class="cursor-pointer group relative w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center">

                                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-7 h-3 bg-white rounded-full group-hover:bg-orange-200"></div>
                                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-7 h-3 bg-white rounded-full group-hover:bg-orange-200"></div>
                                    <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-3 h-7 bg-white rounded-full group-hover:bg-orange-200"></div>
                                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 w-3 h-7 bg-white rounded-full group-hover:bg-orange-200"></div>
                                    <span class="font-bold text-xl">{{ $i }}</span>
                                    </div> 
                                @endfor
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>