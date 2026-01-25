@extends('layouts.app')

@section('title', 'Transaction Logs')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Inventory Logs</h1>
            <p class="text-sm text-gray-500 mt-1">A complete audit trail of all stock movements and adjustments.</p>
        </div>
        
       <div class="flex items-center space-x-3">
            <a href="{{ route('transactions.export') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-sm font-bold rounded-lg text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm group">
                <span class="mr-2 group-hover:scale-110 transition-transform">📊</span> 
                Export to Excel
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs font-semibold text-gray-400 uppercase">Total Transactions</p>
            <p class="text-2xl font-bold text-gray-900">{{ $transactions->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs font-semibold text-emerald-500 uppercase">Items Added</p>
            <p class="text-2xl font-bold text-gray-900">{{ $transactions->where('type', 'addition')->sum('quantity') }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs font-semibold text-red-500 uppercase">Items Removed</p>
            <p class="text-2xl font-bold text-gray-900">{{ $transactions->where('type', 'removal')->sum('quantity') }}</p>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Date & Time</th>
                         <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Product Involved</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Particulars</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Quantity</th>
                       
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($transactions as $log)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $log->created_at->format('h:i A') }}</div>
                            </td>
                             <td class="px-6 py-4">
                                <a href="{{ route('transactions.show', $log->reference) }}" class="text-sm font-mono font-bold text-blue-600">
                                            #{{ $log->reference }}
                                 </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                   
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $log->product_type }}</div>
                                        
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                               <p class="text-sm text-gray-600 max-w-xs truncate" title="{{ $log->remarks }}">
                                    {{ $log->remarks ?? 'No remarks provided.' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-mono font-bold text-gray-900">
                                    {{ $log->qty }}
                                </span>
                            </td>
                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No activity recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection