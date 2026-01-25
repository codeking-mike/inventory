@extends('layouts.app')

@section('title', 'Batteries')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-orange-600 transition-colors">Dashboard</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg></li>
                    <li class="text-gray-900 font-medium">Batteries</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Battery Inventory</h1>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('batteries.remove-form') }}" class="inline-flex items-center px-4 py-2 border border-red-200 text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 transition-all shadow-sm">
                <span class="mr-2">➖</span> Remove Stock
            </a>
            <a href="{{ route('batteries.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all">
                <span class="mr-2">➕</span> Add New Battery
            </a>
            <a href="{{ route('batteries.export') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-sm font-bold rounded-lg text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm group">
                <span class="mr-2 group-hover:scale-110 transition-transform">📊</span> 
                Export to Excel
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
        @if ($batteries->isEmpty())
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-50 text-orange-500 mb-4 text-2xl">🔋</div>
                <h3 class="text-lg font-medium text-gray-900">No batteries found</h3>
                <p class="text-gray-500 mt-1">Start tracking your energy storage by adding your first battery unit.</p>
                <a href="{{ route('batteries.create') }}" class="mt-4 inline-flex items-center text-orange-600 font-semibold hover:text-orange-700">Add one now &rarr;</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Product & Model</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Specs (V / Ah)</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Stock Level</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Selling Price (₦)</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($batteries as $battery)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $battery->product_name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $battery->model ?? 'Standard' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex flex-col">
                                        <span class="text-sm font-bold text-gray-700">{{ number_format($battery->voltage) }}V</span>
                                        <span class="text-[10px] font-medium text-orange-600 bg-orange-50 px-1.5 py-0.5 rounded uppercase leading-tight">{{ number_format($battery->capacity) }}Ah</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php 
                                        $stockClass = $battery->quantity_in_stock <= 4 ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-green-50 text-green-700 border-green-100';
                                        if($battery->quantity_in_stock == 0) $stockClass = 'bg-red-50 text-red-700 border-red-100';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $stockClass }}">
                                        {{ $battery->quantity_in_stock }} in stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-bold text-gray-900">₦{{ number_format($battery->selling_price, 0) }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase font-semibold">Cost: {{ number_format($battery->cost_price, 0) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('batteries.show', $battery) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View">
                                            👁️
                                        </a>
                                        <a href="{{ route('batteries.edit', $battery) }}" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('batteries.destroy', $battery) }}" method="POST" class="inline" onsubmit="return confirm('Delete this battery record?')">
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