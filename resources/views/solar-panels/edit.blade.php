@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Solar Panel</h2>
            <p class="text-sm text-gray-500">Updating details for <span class="font-semibold text-amber-600">{{ $solarPanel->product_name }}</span></p>
        </div>
        <a href="{{ route('solar-panels.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            Cancel & Return
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('solar-panels.update', $solarPanel) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Product Name --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name', $solarPanel->product_name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition bg-gray-50/30">
                    @error('product_name') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Model --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Model</label>
                    <input type="text" name="model" value="{{ old('model', $solarPanel->model) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition bg-gray-50/30">
                </div>

                {{-- Wattage --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Wattage (W) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        
                        <input type="number" name="wattage" step="0.01" value="{{ old('wattage', $solarPanel->wattage) }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition">
                    </div>
                </div>

                {{-- Cell Type Dropdown --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Cell Type</label>
                    <select name="cell_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition bg-white cursor-pointer">
                        <option value="">Select Cell Type</option>
                        <option value="Monocrystalline" {{ $solarPanel->cell_type == 'Monocrystalline' ? 'selected' : '' }}>Monocrystalline</option>
                        <option value="Polycrystalline" {{ $solarPanel->cell_type == 'Polycrystalline' ? 'selected' : '' }}>Polycrystalline</option>
                        <option value="Thin-Film" {{ $solarPanel->cell_type == 'Thin-Film' ? 'selected' : '' }}>Thin-Film</option>
                    </select>
                </div>

                {{-- Efficiency --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Efficiency (%)</label>
                    <div class="relative">
                        <input type="number" name="efficiency_percentage" step="0.01" min="0" max="100" value="{{ old('efficiency_percentage', $solarPanel->efficiency_percentage) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition">
                        <span class="absolute right-4 top-3 text-gray-400 font-bold">%</span>
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity in Stock <span class="text-red-400">*</span></label>
                    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $solarPanel->quantity_in_stock) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition">
                </div>

                {{-- Prices --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Cost Price (₦)</label>
                    <input type="number" name="cost_price" step="0.01" value="{{ old('cost_price', $solarPanel->cost_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition bg-red-50/20">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Selling Price (₦)</label>
                    <input type="number" name="selling_price" step="0.01" value="{{ old('selling_price', $solarPanel->selling_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition bg-green-50/20">
                </div>

    

                {{-- Description & Remarks --}}
                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Description</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none transition">{{ old('description', $solarPanel->description) }}</textarea>
                </div>

                
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end items-center space-x-4">
                <button type="submit" class="px-10 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg shadow-amber-100 transition-all transform hover:-translate-y-1">
                    Update Solar Panel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection