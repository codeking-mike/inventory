@extends('layouts.app')

@section('title', $solarPanel->product_name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $solarPanel->product_name }}</h1>
        <a href="{{ route('solar-panels.index') }}" class="text-blue-600 hover:text-blue-800">← Back</a>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <div class="grid grid-cols-2 gap-8">
            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Model</label>
                    <p class="text-xl font-semibold">{{ $solarPanel->model ?? 'N/A' }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Wattage</label>
                    <p class="text-xl font-semibold">{{ number_format($solarPanel->wattage) }}W</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Cell Type</label>
                    <p class="text-xl font-semibold">{{ $solarPanel->cell_type ?? 'N/A' }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Efficiency</label>
                    <p class="text-xl font-semibold">{{ $solarPanel->efficiency_percentage ?? 'N/A' }}%</p>
                </div>
            </div>

            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Quantity in Stock</label>
                    <p class="text-xl font-semibold {{ $solarPanel->quantity_in_stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $solarPanel->quantity_in_stock }}
                    </p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Cost Price</label>
                    <p class="text-xl font-semibold">₦{{ number_format($solarPanel->cost_price, 2) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Selling Price</label>
                    <p class="text-xl font-semibold text-green-600">₦{{ number_format($solarPanel->selling_price, 2) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Profit per Unit</label>
                    <p class="text-xl font-semibold text-blue-600">₦{{ number_format($solarPanel->selling_price - $solarPanel->cost_price, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="border-t mt-8 pt-8">
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Supplier</label>
                <p class="text-lg">{{ $solarPanel->supplier ?? 'Not specified' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Warranty</label>
                <p class="text-lg">{{ $solarPanel->warranty ?? 'Not specified' }}</p>
            </div>
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Description</label>
                <p class="text-lg">{{ $solarPanel->description ?? 'Not specified' }}</p>
            </div>
        </div>

        <div class="border-t mt-8 pt-8 flex space-x-4">
            <a href="{{ route('solar-panels.edit', $solarPanel) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Edit</a>
            <form action="{{ route('solar-panels.destroy', $solarPanel) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
