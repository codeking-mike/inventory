@extends('layouts.app')

@section('title', 'Add Solar Panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Solar Panel</h1>
            <p class="text-sm text-gray-500">Register new photovoltaic modules into the inventory system.</p>
        </div>
        <a href="{{ route('solar-panels.index') }}" class="text-sm font-medium text-gray-600 hover:text-amber-600 transition-colors">
            &larr; Back to Inventory
        </a>
    </div>

    <form action="{{ route('solar-panels.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-amber-600 mb-4 flex items-center">
                    <span class="mr-2">☀️</span> Technical Specifications
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-400">*</span></label>
                        <input type="text" name="product_name" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm" placeholder="e.g. Jinko Tiger Pro" value="{{ old('product_name') }}" required>
                        @error('product_name') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model / Series</label>
                        <input type="text" name="model" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm" placeholder="e.g. Mono-Perc 545W" value="{{ old('model') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cell Type</label>
                        <select name="cell_type" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm bg-white">
                            <option value="">Select Type</option>
                            <option value="Monocrystalline" {{ old('cell_type') == 'Monocrystalline' ? 'selected' : '' }}>Monocrystalline</option>
                            <option value="Polycrystalline" {{ old('cell_type') == 'Polycrystalline' ? 'selected' : '' }}>Polycrystalline</option>
                            <option value="Thin-Film" {{ old('cell_type') == 'Thin-Film' ? 'selected' : '' }}>Thin-Film</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Wattage (Wp) <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="number" name="wattage" step="0.01" class="w-full rounded-lg border-gray-200 pl-10 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm font-bold" placeholder="545" value="{{ old('wattage') }}" required>
                            <span class="absolute left-3 top-2 text-gray-400">⚡</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Efficiency (%)</label>
                        <div class="relative">
                            <input type="number" name="efficiency_percentage" step="0.01" min="0" max="100" class="w-full rounded-lg border-gray-200 pl-10 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm" placeholder="21.5" value="{{ old('efficiency_percentage') }}">
                            <span class="absolute left-3 top-2 text-gray-400">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-amber-50/20 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-600 mb-4">Stock & Pricing</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity in Stock <span class="text-red-400">*</span></label>
                        <input type="number" name="quantity_in_stock" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm" value="{{ old('quantity_in_stock', 0) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cost Price (₦)</label>
                        <input type="number" name="cost_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm text-gray-500" value="{{ old('cost_price') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price (₦)</label>
                        <input type="number" name="selling_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm font-bold text-amber-700" value="{{ old('selling_price') }}">
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Remarks</label>
                        <input type="text" name="remarks" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm" value="{{ old('remarks') }}" placeholder="Batch number or special handling notes...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                        <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition-all shadow-sm" placeholder="Frame color, dimensions, warranty info, etc.">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('solar-panels.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-xl transition-all">
                Cancel
            </a>
            <button type="submit" class="px-8 py-2.5 bg-amber-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-amber-100 hover:bg-amber-600 hover:-translate-y-0.5 transition-all focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                Save Solar Panel
            </button>
        </div>
    </form>
</div>
@endsection