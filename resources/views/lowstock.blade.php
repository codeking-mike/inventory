@extends('layouts.app')

@section('title', 'Low Stock')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to Dashboard</a>
    </div>

    <h1 class="text-3xl font-bold mb-8 text-gray-800">Low Stock</h1>

    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
        <h3 class="font-bold text-gray-900">Stock Alerts</h3>
        <span class="px-2 py-1 bg-red-50 text-red-600 text-[10px] font-bold rounded uppercase">
            {{ $stockAlerts->count() }} Items Low
        </span>
    </div>
    <div class="p-6">
        @forelse($stockAlerts as $alert)
            <div class="flex items-center justify-between p-3 bg-rose-50/50 rounded-xl border border-rose-100 mb-3 last:mb-0">
                <div class="flex items-center">
                    <span class="mr-3 text-xl">{{ $alert['icon'] }}</span>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $alert['name'] }}</p>
                        <p class="text-xs text-rose-600 font-medium font-mono italic">
                            Only {{ $alert['qty'] }} units remaining
                        </p>
                    </div>
                </div>
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mr-4">
                    {{ $alert['category'] }}
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <span class="text-2xl">✅</span>
                <p class="text-sm text-gray-500 mt-2">All stock levels are healthy!</p>
            </div>
        @endforelse
    </div>
</section>
</div>
@endsection
