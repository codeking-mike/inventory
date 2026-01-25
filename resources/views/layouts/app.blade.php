<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'Systemtrust Inventory') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>

<body class="h-full overflow-hidden" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen overflow-hidden bg-gray-100">

        @auth
        <div x-show="mobileMenuOpen" class="fixed inset-0 flex z-40 md:hidden" style="display: none;">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity" @click="mobileMenuOpen = false"></div>

            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white transition transform">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="mobileMenuOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white text-white">
                        <span class="text-2xl">&times;</span>
                    </button>
                </div>
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <x-logo class="h-8 w-auto" />
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        @include('layouts.navigation-links')
                    </nav>
                </div>
            </div>
        </div>

        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col h-0 flex-1 border-r border-gray-200 bg-white">
                    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                        <div class="flex items-center flex-shrink-0 px-4">
                            <x-logo class="h-10 w-auto" />
                        </div>
                        <nav class="mt-8 flex-1 px-2 bg-white space-y-1">
                            @include('layouts.navigation-links')
                        </nav>
                    </div>
                    <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                <form action="{{ route('logout') }}" method="POST">@csrf
                                    <button type="submit" class="text-xs font-medium text-gray-500 hover:text-red-600">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endauth

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            
            <div class="md:hidden flex items-center justify-between bg-white border-b border-gray-200 px-4 py-2">
                <x-logo class="h-8 w-auto" />
                <button @click="mobileMenuOpen = true" class="p-2 rounded-md text-gray-500 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>