@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to Dashboard</a>
    </div>

    <h1 class="text-3xl font-bold mb-8 text-gray-800">Transaction Details</h1>

    <div class="bg-white rounded-lg shadow p-8">
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Transaction Reference</p>
                <p class="text-2xl font-mono text-blue-600">{{ $transaction->reference }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold">Date</p>
                <p class="text-2xl font-semibold">{{ $transaction->date->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="border-t pt-6 mb-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Product Type</p>
                    <p class="text-lg font-semibold">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-800">
                            {{ ucfirst(str_replace('_', ' ', $transaction->product_type)) }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Quantity</p>
                    <p class="text-lg font-semibold">
                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $transaction->qty > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $transaction->qty > 0 ? '+' : '' }}{{ $transaction->qty }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-gray-600 text-sm font-semibold">Particulars</p>
                <p class="text-lg">{{ $transaction->particulars }}</p>
            </div>

            <div class="bg-gray-50 rounded p-4">
                <p class="text-gray-600 text-sm font-semibold mb-2">Remarks</p>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $transaction->remarks ?? 'No remarks' }}</p>
            </div>
        </div>

        <div class="border-t pt-6 flex space-x-4">
            <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection
