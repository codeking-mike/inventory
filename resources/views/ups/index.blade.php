@extends('layouts.app')

@section('title', 'UPS Systems')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-purple-600 transition-colors">Dashboard</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg></li>
                    <li class="text-gray-900 font-medium">UPS Systems</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">UPS Inventory</h1>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('ups.remove-form') }}" class="inline-flex items-center px-4 py-2 border border-red-200 text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 transition-all shadow-sm">
                <span class="mr-2">➖</span> Remove Stock
            </a>
            <a href="{{ route('ups.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                <span class="mr-2">➕</span> Add New UPS
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
        @if ($upsSystems->isEmpty())
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-50 text-purple-500 mb-4 text-2xl">🖥️</div>
                <h3 class="text-lg font-medium text-gray-900">No UPS units found</h3>
                <p class="text-gray-500 mt-1">Ensure zero downtime by adding your first UPS system to the stock.</p>
                <a href="{{ route('ups.create') }}" class="mt-4 inline-flex items-center text-purple-600 font-semibold hover:text-purple-700">Add one now &rarr;</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Product & Model</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Capacity & Backup</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Price (₦)</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($upsSystems as $ups)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $ups->product_name }}</div>
                                    <div class="text-xs text-gray-500 font-mono italic">{{ $ups->model ?? 'Universal' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-bold text-gray-700">{{ number_format($ups->power_capacity) }}W</span>
                                        <span class="text-[10px] text-purple-600 font-semibold flex items-center">
                                            <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                                            {{ $ups->backup_time ?? '0' }} mins
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php 
                                        $stockClass = $ups->quantity_in_stock <= 2 ? 'bg-rose-50 text-rose-700 border-rose-100' : 'bg-indigo-50 text-indigo-700 border-indigo-100';
                                        if($ups->quantity_in_stock == 0) $stockClass = 'bg-gray-100 text-gray-500 border-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $stockClass }}">
                                        {{ $ups->quantity_in_stock }} Units
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ number_format($ups->selling_price, 0) }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 uppercase font-medium">Cost: {{ number_format($ups->cost_price, 0) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('ups.show', $ups) }}" class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all">
                                            👁️
                                        </a>
                                        <a href="{{ route('ups.edit', $ups) }}" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all">
                                            ✏️
                                        </a>
                                        <form action="{{ route('ups.destroy', $ups) }}" method="POST" class="inline" onsubmit="return confirm('Delete this UPS system permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
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