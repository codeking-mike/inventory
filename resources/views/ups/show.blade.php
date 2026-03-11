@extends('layouts.app')

@section('title', $up->product_name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $up->product_name }}</h1>
        <a href="{{ route('ups.index') }}" class="text-blue-600 hover:text-blue-800">← Back</a>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <div class="grid grid-cols-2 gap-8">
            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Model</label>
                    <p class="text-xl font-semibold">{{ $up->model ?? 'N/A' }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Power Capacity (Watts)</label>
                    <p class="text-xl font-semibold">{{ number_format($up->power_capacity) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Backup Time</label>
                    <p class="text-xl font-semibold">{{ $up->backup_time ?? 'N/A' }} minutes</p>
                </div>
            </div>

            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Quantity in Stock</label>
                    <p class="text-xl font-semibold {{ $up->quantity_in_stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $up->quantity_in_stock }}
                    </p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Cost Price</label>
                    <p class="text-xl font-semibold">₦{{ number_format($up->cost_price, 2) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Selling Price</label>
                    <p class="text-xl font-semibold text-green-600">₦{{ number_format($up->selling_price, 2) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Profit per Unit</label>
                    <p class="text-xl font-semibold text-blue-600">₦{{ number_format($up->selling_price - $up->cost_price, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="border-t mt-8 pt-8">
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Supplier</label>
                <p class="text-lg">{{ $up->supplier ?? 'Not specified' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Warranty</label>
                <p class="text-lg">{{ $up->warranty ?? 'Not specified' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Description</label>
                <p class="text-lg">{{ $up->description ?? 'Not specified' }}</p>
            </div>
        </div>

        <div class="border-t mt-8 pt-8 flex space-x-4">
            <a href="{{ route('ups.edit', $up) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Edit</a>
            <form action="{{ route('ups.destroy', $up) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
