@extends('layouts.app')

@section('title', $inverter->product_name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $inverter->product_name }}</h1>
        <a href="{{ route('inverters.index') }}" class="text-blue-600 hover:text-blue-800">← Back</a>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <div class="grid grid-cols-2 gap-8">
            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Model</label>
                    <p class="text-xl font-semibold">{{ $inverter->model ?? 'N/A' }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Power Rating (Watts)</label>
                    <p class="text-xl font-semibold">{{ number_format($inverter->power_rating) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Quantity in Stock</label>
                    <p class="text-xl font-semibold {{ $inverter->quantity_in_stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $inverter->quantity_in_stock }}
                    </p>
                </div>
            </div>

            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Cost Price</label>
                    <p class="text-xl font-semibold">₦{{ number_format($inverter->cost_price, 2) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Selling Price</label>
                    <p class="text-xl font-semibold text-green-600">₦{{ number_format($inverter->selling_price, 2) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Profit per Unit</label>
                    <p class="text-xl font-semibold text-blue-600">₦{{ number_format($inverter->selling_price - $inverter->cost_price, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="border-t mt-8 pt-8">
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Supplier</label>
                <p class="text-lg">{{ $inverter->supplier ?? 'Not specified' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Warranty</label>
                <p class="text-lg">{{ $inverter->warranty ?? 'Not specified' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Description</label>
                <p class="text-lg">{{ $inverter->description ?? 'Not specified' }}</p>
            </div>
        </div>

        <div class="border-t mt-8 pt-8 flex space-x-4">
            <a href="{{ route('inverters.edit', $inverter) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Edit</a>
            <form action="{{ route('inverters.destroy', $inverter) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
