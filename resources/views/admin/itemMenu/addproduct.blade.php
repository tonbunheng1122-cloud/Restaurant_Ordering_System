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

        <main class="flex-1 w-full">
            <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 md:p-8 mt-4 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <a href="{{ route('allproduct.index') }}" class="bg-[#EE6D3C] text-white p-2 rounded-xl hover:scale-105 transition shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    </a>
                    <h2 class="text-xl sm:text-3xl text-gray-800 font-bold">
                        {{ isset($product) ? 'Edit Product' : 'Create Product' }}
                    </h2>
                </div>

                <form action="{{ isset($product) ? route('product.update', $product->id) : route('addproduct.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($product)) @method('PUT') @endif

                    <div class="flex flex-col xl:flex-row gap-8 xl:gap-12">
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2">
                                <label class="font-bold">Name*</label>
                                <input type="text" name="name" required value="{{ old('name', $product->name ?? '') }}" class="bg-[#E9E9E9] rounded-xl p-3 outline-none focus:ring-2 focus:ring-orange-200">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-bold">Qty*</label>
                                <input type="number" name="qty" required value="{{ old('qty', $product->qty ?? '') }}" class="bg-[#E9E9E9] rounded-xl p-3 outline-none focus:ring-2 focus:ring-orange-200">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-bold">Price*</label>
                                <input type="text" name="price" required value="{{ old('price', $product->price ?? '') }}" class="bg-[#E9E9E9] rounded-xl p-3 outline-none focus:ring-2 focus:ring-orange-200">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-bold">Cost*</label>
                                <input type="text" name="cost" required value="{{ old('cost', $product->cost ?? '') }}" class="bg-[#E9E9E9] rounded-xl p-3 outline-none focus:ring-2 focus:ring-orange-200">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-bold">Category*</label>
                                <select name="category_id" required class="bg-[#E9E9E9] rounded-xl p-3 outline-none focus:ring-2 focus:ring-orange-200">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-bold">Count*</label>
                                <input type="number" name="count" required value="{{ old('count', $product->count ?? 0) }}" class="bg-[#E9E9E9] rounded-xl p-3 outline-none focus:ring-2 focus:ring-orange-200">
                            </div>
                            <div class="sm:col-span-2 flex flex-col gap-2 mt-2">
                                <label class="font-bold">Description</label>
                                <textarea name="description" rows="5" class="border-2 border-gray-800 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-orange-100">{{ old('description', $product->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="w-full xl:w-1/3">
                            <label class="font-bold block mb-4">Product Images</label>
                            <div class="relative group aspect-square">
                                <input type="file" name="images" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="bg-[#D9D9D9] rounded-xl w-full h-full flex items-center justify-center border-4 border-dashed border-white overflow-hidden">
                                    @if(isset($product) && $product->images && is_array($product->images))
                                        <img src="{{ asset('storage/' . $product->images[0]) }}" class="w-full h-full object-cover">
                                    @else
                                        <p class="text-white">Click to upload</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-[#EE6D3C] text-white px-14 py-3 rounded-xl font-bold hover:bg-[#d45a2d] transition-all shadow-md">
                            {{ isset($product) ? 'Update Product' : 'Save Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>