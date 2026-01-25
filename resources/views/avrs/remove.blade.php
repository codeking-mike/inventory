@extends('layouts.app')

@section('title', 'Remove Inverter')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Remove AVR from Stock</h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('avrs.store-removal') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Select AVR*</label>
                <select name="avr_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Select an AVR --</option>
                    @foreach ($avrs as $avr)
                        @if ($avr->quantity_in_stock > 0)
                            <option value="{{ $avr->id }}" {{ old('avr_id') == $avr->id ? 'selected' : '' }}>
                                {{ $avr->product_name }} ({{ $avr->model }}) - In Stock: {{ $avr->quantity_in_stock }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('avr_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Particulars*</label>
                <input type="text" name="particulars" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('particulars') }}" placeholder="e.g., Sold to customer, Damaged, etc." required>
                @error('particulars') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Quantity to Remove*</label>
                <input type="number" name="qty" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('qty') }}" min="1" required>
                @error('qty') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Date*</label>
                <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('date', now()->toDateString()) }}" required>
                @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Reference Number</label>
                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50" value="Auto-generated" disabled>
                <p class="text-sm text-gray-600 mt-1">Reference number will be auto-generated upon submission</p>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Remarks</label>
                <textarea name="remarks" rows="3" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Add any additional remarks...">{{ old('remarks') }}</textarea>
                @error('remarks') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror   
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Remove AVR</button>
                <a href="{{ route('avrs.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

