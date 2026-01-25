@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Systemtrust Inventory</h1>
            <p class="text-sm text-gray-500">Overview of your current stock levels and recent activity.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <span class="w-2 h-2 mr-2 rounded-full bg-blue-500 animate-pulse"></span>
                Live System
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        @php
            $stats = [
                ['label' => 'Inverters', 'count' => $inverters->sum('quantity_in_stock'), 'products' => $inverters->count(), 'color' => 'indigo', 'icon' => '⚡', 'route' => 'inverters.index'],
                ['label' => 'AVRs', 'count' => $avrs->sum('quantity_in_stock'), 'products' => $avrs->count(), 'color' => 'emerald', 'icon' => '🔌', 'route' => 'avrs.index'],
                ['label' => 'Solar Panels', 'count' => $solarPanels->sum('quantity_in_stock'), 'products' => $solarPanels->count(), 'color' => 'amber', 'icon' => '☀️', 'route' => 'solar-panels.index'],
                ['label' => 'Batteries', 'count' => $batteries->sum('quantity_in_stock'), 'products' => $batteries->count(), 'color' => 'orange', 'icon' => '🔋', 'route' => 'batteries.index'],
                ['label' => 'UPS Systems', 'count' => $upsSystems->sum('quantity_in_stock'), 'products' => $upsSystems->count(), 'color' => 'purple', 'icon' => '📦', 'route' => 'ups.index'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-{{ $stat['color'] }}-700 rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ $stat['label'] }}</p>
                    <p class="mt-2 text-3xl font-bold text-gray-200">{{ $stat['count'] }}</p>
                    <p class="text-xs text-gray-200 mt-1">{{ $stat['products'] }} variants</p>
                </div>
                <div class="p-3 bg-{{ $stat['color'] }}-50 rounded-xl text-2xl">
                    {{ $stat['icon'] }}
                </div>
            </div>
            <a href="{{ route($stat['route']) }}" class="mt-4 flex items-center text-sm font-medium text-white">
                View inventory
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Stock Management</h2>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('inverters.create') }}" class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition-all group">
                        <span class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 mr-4 group-hover:scale-110 transition-transform">➕</span>
                        <span class="text-sm font-semibold text-gray-700">Add New Inverters</span>
                    </a>
                    <a href="{{ route('inverters.remove-form') }}" class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-red-50 hover:border-red-200 transition-all group">
                        <span class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mr-4 group-hover:scale-110 transition-transform">➖</span>
                        <span class="text-sm font-semibold text-gray-700">Remove Inverters</span>
                    </a>
                    <a href="{{ route('batteries.create') }}" class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition-all group">
                        <span class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 mr-4 group-hover:scale-110 transition-transform">➕</span>
                        <span class="text-sm font-semibold text-gray-700">Add New Battery</span>
                    </a>
                    <a href="{{ route('batteries.remove-form') }}" class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-red-50 hover:border-red-200 transition-all group">
                        <span class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mr-4 group-hover:scale-110 transition-transform">➖</span>
                        <span class="text-sm font-semibold text-gray-700">Remove Battery</span>
                    </a>
                </div>
            </div>

            
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900">Recent Transactions</h2>
                    <span class="text-xs font-medium text-gray-400">Showing last {{ $transactions->count() }} records</span>
                </div>
                
                @if ($transactions->isEmpty())
                    <div class="p-12 text-center">
                        <p class="text-gray-400 italic">No transactions recorded yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Reference</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($transactions as $transaction)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('transactions.show', $transaction->reference) }}" class="text-sm font-mono font-bold text-blue-600">
                                            #{{ $transaction->reference }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-800">{{ ucfirst($transaction->product_type) }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-[150px]">{{ $transaction->particulars }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $transaction->qty > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                            {{ $transaction->qty > 0 ? '+' : '' }}{{ $transaction->qty }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $transaction->date ? $transaction->date->format('d M, Y') : 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($transactions->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $transactions->links() }}
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection