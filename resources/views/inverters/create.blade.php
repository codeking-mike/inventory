@extends('layouts.app')

@section('title', 'Add Inverter')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Inverter</h1>
            <p class="text-sm text-gray-500">Enter the specifications and initial stock for the new unit.</p>
        </div>
        <a href="{{ route('inverters.index') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
            &larr; Back to List
        </a>
    </div>

    <form action="{{ route('inverters.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-600 mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-400">*</span></label>
                        <input type="text" name="product_name" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" placeholder="e.g. Luminous Eco Watt" value="{{ old('product_name') }}" required>
                        @error('product_name') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model / Series</label>
                        <input type="text" name="model" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" placeholder="e.g. 1500VA/24V" value="{{ old('model') }}">
                        @error('model') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Power Rating <span class="text-red-400">*</span>
                        </label>
                        <div class="flex shadow-sm rounded-lg overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                            {{-- Icon & Number Input --}}
                            <div class="relative flex-grow">
                                <span class="absolute left-3 top-2.5 text-gray-400 text-sm">⚡</span>
                                <input type="number" 
                                    name="power_value" 
                                    step="0.01" 
                                    class="w-full border-none pl-9 py-2.5 focus:ring-0 text-sm" 
                                    placeholder="1200" 
                                    value="{{ old('power_value') }}" 
                                    required>
                            </div>
                            
                            {{-- Unit Dropdown --}}
                            <select name="power_unit" class="bg-gray-50 border-none border-l border-gray-200 text-gray-600 text-sm px-4 focus:ring-0 cursor-pointer">
                                <option value="KW" {{ old('power_unit') == 'KW' ? 'selected' : '' }}>KW</option>
                                <option value="KVA" {{ old('power_unit') == 'KVA' ? 'selected' : '' }}>KVA</option>
                            </select>
                        </div>
                        
                        @error('power_value') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity in Stock <span class="text-red-400">*</span></label>
                        <input type="number" name="quantity_in_stock" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" value="{{ old('quantity_in_stock', 0) }}" required>
                        @error('quantity_in_stock') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-50/30 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-emerald-600 mb-4">Pricing & Supplier</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cost Price (₦)</label>
                        <input type="number" name="cost_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" value="{{ old('cost_price') }}">
                        @error('cost_price') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price (₦)</label>
                        <input type="number" name="selling_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm font-bold text-blue-600" value="{{ old('selling_price') }}">
                        @error('selling_price') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name</label>
                        <input type="text" name="supplier" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" value="{{ old('supplier') }}">
                        @error('supplier') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warranty Period</label>
                        <input type="text" name="warranty" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" value="{{ old('warranty') }}" placeholder="e.g. 12 Months Replacement">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Remarks</label>
                        <input type="text" name="remarks" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" value="{{ old('remarks') }}" placeholder="Internal notes for this entry">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" placeholder="Key features, limitations, etc.">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('inverters.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200 rounded-xl transition-all">
                Cancel
            </a>
            <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection