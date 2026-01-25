@extends('layouts.app')

@section('title', 'AVRs')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">Dashboard</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg></li>
                    <li class="text-gray-900 font-medium">AVRs</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">AVR Inventory</h1>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('avrs.remove-form') }}" class="inline-flex items-center px-4 py-2 border border-red-200 text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 transition-all shadow-sm">
                <span class="mr-2">➖</span> Remove Stock
            </a>
            <a href="{{ route('avrs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                <span class="mr-2">➕</span> Add New AVR
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
        @if ($avrs->isEmpty())
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 mb-4 text-2xl">🔌</div>
                <h3 class="text-lg font-medium text-gray-900">No AVRs found</h3>
                <p class="text-gray-500 mt-1">Keep your voltage regulated! Start by adding an AVR unit.</p>
                <a href="{{ route('avrs.create') }}" class="mt-4 inline-flex items-center text-emerald-600 font-semibold hover:text-emerald-700">Add one now &rarr;</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Product & Model</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Capacity</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">In Stock</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Selling Price (₦)</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($avrs as $avr)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $avr->product_name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $avr->model ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-medium text-gray-600 bg-gray-100 px-2.5 py-1 rounded-md">
                                        {{ number_format($avr->capacity) }}W
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php 
                                        $stockClass = $avr->quantity_in_stock <= 3 ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                        if($avr->quantity_in_stock == 0) $stockClass = 'bg-red-50 text-red-700 border-red-100';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $stockClass }}">
                                        {{ $avr->quantity_in_stock }} Units
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ $avr->selling_price ? number_format($avr->selling_price, 0) : '---' }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 uppercase font-semibold">Cost: {{ $avr->cost_price ? number_format($avr->cost_price, 0) : 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('avrs.show', $avr) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View Details">
                                            👁️
                                        </a>
                                        <a href="{{ route('avrs.edit', $avr) }}" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('avrs.destroy', $avr) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this AVR?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection