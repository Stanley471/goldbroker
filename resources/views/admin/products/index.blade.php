@extends('layouts.admin')

@section('content')

<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Products</h1>
        <p class="text-[#A0A0A0] text-sm mt-1">Manage gold and silver products</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-primary whitespace-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
        Add Product
    </a>
</div>

@if(session('success'))
    <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
@endif

<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Product</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Metal</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden md:table-cell">Weight</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden md:table-cell">Price</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Stock</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden lg:table-cell">Status</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg">
                                @else
                                    <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                        <span class="text-[#D4AF37] text-xs">{{ strtoupper(substr($product->metal_type, 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $product->name }}</p>
                                    <p class="text-[#666] text-xs">{{ $product->brand ?? 'No brand' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 hidden sm:table-cell">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->metal_type === 'gold' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ ucfirst($product->metal_type) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right text-sm text-[#A0A0A0] hidden md:table-cell">{{ $product->weight_grams }}g</td>
                        <td class="py-4 px-6 text-right text-sm text-[#D4AF37] font-semibold hidden md:table-cell">
                            @if($goldPrice)
                                ${{ number_format($product->current_price, 2) }}
                            @else
                                --
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right text-sm text-white hidden sm:table-cell">{{ $product->stock }}</td>
                        <td class="py-4 px-6 hidden lg:table-cell">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($product->is_featured)
                                    <span class="px-2 py-1 text-xs rounded-full bg-[#D4AF37]/20 text-[#D4AF37]">Featured</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-10 text-[#666]">No products yet. Add your first product.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-[#D4AF37]/10">
        {{ $products->links() }}
    </div>
</div>

@endsection