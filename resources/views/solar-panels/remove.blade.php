@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Remove Solar Panel</h2>
            <p class="text-sm text-gray-500">Deduct stock from the solar panel inventory</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            ← Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
        <div class="bg-rose-50 border-b border-rose-100 px-8 py-4 flex items-center gap-3">
            <span class="text-rose-500 text-lg">⚠️</span>
            <p class="text-xs font-semibold text-rose-700 uppercase tracking-wider">Inventory Deduction Mode</p>
        </div>

        <form id="removalForm" action="{{ route('solar-panels.store-removal') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                {{-- Select Product --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Select Solar Panel <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="solar_panel_id" id="productSelect" required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition bg-white cursor-pointer appearance-none">
                            <option value="" data-stock="0">-- Choose an item from stock --</option>
                            @foreach ($solarPanel as $panel)
                                <option value="{{ $panel->id }}" data-stock="{{ $panel->quantity_in_stock }}" {{ old('solar_panel_id') == $panel->id ? 'selected' : '' }}>
                                    {{ $panel->product_name }} ({{ $panel->model ?? 'No Model' }}) — Available: {{ $panel->quantity_in_stock }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Quantity to Remove --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity to Remove <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="number" name="quantity" id="quantityInput" value="{{ old('quantity') }}" required min="1"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition"
                                placeholder="0">
                        </div>
                        {{-- JS Error Message Container --}}
                        <p id="jsError" class="hidden text-rose-500 text-[10px] font-bold italic mt-1"></p>
                    </div>

                    <div class="flex items-center px-4 py-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-[11px] text-gray-500 italic">
                            Current Stock for selected item: <span id="stockDisplay" class="font-bold text-gray-700">0</span>
                        </p>
                    </div>
                </div>

                {{-- Waybill --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Waybill Number</label>
                    <input type="text" name="waybill" value="{{ old('waybill') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition"
                        placeholder="Optional waybill number">
                    @error('waybill') <p class="text-rose-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Reason for Removal --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Reason for Removal</label>
                    <textarea name="reason" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">{{ old('reason') }}</textarea>
                </div>

                {{-- Additional Remarks --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Additional Remarks</label>
                    <textarea name="remarks" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 outline-none transition">{{ old('remarks') }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" id="submitBtn" class="w-full md:w-auto px-10 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg shadow-rose-100 transition-all transform hover:-translate-y-1">
                    Confirm Stock Removal
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
    const form = document.getElementById('removalForm');

    function validateStock() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const availableStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const requestedQuantity = parseInt(quantityInput.value) || 0;

        // Update the visual stock counter
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

    // Listen for changes
    productSelect.addEventListener('change', validateStock);
    quantityInput.addEventListener('input', validateStock);

    // Final check on submit
    form.addEventListener('submit', function(e) {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const availableStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const requestedQuantity = parseInt(quantityInput.value) || 0;

        if (requestedQuantity > availableStock) {
            e.preventDefault();
            alert('Wait! You are trying to remove more stock than you have available.');
        }
    });
});
</script>
@endsection