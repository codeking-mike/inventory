@extends('layouts.app')

@section('title', $avr->product_name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $avr->product_name }}</h1>
        <a href="{{ route('avrs.index') }}" class="text-blue-600 hover:text-blue-800">← Back</a>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <div class="grid grid-cols-2 gap-8">
            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Model</label>
                    <p class="text-xl font-semibold">{{ $avr->model ?? 'N/A' }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Capacity (KVA)</label>
                    <p class="text-xl font-semibold">{{ number_format($avr->capacity) }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Quantity in Stock</label>
                    <p class="text-xl font-semibold {{ $avr->quantity_in_stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $avr->quantity_in_stock }}
                    </p>
                </div>
            </div>

            <div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Cost Price</label>
                    <p class="text-xl font-semibold">{{ $avr->cost_price ? '₦' . number_format($avr->cost_price, 2) : 'N/A' }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Selling Price</label>
                    <p class="text-xl font-semibold text-green-600">{{ $avr->selling_price ? '₦' . number_format($avr->selling_price, 2) : 'N/A' }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-500 text-sm">Profit per Unit</label>
                    <p class="text-xl font-semibold text-blue-600">
                        @if($avr->selling_price && $avr->cost_price)
                            ₦{{ number_format($avr->selling_price - $avr->cost_price, 2) }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t mt-8 pt-8">
            <div class="mb-6">
                <label class="text-gray-500 text-sm">Description</label>
                <p class="text-lg">{{ $avr->description ?? 'Not specified' }}</p>
            </div>
        </div>

        <div class="border-t mt-8 pt-8 flex space-x-4">
            <a href="{{ route('avrs.edit', $avr) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Edit</a>
            <form action="{{ route('avrs.destroy', $avr) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
