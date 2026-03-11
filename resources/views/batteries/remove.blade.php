@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Remove Battery from Stock</h2>
            <p class="text-sm text-gray-500">Deduct energy storage units from warehouse inventory</p>
        </div>
        <a href="{{ route('batteries.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            ← Back to Inventory
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
        {{-- Status Banner --}}
        <div class="bg-rose-50 border-b border-rose-100 px-8 py-4 flex items-center gap-3">
            <span class="text-rose-500 text-lg">⚠️</span>
            <p class="text-xs font-semibold text-rose-700 uppercase tracking-wider">Outflow Transaction</p>
        </div>

        <form id="removalForm" action="{{ route('batteries.store-removal') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                {{-- Select Battery --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Select Battery Model <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="battery_id" id="productSelect" required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition bg-white cursor-pointer appearance-none">
                            <option value="" data-stock="0">-- Choose battery from stock --</option>
                            @foreach ($batteries as $battery)
                                <option value="{{ $battery->id }}" data-stock="{{ $battery->quantity_in_stock }}" {{ old('battery_id') == $battery->id ? 'selected' : '' }}>
                                    {{ $battery->product_name }} ({{ $battery->model ?? 'N/A' }}) — Available: {{ $battery->quantity_in_stock }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('battery_id') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
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
                    <div class="flex items-center px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 h-[50px] mt-auto">
                        <p class="text-[11px] text-gray-500 italic">
                            Current Stock Level: <span id="stockDisplay" class="font-bold text-gray-700">0</span>
                        </p>
                    </div>
                </div>

                {{-- Reason for Removal --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Reason for Removal <span class="text-red-400">*</span></label>
                    <textarea name="particulars" rows="3" required
                        placeholder="e.g. Dispatched for installation at Victoria Island site"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">{{ old('particulars') }}</textarea>
                    @error('particulars') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Waybill Number --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Waybill Number</label>
                    <div class="relative">
                        <input type="text" name="waybill" value="{{ old('waybill') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition"
                            placeholder="Optional reference number">
                        <span class="absolute right-4 top-3 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" id="submitBtn" class="w-full md:w-auto px-12 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg shadow-rose-100 transition-all transform hover:-translate-y-1">
                    Confirm Stock Deduction
                </button>
            </div>
        </form>
    </div>
</div>

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
            jsError.textContent = `❌ Cannot remove ${requestedQuantity}. Only ${availableStock} in stock.`;
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