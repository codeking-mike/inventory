@extends('layouts.app')

@section('title', 'Remove Inverter')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Stock Out: Inverters</h1>
            <p class="text-sm text-gray-500">Record sales, damages, or internal transfers.</p>
        </div>
        <a href="{{ route('inverters.index') }}" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
            &larr; Back to Inventory
        </a>
    </div>

    <form action="{{ route('inverters.store-removal') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
            <div class="bg-red-50 border-b border-red-100 px-6 py-3 flex items-center">
                <span class="text-red-500 mr-2">⚠️</span>
                <p class="text-xs font-semibold text-red-700 uppercase tracking-wider">Inventory Reduction Entry</p>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Inverter <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="inverter_id" class="w-full rounded-lg border-gray-200 focus:border-red-500 focus:ring-red-500 transition-all shadow-sm appearance-none bg-white" required>
                            <option value="">-- Choose an item in stock --</option>
                            @foreach ($inverters as $inverter)
                                @if ($inverter->quantity_in_stock > 0)
                                    <option value="{{ $inverter->id }}" {{ old('inverter_id') == $inverter->id ? 'selected' : '' }}>
                                        {{ $inverter->product_name }} ({{ $inverter->model }}) — Available: {{ $inverter->quantity_in_stock }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('inverter_id') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Particulars / Reason <span class="text-red-400">*</span></label>
                        <input type="text" name="particulars" class="w-full rounded-lg border-gray-200 focus:border-red-500 focus:ring-red-500 transition-all shadow-sm" value="{{ old('particulars') }}" placeholder="e.g. Invoice #9921 - Zenith Bank" required>
                        @error('particulars') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity to Remove <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="number" name="qty" min="1" class="w-full rounded-lg border-gray-200 pl-10 focus:border-red-500 focus:ring-red-500 transition-all shadow-sm font-bold text-red-600" value="{{ old('qty') }}" required>
                            <span class="absolute left-3 top-2 text-gray-400">📦</span>
                        </div>
                        @error('qty') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Date <span class="text-red-400">*</span></label>
                        <input type="date" name="date" class="w-full rounded-lg border-gray-200 focus:border-red-500 focus:ring-red-500 transition-all shadow-sm" value="{{ old('date', now()->toDateString()) }}" required>
                        @error('date') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                        <input type="text" class="w-full rounded-lg border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed text-sm italic" value="Will be auto-generated" disabled>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Internal Remarks</label>
                    <textarea name="remarks" rows="3" class="w-full rounded-lg border-gray-200 focus:border-red-500 focus:ring-red-500 transition-all shadow-sm" placeholder="Additional details about the condition or client...">{{ old('remarks') }}</textarea>
                    @error('remarks') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('inverters.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-8 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-red-200 hover:bg-red-700 hover:-translate-y-0.5 transition-all">
                Confirm Removal
            </button>
        </div>
    </form>
</div>
@endsection