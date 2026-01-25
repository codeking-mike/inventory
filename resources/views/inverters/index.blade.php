@extends('layouts.app')

@section('title', 'Inverters')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg></li>
                    <li class="text-gray-900 font-medium">Inverters</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Inverter Inventory</h1>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('inverters.remove-form') }}" class="inline-flex items-center px-4 py-2 border border-red-200 text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 transition-all">
                <span class="mr-2">➖</span> Remove Stock
            </a>
            <a href="{{ route('inverters.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                <span class="mr-2">➕</span> Add New Inverter
            </a>
            <a href="{{ route('inverters.export') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-sm font-bold rounded-lg text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm group">
                <span class="mr-2 group-hover:scale-110 transition-transform">📊</span> 
                Export to Excel
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
        @if ($inverters->isEmpty())
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-50 text-yellow-500 mb-4 text-2xl">⚡</div>
                <h3 class="text-lg font-medium text-gray-900">No inverters found</h3>
                <p class="text-gray-500 mt-1">Get started by adding your first inverter to the system.</p>
                <a href="{{ route('inverters.create') }}" class="mt-4 inline-flex items-center text-blue-600 font-semibold hover:text-blue-700">Add one now &rarr;</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Product Info</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Specs</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Stock Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Pricing (₦)</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($inverters as $inverter)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $inverter->product_name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $inverter->model ?? 'Standard' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 italic">
                                    {{ number_format($inverter->power_rating) }}W
                                </td>
                                <td class="px-6 py-4">
                                    @php 
                                        $stockClass = $inverter->quantity_in_stock <= 5 ? 'bg-orange-50 text-orange-700 border-orange-100' : 'bg-green-50 text-green-700 border-green-100';
                                        if($inverter->quantity_in_stock == 0) $stockClass = 'bg-red-50 text-red-700 border-red-100';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $stockClass }}">
                                        {{ $inverter->quantity_in_stock }} in stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-xs text-gray-400 line-through">Cost: {{ number_format($inverter->cost_price, 0) }}</div>
                                    <div class="text-sm font-bold text-gray-900">{{ number_format($inverter->selling_price, 0) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('inverters.show', $inverter) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View Details">
                                            👁️
                                        </a>
                                        <a href="{{ route('inverters.edit', $inverter) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('inverters.destroy', $inverter) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
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