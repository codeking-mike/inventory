@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Search Results</h2>
        <p class="text-gray-500">Showing matches for <span class="text-blue-600 font-semibold">"{{ $query }}"</span></p>
    </div>

    {{-- Search Statistics --}}
    @php
        $totalResults = $inverters->count() + $batteries->count() + $ups->count() + $avrs->count() + $panels->count();
    @endphp

    @if($totalResults > 0)
        <div class="space-y-10">
            
            {{-- Inverters Category --}}
            @if($inverters->count() > 0)
                <section>
                    <div class="flex items-center mb-4 gap-3">
                        <h3 class="text-lg font-bold text-gray-700 uppercase tracking-wider">Inverters</h3>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $inverters->count() }}</span>
                    </div>
                    @include('search._result_table', ['items' => $inverters, 'type' => 'inverters'])
                </section>
            @endif

            {{-- Batteries Category --}}
            @if($batteries->count() > 0)
                <section>
                    <div class="flex items-center mb-4 gap-3">
                        <h3 class="text-lg font-bold text-gray-700 uppercase tracking-wider">Batteries</h3>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">{{ $batteries->count() }}</span>
                    </div>
                    @include('search._result_table', ['items' => $batteries, 'type' => 'batteries'])
                </section>
            @endif

            {{-- UPS Category --}}
            @if($ups->count() > 0)
                <section>
                    <div class="flex items-center mb-4 gap-3">
                        <h3 class="text-lg font-bold text-gray-700 uppercase tracking-wider">UPS Systems</h3>
                        <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">{{ $ups->count() }}</span>
                    </div>
                    @include('search._result_table', ['items' => $ups, 'type' => 'ups'])
                </section>
            @endif
             
            {{-- AVRs Category --}} 
            @if($avrs->count() > 0)
                <section>
                    <div class="flex items-center mb-4 gap-3">
                        <h3 class="text-lg font-bold text-gray-700 uppercase tracking-wider">AVRs</h3>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">{{ $avrs->count() }}</span>
                    </div>
                    @include('search._result_table', ['items' => $avrs, 'type' => 'avrs'])
                </section>
            @endif
            
            {{-- Solar Panels Category --}}
            @if($panels->count() > 0)
                <section>
                    <div class="flex items-center mb-4 gap-3">
                        <h3 class="text-lg font-bold text-gray-700 uppercase tracking-wider">Solar Panels</h3>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">{{ $panels->count() }}</span> 
                    </div>
                    @include('search._result_table', ['items' => $panels, 'type' => 'solar-panels'])
                </section>
            @endif
            {{-- Add similar blocks for AVR and Solar Panels --}}

        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
            <div class="text-5xl mb-4">🔍</div>
            <h3 class="text-xl font-bold text-gray-900">No items found</h3>
            <p class="text-gray-500 max-w-xs mx-auto">We couldn't find anything matching "{{ $query }}" in your current inventory.</p>
            <a href="{{ route('dashboard') }}" class="mt-6 inline-block text-blue-600 font-semibold hover:underline">Return to Dashboard</a>
        </div>
    @endif
</div>
@endsection