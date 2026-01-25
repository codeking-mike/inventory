@extends('layouts.app')

@section('title', 'Add UPS')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Add New UPS System</h1>
            <p class="text-sm text-gray-500">Configure power protection and backup units in the database.</p>
        </div>
        <a href="{{ route('ups.index') }}" class="text-sm font-medium text-gray-600 hover:text-purple-600 transition-colors">
            &larr; Back to Inventory
        </a>
    </div>

    <form action="{{ route('ups.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-purple-600 mb-4 flex items-center">
                    <span class="mr-2">🔌</span> System Specifications
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-400">*</span></label>
                        <input type="text" name="product_name" class="w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm" placeholder="e.g. APC Smart-UPS" value="{{ old('product_name') }}" required>
                        @error('product_name') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model / Serial Range</label>
                        <input type="text" name="model" class="w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm" placeholder="e.g. SMT1500IC" value="{{ old('model') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Power Capacity (Watts) <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="number" name="power_capacity" step="0.01" class="w-full rounded-lg border-gray-200 pl-10 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm font-bold" placeholder="1000" value="{{ old('power_capacity') }}" required>
                            <span class="absolute left-3 top-2 text-gray-400">W</span>
                        </div>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Typical Backup Time (Minutes)</label>
                        <div class="relative">
                            <input type="number" name="backup_time" step="0.01" class="w-full rounded-lg border-gray-200 pl-10 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm" placeholder="15" value="{{ old('backup_time') }}">
                            <span class="absolute left-3 top-2 text-gray-400">⏱️</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-purple-50/20 border-b border-gray-50">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-600 mb-4">Inventory Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Initial Stock <span class="text-red-400">*</span></label>
                        <input type="number" name="quantity_in_stock" class="w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm" value="{{ old('quantity_in_stock', 0) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cost Price (₦)</label>
                        <input type="number" name="cost_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm text-gray-400" value="{{ old('cost_price') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price (₦)</label>
                        <input type="number" name="selling_price" step="0.01" class="w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm font-bold text-purple-700" value="{{ old('selling_price') }}">
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Remarks</label>
                        <input type="text" name="remarks" class="w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm" value="{{ old('remarks') }}" placeholder="Source, PO Number, or batch details...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Description</label>
                        <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-all shadow-sm" placeholder="Include battery type inside, socket count, or weight...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('ups.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-8 py-2.5 bg-purple-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-purple-100 hover:bg-purple-700 hover:-translate-y-0.5 transition-all">
                Save UPS System
            </button>
        </div>
    </form>
</div>
@endsection