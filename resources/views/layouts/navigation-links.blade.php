<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    Dashboard
</x-nav-link>


<x-nav-link href="{{ route('inverters.index') }}" :active="request()->routeIs('inverters.*')">Inverters</x-nav-link>
<x-nav-link href="{{ route('avrs.index') }}" :active="request()->routeIs('avrs.*')">AVRs</x-nav-link>
<x-nav-link href="{{ route('solar-panels.index') }}" :active="request()->routeIs('solar-panels.*')">Solar Panels</x-nav-link>
<x-nav-link href="{{ route('batteries.index') }}" :active="request()->routeIs('batteries.*')">Batteries</x-nav-link>
<x-nav-link href="{{ route('ups.index') }}" :active="request()->routeIs('ups.*')">UPS</x-nav-link>
<x-nav-link href="{{ route('transactions.index') }}" :active="request()->routeIs('transactions.*')">Stock History</x-nav-link>