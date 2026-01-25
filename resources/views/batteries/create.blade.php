@extends('layouts.app')

@section('title', 'Add Battery')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Battery</h1>
            <p class="text-sm text-gray-500">Log new energy storage units into the system.</p>
        </div>
        <a href="{{ route('batteries.index') }}" class="text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">
            &larr; Back to Inventory
        </a>
    </div>

    <form action="{{ route('batteries.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-orange-600 mb-4 flex items-center">
                    <span class="mr-2">🔋</span> Technical Specifications
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-400">*</span></label>
                        <input type="text" name="product_name" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm" placeholder="e.g. Quanta Tubular Battery" value="{{ old('product_name') }}" required>
                        @error('product_name') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model / Series</label>
                        <input type="text" name="model" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm" placeholder="e.g. 12V / 200Ah Slim" value="{{ old('model') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Battery Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm bg-white">
                            <option value="">Select Battery Type</option>
                            <option value="Tubular">Tubular</option>
                            <option value="AGM / VRLA">AGM / VRLA</option>
                            <option value="Gel">Gel</option>
                            <option value="Lithium (LiFePO4)">Lithium (LiFePO4)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Voltage (V) <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="number" name="voltage" step="0.01" class="w-full rounded-lg border-gray-200 pl-10 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm" placeholder="12" value="{{ old('voltage') }}" required>
                            <span class="absolute left-3 top-2 text-gray-400 font-bold text-xs">V</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Capacity (Ah) <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="number" name="capacity" step="0.01" class="w-full rounded-lg border-gray-200 pl-10 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm font-bold" placeholder="200" value="{{ old('capacity') }}" required>
                            <span class="absolute left-3 top-2 text-gray-400 text-xs">Ah</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-orange-50/20 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-600 mb-4">Pricing & Stock</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock Count <span class="text-red-400">*</span></label>
                        <input type="number" name="quantity_in_stock" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm" value="{{ old('quantity_in_stock', 0) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cost Price (₦)</label>
                        <input type="number" name="cost_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm text-gray-500" value="{{ old('cost_price') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price (₦)</label>
                        <input type="number" name="selling_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm font-bold text-orange-700" value="{{ old('selling_price') }}">
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier & Warranty</label>
                        <input type="text" name="warranty" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm" value="{{ old('warranty') }}" placeholder="e.g. 18 Months Warranty - Simba Group">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description / Remarks</label>
                        <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-all shadow-sm" placeholder="Specific weight, cycle life, or internal storage notes...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('batteries.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-xl transition-all">
                Cancel
            </a>
            <button type="submit" class="px-8 py-2.5 bg-orange-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-100 hover:bg-orange-700 hover:-translate-y-0.5 transition-all">
                Save Battery
            </button>
        </div>
    </form>
</div>
@endsection