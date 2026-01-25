@extends('layouts.app')

@section('title', 'Remove Solar Panel')

@section('content')
<div class="max-w-2xl mx-auto"> 
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to Dashboard</a>
    </div>
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Remove Solar Panel</h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('solar-panels.store-removal') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Select Solar Panel*</label>
                <select name="solar_panel_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Select Solar Panel --</option>
                    @foreach ($solarPanel as $panel)
                        <option value="{{ $panel->id }}">{{ $panel->product_name }} ({{ $panel->model ?? 'No Model' }}) - In Stock: {{ $panel->quantity_in_stock }}</option>
                    @endforeach
                </select>
                @error('solar_panel_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Quantity to Remove*</label>
                <input type="number" name="quantity" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('quantity') }}" required>
                @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Reason for Removal</label>
                <textarea name="reason" class="w-full border border-gray-300 rounded px-3 py-2" rows="4">{{ old('reason') }}</textarea>
                @error('reason') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Remove Solar Panel</button>
        </form>
    </div>
</div>
@endsection
