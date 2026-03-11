@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Remove AVR from Stock</h2>
            <p class="text-sm text-gray-500">Log an outflow of Automatic Voltage Regulator units</p>
        </div>
        <a href="{{ route('avrs.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            ← Back to Inventory
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
        {{-- Warning Banner --}}
        <div class="bg-rose-50 border-b border-rose-100 px-8 py-4 flex items-center gap-3">
            <span class="text-rose-500 text-lg">⚠️</span>
            <p class="text-xs font-semibold text-rose-700 uppercase tracking-wider">Stock Deduction Mode</p>
        </div>

        <form id="removalForm" action="{{ route('avrs.store-removal') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                {{-- Select AVR --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Select AVR Unit <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="avr_id" id="productSelect" required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition bg-white cursor-pointer appearance-none">
                            <option value="" data-stock="0">-- Choose an AVR from stock --</option>
                            @foreach ($avrs as $avr)
                                @if ($avr->quantity_in_stock > 0)
                                    <option value="{{ $avr->id }}" data-stock="{{ $avr->quantity_in_stock }}" {{ old('avr_id') == $avr->id ? 'selected' : '' }}>
                                        {{ $avr->product_name }} ({{ $avr->model }}) — Available: {{ $avr->quantity_in_stock }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('avr_id') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Particulars --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Reason for Removal <span class="text-red-400">*</span></label>
                    <input type="text" name="particulars" value="{{ old('particulars') }}" required
                        placeholder="e.g. Sale to Client Name, Site Installation, or Damage"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">
                    @error('particulars') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Quantity to Remove --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity to Remove <span class="text-red-400">*</span></label>
                        <input type="number" name="qty" id="quantityInput" value="{{ old('qty') }}" required min="1"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition"
                            placeholder="0">
                        <p id="jsError" class="hidden text-rose-500 text-[10px] font-bold italic mt-1"></p>
                    </div>

                    {{-- Date --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Transaction Date <span class="text-red-400">*</span></label>
                        <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">
                    </div>

                    {{-- Waybill Number --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Waybill Number</label>
                        <input type="text" name="waybill" value="{{ old('waybill') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition"
                            placeholder="Optional waybill">
                        @error('waybill') <p class="text-rose-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Auto-gen Reference --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Reference Number</label>
                        <input type="text" disabled value="Auto-generated" 
                            class="w-full px-4 py-3 rounded-xl border border-dashed border-gray-200 bg-gray-50 text-gray-400 italic">
                    </div>

                    {{-- Stock Display Helper --}}
                    <div class="flex items-center px-4 py-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-[11px] text-gray-500 italic">
                            Current Stock for selected AVR: <span id="stockDisplay" class="font-bold text-gray-700">0</span>
                        </p>
                    </div>
                </div>

                {{-- Remarks --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Additional Remarks</label>
                    <textarea name="remarks" rows="3" placeholder="Any extra details regarding this removal..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">{{ old('remarks') }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end gap-4">
                <a href="{{ route('avrs.index') }}" class="px-8 py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition flex items-center">
                    Cancel
                </a>
                <button type="submit" id="submitBtn" class="px-10 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg shadow-rose-100 transition-all transform hover:-translate-y-1">
                    Confirm Removal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Inline JS for real-time stock validation --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('productSelect');
    const quantityInput = document.getElementById('quantityInput');
    const stockDisplay = document.getElementById('stockDisplay');
    const jsError = document.getElementById('jsError');
    const submitBtn = document.getElementById('submitBtn');

    function validateStock() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const availableStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const requestedQuantity = parseInt(quantityInput.value) || 0;

        stockDisplay.textContent = availableStock;

        if (requestedQuantity > availableStock && availableStock > 0) {
            jsError.textContent = `❌ Insufficient stock. Only ${availableStock} available.`;
            jsError.classList.remove('hidden');
            quantityInput.classList.add('border-rose-500', 'bg-rose-50');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            jsError.classList.add('hidden');
            quantityInput.classList.remove('border-rose-500', 'bg-rose-50');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    productSelect.addEventListener('change', validateStock);
    quantityInput.addEventListener('input', validateStock);
});
</script>
@endsection