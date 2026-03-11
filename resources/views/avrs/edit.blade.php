@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit AVR</h2>
            <p class="text-sm text-gray-500">Modify specifications for <span class="font-semibold text-cyan-600">{{ $avr->product_name }}</span></p>
        </div>
        <a href="{{ route('avrs.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            Cancel & Return
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('avrs.update', $avr) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Product Name --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name', $avr->product_name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition bg-gray-50/30">
                    @error('product_name') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Model --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Model</label>
                    <input type="text" name="model" value="{{ old('model', $avr->model) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">
                    @error('model') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Capacity --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Capacity (KVA) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="number" name="capacity" step="0.01" value="{{ old('capacity', $avr->capacity) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">
                        <span class="absolute right-4 top-3 text-gray-400 text-xs font-bold italic">KVA</span>
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity in Stock <span class="text-red-400">*</span></label>
                    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $avr->quantity_in_stock) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">
                </div>

                {{-- Pricing --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Cost Price (₦)</label>
                    <input type="number" name="cost_price" step="0.01" value="{{ old('cost_price', $avr->cost_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition bg-red-50/10">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Selling Price (₦)</label>
                    <input type="number" name="selling_price" step="0.01" value="{{ old('selling_price', $avr->selling_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition bg-cyan-50/10">
                </div>

                {{-- Description & Remarks --}}
                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Description</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">{{ old('description', $avr->description) }}</textarea>
                </div>

                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Update Remarks</label>
                    <textarea name="remarks" rows="2" placeholder="Reason for this change..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">{{ old('remarks') }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" class="px-10 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-xl shadow-lg shadow-cyan-100 transition-all transform hover:-translate-y-1">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection