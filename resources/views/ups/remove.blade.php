@extends('layouts.app')

@section('title', 'Remove UPS')

@section('content')
<div class="max-w-2xl mx-auto"> 
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Remove UPS from Inventory</h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('ups.store-removal') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Select UPS*</label>
                <select name="ups_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Select UPS --</option>
                    @foreach ($upsUnits as $ups)
                        <option value="{{ $ups->id }}" {{ old('ups_id') == $ups->id ? 'selected' : '' }}>
                            {{ $ups->product_name }} (Model: {{ $ups->model ?? 'N/A' }}, In Stock: {{ $ups->quantity_in_stock }})
                        </option>
                    @endforeach
                </select>
                @error('ups_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Quantity to Remove*</label>
                <input type="number" name="quantity" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('quantity') }}" required>
                @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Reason for Removal</label>
                <textarea name="reason" rows="3" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Provide a reason for removing this UPS...">{{ old('reason') }}</textarea>
                @error('reason') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Remove UPS</button>
        </form>
    </div>      
</div>
@endsection

