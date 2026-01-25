@extends('layouts.app')

@section('title', 'Edit Battery')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Edit Battery</h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('batteries.update', $battery) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Product Name*</label>
                <input type="text" name="product_name" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('product_name', $battery->product_name) }}" required>
                @error('product_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Model</label>
                <input type="text" name="model" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('model', $battery->model) }}">
                @error('model') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Capacity (Ah)*</label>
                <input type="number" name="capacity" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('capacity', $battery->capacity) }}" required>
                @error('capacity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Voltage (V)*</label>
                <input type="number" name="voltage" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('voltage', $battery->voltage) }}" required>
                @error('voltage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Chemistry</label>
                <select name="chemistry" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">Select Chemistry</option>
                    <option value="Lithium" {{ $battery->chemistry == 'Lithium' ? 'selected' : '' }}>Lithium</option>
                    <option value="Lead-acid" {{ $battery->chemistry == 'Lead-acid' ? 'selected' : '' }}>Lead-acid</option>
                    <option value="LiFePO4" {{ $battery->chemistry == 'LiFePO4' ? 'selected' : '' }}>LiFePO4</option>
                    <option value="Gel" {{ $battery->chemistry == 'Gel' ? 'selected' : '' }}>Gel</option>
                    <option value="AGM" {{ $battery->chemistry == 'AGM' ? 'selected' : '' }}>AGM</option>
                </select>
                @error('chemistry') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Quantity in Stock*</label>
                <input type="number" name="quantity_in_stock" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('quantity_in_stock', $battery->quantity_in_stock) }}" required>
                @error('quantity_in_stock') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Cost Price*</label>
                    <input type="number" name="cost_price" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('cost_price', $battery->cost_price) }}" required>
                    @error('cost_price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Selling Price*</label>
                    <input type="number" name="selling_price" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('selling_price', $battery->selling_price) }}" required>
                    @error('selling_price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Supplier</label>
                <input type="text" name="supplier" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('supplier', $battery->supplier) }}">
                @error('supplier') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $battery->description) }}</textarea>
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Warranty</label>
                <input type="text" name="warranty" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('warranty', $battery->warranty) }}" placeholder="e.g., 2 years">
                @error('warranty') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Transaction Remarks</label>
                <textarea name="remarks" rows="3" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Add any remarks about this transaction...">{{ old('remarks') }}</textarea>
                @error('remarks') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded">Update Battery</button>
                <a href="{{ route('batteries.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
