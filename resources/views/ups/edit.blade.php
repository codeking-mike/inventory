@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit UPS System</h2>
            <p class="text-sm text-gray-500">Updating <span class="font-semibold text-indigo-600">{{ $up->product_name }}</span></p>
        </div>
        <a href="{{ route('ups.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            Cancel
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        {{-- Fixed the Route Parameter here --}}
        <form action="{{ route('ups.update', $up) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Product Name --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name', $up->product_name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/30">
                </div>

                {{-- Model --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Model / Series</label>
                    <input type="text" name="model" value="{{ old('model', $up->model) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>

                {{-- Power Rating (Concatenated Logic) --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Capacity(KVA) <span class="text-red-400">*</span></label>
                    <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-indigo-500 transition-all">
                        
                        <input type="number" name="power_value" step="0.01" value="{{ old('power_value', $up->power_capacity) }}" required
                            class="w-full border-none pl-4 py-3 text-sm focus:ring-0" placeholder="0">
                        
                    </div>
                </div>

                {{-- Stock --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity in Stock</label>
                    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $up->quantity_in_stock) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>

                {{-- Pricing --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Cost Price (₦)</label>
                    <input type="number" name="cost_price" step="0.01" value="{{ old('cost_price', $up->cost_price) }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-red-50/10">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Selling Price (₦)</label>
                    <input type="number" name="selling_price" step="0.01" value="{{ old('selling_price', $up->selling_price) }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-indigo-50/10">
                </div>

                {{-- Full Width Textareas --}}
                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Description / Internal Notes</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">{{ old('description', $up->description) }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" class="px-10 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1">
                    Update UPS Unit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection