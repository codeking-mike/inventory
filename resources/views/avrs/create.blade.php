@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Add New AVR</h2>
            <p class="text-sm text-gray-500">Register a new Automatic Voltage Regulator in the system</p>
        </div>
        <a href="{{ route('avrs.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
            Cancel & Return
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('avrs.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Product Name --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition bg-gray-50/30"
                        placeholder="e.g. Haier Thermocool AVR">
                    @error('product_name') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Model --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Model Number</label>
                    <input type="text" name="model" value="{{ old('model') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition"
                        placeholder="e.g. TEC-2000">
                    @error('model') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Capacity --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Capacity (KVA) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="number" name="capacity" step="0.01" value="{{ old('capacity') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition"
                            placeholder="0.00">
                        <span class="absolute right-4 top-3 text-gray-400 text-xs font-bold italic">KVA</span>
                    </div>
                    @error('capacity') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Quantity --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Initial Stock Quantity <span class="text-red-400">*</span></label>
                    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', 0) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">
                    @error('quantity_in_stock') <p class="text-red-500 text-[10px] font-bold italic">{{ $message }}</p> @enderror
                </div>

                {{-- Pricing --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Cost Price (₦)</label>
                    <input type="number" name="cost_price" step="0.01" value="{{ old('cost_price') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition bg-red-50/10">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Selling Price (₦)</label>
                    <input type="number" name="selling_price" step="0.01" value="{{ old('selling_price') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition bg-cyan-50/10">
                </div>

                {{-- Description & Remarks --}}
                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Description</label>
                    <textarea name="description" rows="3" placeholder="Technical details, input voltage range, etc."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">{{ old('description') }}</textarea>
                </div>

                <div class="col-span-full space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Transaction Remarks</label>
                    <textarea name="remarks" rows="2" placeholder="Notes about this initial stock entry..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500 outline-none transition">{{ old('remarks') }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" class="px-10 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-xl shadow-lg shadow-cyan-100 transition-all transform hover:-translate-y-1">
                    Save AVR to Inventory
                </button>
            </div>
        </form>
    </div>
</div>
@endsection