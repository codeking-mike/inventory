<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    Dashboard
</x-nav-link>


<x-nav-link href="{{ route('inverters.index') }}" :active="request()->routeIs('inverters.*')">Inverters</x-nav-link>
<x-nav-link href="{{ route('avrs.index') }}" :active="request()->routeIs('avrs.*')">AVRs</x-nav-link>
<x-nav-link href="{{ route('solar-panels.index') }}" :active="request()->routeIs('solar-panels.*')">Solar Panels</x-nav-link>
<x-nav-link href="{{ route('batteries.index') }}" :active="request()->routeIs('batteries.*')">Batteries</x-nav-link>
<x-nav-link href="{{ route('ups.index') }}" :active="request()->routeIs('ups.*')">UPS</x-nav-link>
<x-nav-link href="{{ route('transactions.index') }}" :active="request()->routeIs('transactions.*')">Stock History</x-nav-link>
@if(auth()->check() && auth()->user()->is_admin)
    <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
        
            <i class="fas fa-users"></i>
            <span>User Management</span>
       
    </x-nav-link>
    
@endif
<x-nav-link href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.edit')">
        
            <i class="fas fa-user-plus"></i>
            <span>My Profile</span>
</x-nav-link>