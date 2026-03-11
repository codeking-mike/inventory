@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Remove UPS from Inventory</h2>
            <p class="text-sm text-gray-500">Log the dispatch or removal of Uninterruptible Power Supply units</p>
        </div>
        <a href="{{ route('ups.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            ← Back to Inventory
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
        {{-- Status Banner --}}
        <div class="bg-rose-50 border-b border-rose-100 px-8 py-4 flex items-center gap-3">
            <span class="text-rose-500 text-lg">⚠️</span>
            <p class="text-xs font-semibold text-rose-700 uppercase tracking-wider">Inventory Deduction Mode</p>
        </div>

        <form id="removalForm" action="{{ route('ups.store-removal') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                {{-- Select UPS --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Select UPS Unit <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="ups_id" id="productSelect" required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition bg-white cursor-pointer appearance-none">
                            <option value="" data-stock="0">-- Choose UPS from stock --</option>
                            @foreach ($upsUnits as $ups)
                                <option value="{{ $ups->id }}" data-stock="{{ $ups->quantity_in_stock }}" {{ old('ups_id') == $ups->id ? 'selected' : '' }}>
                                    {{ $ups->product_name }} ({{ $ups->model ?? 'N/A' }}) — Available: {{ $ups->quantity_in_stock }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('ups_id') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Quantity to Remove --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity to Remove <span class="text-red-400">*</span></label>
                        <input type="number" name="quantity" id="quantityInput" value="{{ old('quantity') }}" required min="1"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition"
                            placeholder="0">
                        <p id="jsError" class="hidden text-rose-500 text-[10px] font-bold italic mt-1"></p>
                    </div>

                    {{-- Stock Display Helper --}}
                    <div class="flex items-center px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 h-[52px] mt-auto">
                        <p class="text-[11px] text-gray-500 italic">
                            Currently in Warehouse: <span id="stockDisplay" class="font-bold text-gray-700">0</span>
                        </p>
                    </div>
                </div>

                {{-- Reason for Removal --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Reason for Removal</label>
                    <textarea name="particulars" rows="3" 
                        placeholder="e.g. Sold to Corporate Client, Faulty unit return, etc."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">{{ old('particulars') }}</textarea>
                    @error('particulars') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Waybill Number --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Waybill / Reference Number</label>
                    <input type="text" name="waybill" value="{{ old('waybill') }}"
                        placeholder="Optional tracking number"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" id="submitBtn" class="w-full md:w-auto px-12 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg shadow-rose-100 transition-all transform hover:-translate-y-1">
                    Remove UPS Units
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Stock Validation Script --}}
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

        if (requestedQuantity > availableStock) {
            jsError.textContent = `❌ Insufficient Stock: Only ${availableStock} units available.`;
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