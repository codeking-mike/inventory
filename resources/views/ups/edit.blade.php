@extends('layouts.app')

@section('title', 'Edit UPS')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Edit UPS System</h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('ups.update', $ups) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Product Name*</label>
                <input type="text" name="product_name" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('product_name', $ups->product_name) }}" required>
                @error('product_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Model</label>
                <input type="text" name="model" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('model', $ups->model) }}">
                @error('model') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Power Capacity (Watts)*</label>
                <input type="number" name="power_capacity" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('power_capacity', $ups->power_capacity) }}" required>
                @error('power_capacity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Backup Time (Minutes)</label>
                <input type="number" name="backup_time" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('backup_time', $ups->backup_time) }}">
                @error('backup_time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Quantity in Stock*</label>
                <input type="number" name="quantity_in_stock" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('quantity_in_stock', $ups->quantity_in_stock) }}" required>
                @error('quantity_in_stock') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Cost Price*</label>
                    <input type="number" name="cost_price" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('cost_price', $ups->cost_price) }}" required>
                    @error('cost_price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Selling Price*</label>
                    <input type="number" name="selling_price" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('selling_price', $ups->selling_price) }}" required>
                    @error('selling_price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Supplier</label>
                <input type="text" name="supplier" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('supplier', $ups->supplier) }}">
                @error('supplier') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $ups->description) }}</textarea>
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Warranty</label>
                <input type="text" name="warranty" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('warranty', $ups->warranty) }}" placeholder="e.g., 2 years">
                @error('warranty') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Transaction Remarks</label>
                <textarea name="remarks" rows="3" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Add any remarks about this transaction...">{{ old('remarks') }}</textarea>
                @error('remarks') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded">Update UPS</button>
                <a href="{{ route('ups.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
