@vite('resources/css/app.css')
<style> 
    body { font-family: 'Inter', sans-serif; } 
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ed8936; border-radius: 10px; }
</style>

<div class="bg-[#FFE4DB] min-h-screen">

    <!-- Layout -->
    <div class="flex flex-col lg:flex-row min-h-screen p-3 sm:p-4 gap-4 sm:gap-6">

        <!-- Sidebar -->
        <aside class="hidden xl:block xl:w-64 flex-shrink-0"> 
            @include('components.asidebar')
        </aside>
        <!-- Main -->
        <main class="flex-1 w-full">

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 
                        px-4 sm:px-6 md:px-10 
                        py-6 sm:py-8 md:py-10 
                        mt-2 sm:mt-4 mb-6 sm:mb-8">

                <!-- Header -->
                <div class="flex items-center gap-4 mb-6 sm:mb-8">
                    <a href="{{ route('allproduct.index') }}" class="bg-[#EE6D3C] text-white p-2 rounded-xl mr-4 hover:scale-105 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                    <h2 class="text-xl sm:text-2xl md:text-3xl text-gray-800 font-bold tracking-tight">
                        Create Product
                    </h2>
                </div>

                <!-- Form -->
                <form action="{{ route('addproduct.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="flex flex-col xl:flex-row gap-8 xl:gap-12">

                        <!-- LEFT SIDE -->
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

                            <!-- Input Fields -->
                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-800 text-sm sm:text-base">Name*</label>
                                <input type="text" name="name" required
                                    class="bg-[#E9E9E9] rounded-xl p-3 sm:p-3 w-full outline-none focus:ring-2 focus:ring-orange-200">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-800 text-sm sm:text-base">Qty*</label>
                                <input type="number" name="qty" required
                                    class="bg-[#E9E9E9] rounded-xl p-3 sm:p-3 w-full outline-none focus:ring-2 focus:ring-orange-200">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-800 text-sm sm:text-base">Price*</label>
                                <input type="text" name="price" required
                                    class="bg-[#E9E9E9] rounded-xl p-3 sm:p-3 w-full outline-none focus:ring-2 focus:ring-orange-200">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-800 text-sm sm:text-base">Cost*</label>
                                <input type="text" name="cost" required
                                    class="bg-[#E9E9E9] rounded-xl p-3 sm:p-3 w-full outline-none focus:ring-2 focus:ring-orange-200">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-800 text-sm sm:text-base">Category*</label>
                                <select name="category" required
                                    class="bg-[#E9E9E9] rounded-xl p-3 sm:p-3 w-full outline-none focus:ring-2 focus:ring-orange-200">
                                    <option value="">Select Category</option>
                                </select>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-800 text-sm sm:text-base">Count*</label>
                                <input type="number" name="count" required
                                    class="bg-[#E9E9E9] rounded-xl p-3 sm:p-3 w-full outline-none focus:ring-2 focus:ring-orange-200">
                            </div>

                            <!-- Description -->
                            <div class="sm:col-span-2 flex flex-col gap-2 mt-2">
                                <label class="font-bold text-gray-800 text-sm sm:text-base">Add Description</label>
                                <textarea name="description" rows="5"
                                    class="border-2 border-gray-800 rounded-2xl p-3 sm:p-4 w-full resize-none outline-none focus:ring-2 focus:ring-orange-100"></textarea>
                            </div>

                        </div>

                        <!-- RIGHT SIDE (IMAGE) -->
                        <div class="w-full xl:w-1/3">

                            <label class="font-bold text-gray-800 text-base sm:text-lg block mb-4">
                                Multiple Images
                            </label>

                            <div class="relative group">
                                <input type="file" name="images[]" multiple
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                <div class="bg-[#D9D9D9] rounded-xl aspect-square 
                                            flex items-center justify-center 
                                            border-4 border-dashed border-white">

                                    <div class="text-center text-white px-4">
                                        <p class="text-sm sm:text-base font-medium">
                                            Click or Drag Images
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="bg-[#EE6D3C] text-white 
                                   px-10 sm:px-14 
                                   py-3 rounded-xl 
                                   font-bold text-base sm:text-lg 
                                   hover:bg-[#d45a2d] 
                                   transition-all 
                                   active:scale-95 
                                   shadow-md 
                                   w-full sm:w-auto">
                            Save
                        </button>
                    </div>

                </form>

            </div>

        </main>

    </div>
</div>