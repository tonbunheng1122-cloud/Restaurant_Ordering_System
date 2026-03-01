@vite('resources/css/app.css')
<style> 
    body { font-family: 'Inter', sans-serif; } 

    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ed8936; border-radius: 10px; }
</style>

<div class="bg-[#FFE4DB] min-h-screen">
    <div class="flex flex-col md:flex-row h-screen p-4 gap-6 overflow-hidden">
        
        <aside class="hidden xl:block xl:w-64 flex-shrink-0"> 
            @include('components.asidebar')
        </aside>

        <main class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 px-6 md:px-10 py-6 md:py-10 mt-4 mb-8">
                
                <div class="flex items-center gap-4 mb-6 sm:mb-8">
                    <a href="{{ route('allcategory.index') }}" class="bg-[#EE6D3C] text-white p-2 rounded-xl mr-4 hover:scale-105 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h2 class="text-2xl md:text-3xl text-gray-800 font-bold tracking-tight">
                        {{ isset($category) ? 'Edit Category' : 'Create New Category' }}
                    </h2>
                </div>

                <form action="{{ isset($category) ? route('category.update', $category->id) : route('addcategory.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif

                    <div class="flex flex-col xl:flex-row gap-10">
                        
                        <div class="flex-1 flex flex-col gap-6 md:max-w-2xl"> 
                            
                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-gray-800 text-lg md:text-xl">Category Name*</label>
                                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required placeholder="Enter category name" 
                                    class="bg-[#E9E9E9] rounded-xl p-3 md:p-3 outline-none focus:ring-2 focus:ring-orange-200 transition text-base md:text-lg w-full @error('name') border border-red-500 @enderror">
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-3">
                                <label class="font-bold text-gray-800 text-lg md:text-xl">Description</label>
                                <textarea name="description" rows="6" placeholder="Enter description here..."
                                    class="bg-[#E9E9E9] rounded-2xl p-4 md:p-6 outline-none focus:ring-2 focus:ring-orange-200 resize-none transition text-base md:text-lg w-full">{{ old('description', $category->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="w-full xl:w-1/3">
                            <label class="font-bold text-gray-800 text-lg md:text-xl block mb-4">Category Image</label>
                            <div class="relative group">
                                <input type="file" name="image" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="bg-[#E9E9E9] rounded-2xl aspect-square flex flex-col items-center justify-center border-4 border-dashed border-gray-300 group-hover:border-[#EE6D3C] transition">
                                    <div class="text-center p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 group-hover:text-[#EE6D3C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <p class="mt-2 text-gray-500 font-medium">Click to upload image</p>
                                    </div>
                                </div>
                            </div>

                            @if(isset($category) && $category->image)
                                <div class="mt-4">
                                    <p class="text-gray-600 mb-2">Current Image:</p>
                                    <img src="{{ asset('storage/'.$category->image) }}" class="w-32 h-32 object-cover rounded-xl shadow">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-4 mt-10 md:mt-16 border-t pt-8">
                        <button type="submit" 
                            class="bg-[#EE6D3C] text-white px-12 py-3 rounded-xl font-bold text-lg md:text-xl hover:bg-[#d45a2d] 
                            transition-all transform active:scale-95 shadow-md w-full sm:w-auto">
                            {{ isset($category) ? 'Update Category' : 'Save Category' }}
                        </button>
                        <a href="{{ route('allcategory.index') }}" 
                            class="bg-[#9E9E9E] text-white px-12 py-3 rounded-xl font-bold text-lg md:text-xl hover:bg-gray-500 
                            transition-all text-center w-full sm:w-auto">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>