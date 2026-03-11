@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Battery</h2>
            <p class="text-sm text-gray-500">Updating technical specs for <span class="font-semibold text-emerald-600">{{ $battery->product_name }}</span></p>
        </div>
        <a href="{{ route('batteries.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            Cancel & Return
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('batteries.update', $battery) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Product Name --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name', $battery->product_name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition bg-gray-50/30">
                    @error('product_name') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Model --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Model</label>
                    <input type="text" name="model" value="{{ old('model', $battery->model) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Capacity & Voltage Row --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Capacity <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="text" name="capacity" step="0.01" value="{{ old('capacity', $battery->capacity) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition" placeholder="e.g. 200KWh">
                        
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Voltage (V) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="number" name="voltage" step="0.01" value="{{ old('voltage', $battery->voltage) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition" placeholder="e.g. 12">
                        <span class="absolute right-4 top-3 text-gray-400 text-xs font-bold italic">Volts</span>
                    </div>
                </div>

                {{-- Chemistry Dropdown --}}
                 <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Chemistry </label>
                    <input type="text" name="chemistry" value="{{ old('chemistry', $battery->chemistry) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Quantity --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity in Stock <span class="text-red-400">*</span></label>
                    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $battery->quantity_in_stock) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Pricing --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Cost Price (₦)</label>
                    <input type="number" name="cost_price" step="0.01" value="{{ old('cost_price', $battery->cost_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition bg-red-50/10">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Selling Price (₦)</label>
                    <input type="number" name="selling_price" step="0.01" value="{{ old('selling_price', $battery->selling_price) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition bg-emerald-50/10">
                </div>

                {{-- Full Width Areas --}}
                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Description</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('description', $battery->description) }}</textarea>
                </div>

                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Transaction Remarks</label>
                    <textarea name="remarks" rows="2" placeholder="Internal notes..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('remarks', $battery->remarks) }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end items-center">
                <button type="submit" class="px-10 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-100 transition-all transform hover:-translate-y-1">
                    Update Battery Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection