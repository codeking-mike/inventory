<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Systemtrust Inventory') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .toast { border-radius: 12px !important; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1) !important; }
    </style>
</head>
<body class="h-full overflow-hidden">
    <div id="app" class="flex h-screen bg-gray-100">
        
        @auth
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4 mb-5">
                        <x-logo class="h-10 w-auto" />
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-6 mb-2">Inventory</div>
                        <x-nav-link href="{{ route('inverters.index') }}" :active="request()->routeIs('inverters.*')">Inverters</x-nav-link>
                        <x-nav-link href="{{ route('avrs.index') }}" :active="request()->routeIs('avrs.*')">AVRs</x-nav-link>
                        <x-nav-link href="{{ route('solar-panels.index') }}" :active="request()->routeIs('solar-panels.*')">Solar Panels</x-nav-link>
                        <x-nav-link href="{{ route('batteries.index') }}" :active="request()->routeIs('batteries.*')">Batteries</x-nav-link>
                        <x-nav-link href="{{ route('ups.index') }}" :active="request()->routeIs('ups.*')">UPS</x-nav-link>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <div class="flex-shrink-0 w-full group block">
                        <div class="flex items-center">
                            <div>
                                <div class="h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-gray-500 hover:text-red-600 transition-colors">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endauth

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // Use the toastr logic you already have here...
        toastr.options = { "positionClass": "toast-bottom-right", "progressBar": true };
        @if (session('success')) toastr.success("{{ session('success') }}"); @endif
        @if ($errors->any()) @foreach ($errors->all() as $error) toastr.error("{{ $error }}"); @endforeach @endif
    </script>
</body>
</html>