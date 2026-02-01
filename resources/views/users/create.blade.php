@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Breadcrumb/Header --}}
    <div class="mb-8">
        <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:underline flex items-center mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to User Management
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Create New Staff Account</h2>
        <p class="text-sm text-gray-500">Register a new user to grant them access to the inventory system.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name Field --}}
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('Full Name') }}</label>
                        <input id="name" type="text" 
                            class="w-full px-4 py-3 rounded-xl border @error('name') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            placeholder="John Doe">
                        @error('name')
                            <p class="text-red-500 text-xs font-semibold italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('Email Address') }}</label>
                        <input id="email" type="email" 
                            class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="staff@company.com">
                        @error('email')
                            <p class="text-red-500 text-xs font-semibold italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('Initial Password') }}</label>
                        <input id="password" type="password" 
                            class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            name="password" required autocomplete="new-password">
                        @error('password')
                            <p class="text-red-500 text-xs font-semibold italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="space-y-2">
                        <label for="password-confirm" class="text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    {{-- Admin Privilege Checkbox --}}
                <div class="col-span-full mt-4 p-4 bg-purple-50 rounded-xl border border-purple-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04a11.357 11.357 0 00-1.026 7.942c.592 4.257 2.85 8.113 6.176 10.722a11.954 11.954 0 007.068 0c3.326-2.609 5.584-6.465 6.176-10.722a11.356 11.356 0 00-1.026-7.942z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-purple-900">Administrator Access</p>
                            <p class="text-xs text-purple-600">Granting this allows the user to manage other users and system settings.</p>
                        </div>
                    </div>
                    <input type="checkbox" name="is_admin" value="1" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                </div>

                </div>

                <div class="mt-8 pt-6 border-t border-gray-50 flex justify-end items-center space-x-4">
                    <a href="{{ route('users.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1">
                        {{ __('Create Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Info Note --}}
    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100 flex items-start">
        <span class="mr-3 text-blue-500">ℹ️</span>
        <p class="text-xs text-blue-700 leading-relaxed">
            <strong>Admin Note:</strong> New accounts are created as <strong>Regular Staff</strong> by default. If you need to grant this user administrative privileges, you must do so manually via the database or user management console.
        </p>
    </div>
</div>
@endsection