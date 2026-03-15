@vite('resources/css/app.css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    body { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #EE6D3C; border-radius: 10px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
<title>FastBite | Flavor Unleashed</title>

<div class="bg-[#FFE4DB] min-h-screen">
    <div class="flex h-screen p-2 md:p-4 gap-4 md:gap-6 overflow-hidden">

        <!-- Sidebar -->
        <aside>
            @include('components.asidebar')
        </aside>

        <main class="flex-1 overflow-y-auto pr-1 md:pr-2 custom-scrollbar">

            <!-- Mobile menu button -->
            <button class="bg-[#EE6D3C] text-white p-3 rounded-2xl shadow-lg block md:hidden mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">

                <!-- Header -->
                <div class="flex items-center gap-3 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ isset($category) ? 'Edit Category' : 'Create New Category' }}
                    </h2>
                    <span class="text-xs font-bold bg-[#FFE4DB] text-[#EE6D3C] px-3 py-1 rounded-full">
                        {{ isset($category) ? 'Editing' : 'New' }}
                    </span>
                </div>

                <!-- Form -->
                <form action="{{ isset($category) ? route('category.update', $category->id) : route('addcategory.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      x-data="{
                          previewUrl: '{{ isset($category) && $category->image ? asset('storage/'.$category->image) : '' }}',
                          handleFile(e) {
                              const file = e.target.files[0];
                              if (file) this.previewUrl = URL.createObjectURL(file);
                          }
                      }">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif

                    <div class="flex flex-col xl:flex-row gap-8">

                        <!-- Left: Fields -->
                        <div class="flex-1 flex flex-col gap-6">

                            <!-- Category Name -->
                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Category Name *</label>
                                <input type="text" name="name"
                                    value="{{ old('name', $category->name ?? '') }}"
                                    required
                                    placeholder="Enter category name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm transition
                                        @error('name') border-red-400 @enderror">
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="flex flex-col gap-2">
                                <label class="font-bold text-gray-700 text-sm uppercase tracking-wide">Description</label>
                                <textarea name="description" rows="6"
                                    placeholder="Enter description here..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-orange-200 text-sm resize-none transition">{{ old('description', $category->description ?? '') }}</textarea>
                            </div>

                        </div>

                        <!-- Right: Image Upload -->
                        <div class="w-full xl:w-80 flex-shrink-0">
                            <label class="font-bold text-gray-700 text-sm uppercase tracking-wide block mb-3">Category Image</label>

                            <div class="relative group rounded-xl border-2 border-dashed border-gray-300 hover:border-[#EE6D3C] transition overflow-hidden bg-gray-50 aspect-square flex items-center justify-center cursor-pointer">

                                <!-- Hidden file input -->
                                <input type="file" name="image" accept="image/*"
                                    @change="handleFile($event)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                <!-- Preview or placeholder -->
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" class="w-full h-full object-cover absolute inset-0">
                                </template>

                                <template x-if="!previewUrl">
                                    <div class="text-center p-6 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 group-hover:text-[#EE6D3C] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mt-3 text-sm text-gray-400 group-hover:text-[#EE6D3C] font-medium transition">Click to upload image</p>
                                        <p class="text-xs text-gray-300 mt-1">PNG, JPG, WEBP</p>
                                    </div>
                                </template>

                                <!-- Overlay on hover when image exists -->
                                <template x-if="previewUrl">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center z-0 pointer-events-none">
                                        <p class="text-white text-sm font-bold">Change Image</p>
                                    </div>
                                </template>

                            </div>
                        </div>

                    </div>

                    <!-- Footer Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('allcategory.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition text-sm text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 bg-gray-900 hover:bg-gray-700 text-white font-bold rounded-xl transition text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ isset($category) ? 'Update Category' : 'Save Category' }}
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>