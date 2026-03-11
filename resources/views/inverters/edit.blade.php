@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Inverter</h2>
            <p class="text-sm text-gray-500">Updating details for <span class="font-semibold text-blue-600">{{ $inverter->product_name }}</span></p>
        </div>
        <a href="{{ route('inverters.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            Cancel & Return
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('inverters.update', $inverter) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Product Name --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name', $inverter->product_name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                    @error('product_name') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Model --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Model</label>
                    <input type="text" name="model" value="{{ old('model', $inverter->model) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                    @error('model') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Power Rating (Split Logic) --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Power Rating <span class="text-red-400">*</span></label>
                    <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500 transition-all">
                       
                        <input type="text" name="power_rating" step="0.01" value="{{ old('power_rating', $inverter->power_rating) }}" required
                            class="w-full border-none pl-4 py-3 text-sm focus:ring-0" placeholder="e.g. 10KW or 5KVA">
                
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity in Stock <span class="text-red-400">*</span></label>
                    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $inverter->quantity_in_stock) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                {{-- Prices --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Cost Price (₦)</label>
                    <input type="number" name="cost_price" step="0.01" value="{{ old('cost_price', $inverter->cost_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Selling Price (₦)</label>
                    <input type="number" name="selling_price" step="0.01" value="{{ old('selling_price', $inverter->selling_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                {{-- Supplier --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Supplier</label>
                    <input type="text" name="supplier" value="{{ old('supplier', $inverter->supplier) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                {{-- Warranty --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Warranty Info</label>
                    <input type="text" name="warranty" value="{{ old('warranty', $inverter->warranty) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="e.g. 1 Year">
                </div>

                {{-- Description & Remarks --}}
                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Description</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('description', $inverter->description) }}</textarea>
                </div>

                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Admin Remarks</label>
                    <textarea name="remarks" rows="2" placeholder="Internal notes about this update..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('remarks', $inverter->remarks) }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end items-center space-x-4">
                <button type="submit" class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-100 transition-all transform hover:-translate-y-1">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection