@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors text-sm mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><path d="m12 5-7 7 7 7"></path></svg>
        Back to Products
    </a>
    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Edit Product</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">{{ $product->name }}</p>
</div>

@if(session('success'))
    <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ $errors->first() }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2">
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 md:p-8">
            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                            class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" required />
                    </div>
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-2">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                            class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-2">Metal Type</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="metal_type" value="gold" class="sr-only peer" {{ old('metal_type', $product->metal_type) === 'gold' ? 'checked' : '' }}>
                                <div class="w-full p-3 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl text-center peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/10 transition-all">
                                    <p class="text-sm font-medium text-white">Gold</p>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="metal_type" value="silver" class="sr-only peer" {{ old('metal_type', $product->metal_type) === 'silver' ? 'checked' : '' }}>
                                <div class="w-full p-3 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl text-center peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/10 transition-all">
                                    <p class="text-sm font-medium text-white">Silver</p>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-2">Weight (grams)</label>
                        <input type="number" name="weight_grams" value="{{ old('weight_grams', $product->weight_grams) }}" step="0.0001" min="0.1"
                            class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" required />
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Stock Quantity</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" required />
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Current Image --}}
                @if($product->image)
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-2">Current Image</label>
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-xl border border-[#D4AF37]/20">
                    </div>
                @endif

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">{{ $product->image ? 'Replace Image' : 'Product Image' }}</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:outline-none transition-colors" />
                    <p class="text-xs text-[#666] mt-1">Max 2MB. JPG, PNG, WebP.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-[#D4AF37]/30 bg-[#141414] text-[#D4AF37]">
                        <span class="text-sm text-[#A0A0A0]">Active (visible to customers)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-[#D4AF37]/30 bg-[#141414] text-[#D4AF37]">
                        <span class="text-sm text-[#A0A0A0]">Featured on homepage</span>
                    </label>
                </div>

                <button type="submit" class="w-full btn-primary justify-center py-3">
                    Update Product
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Product Info --}}
    <div class="space-y-4">
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
            <h3 class="text-white font-semibold mb-4 text-sm">Product Info</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-xs text-[#A0A0A0]">Created</span>
                    <span class="text-xs text-white">{{ $product->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-xs text-[#A0A0A0]">Last Updated</span>
                    <span class="text-xs text-white">{{ $product->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-xs text-[#A0A0A0]">Stock</span>
                    <span class="text-xs text-white">{{ $product->stock }} units</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete this product?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full py-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl text-sm font-medium hover:bg-red-500/20 transition-colors">
                Delete Product
            </button>
        </form>
    </div>

</div>

@endsection