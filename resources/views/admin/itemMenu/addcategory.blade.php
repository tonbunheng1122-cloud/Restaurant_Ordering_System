@vite('resources/css/app.css')
<style> 
    body { font-family: 'Inter', sans-serif; } 

    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ed8936; border-radius: 10px; }
</style>

<div class="bg-[#FFE4DB] min-h-screen">
    <div class="flex flex-col md:flex-row h-screen p-4 gap-6 overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="hidden xl:block xl:w-64 flex-shrink-0"> 
            @include('components.asidebar')
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 px-6 md:px-10 py-6 md:py-10 mt-4 mb-8">
                
                <!-- Header -->
                    <div class="flex items-center gap-4 mb-6 sm:mb-8">
                    <a href="{{ route('allcategory.index') }}" class="bg-[#EE6D3C] text-white p-2 rounded-xl mr-4 hover:scale-105 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                    <h2 class="text-2xl md:text-3xl text-gray-800 font-bold tracking-tight">Create New Category</h2>
                </div>

                <!-- Form -->
                <form action="{{ route('addcategory.index') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-6 md:max-w-2xl"> 
                        
                        <!-- Category Name -->
                        <div class="flex flex-col gap-3">
                            <label class="font-bold text-gray-800 text-lg md:text-xl">Category Name</label>
                            <input type="text" name="name" required placeholder="Enter category name" 
                                class="bg-[#E9E9E9] rounded-xl p-3 md:p-3 outline-none focus:ring-2 focus:ring-orange-200 transition text-base md:text-lg w-full">
                        </div>

                        <!-- Description -->
                        <div class="flex flex-col gap-3">
                            <label class="font-bold text-gray-800 text-lg md:text-xl">Description</label>
                            <textarea name="description" rows="6" md:rows="12" placeholder="Enter description here..."
                                class="bg-[#E9E9E9] rounded-2xl p-4 md:p-6 outline-none focus:ring-2 focus:ring-orange-200 resize-none transition text-base md:text-lg w-full">
                            </textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end gap-4 mt-6 md:mt-16">
                        <button type="submit" 
                            class="bg-[#EE6D3C] text-white px-10 py-3 rounded-xl font-bold text-lg md:text-xl hover:bg-[#d45a2d] 
                            transition-all transform active:scale-95 shadow-md w-full sm:w-auto">
                            Save
                        </button>
                        <a href="{{ route('allcategory.index') }}" 
                            class="bg-[#9E9E9E] text-white px-10 py-3 rounded-xl font-bold text-lg md:text-xl hover:bg-gray-500 
                            transition-all text-center w-full sm:w-auto">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
