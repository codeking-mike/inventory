@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Account Settings</h2>
     
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
            {{ session('success') }}
        </div>
    @endif
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Email (Disabled) --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase">Email Address</label>
                    <input type="text" value="{{ $user->email }}" disabled 
                        class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed">
                    <p class="text-[10px] text-gray-400 italic">Email addresses cannot be changed for security audits.</p>
                </div>

                {{-- Name --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <hr class="border-gray-50">

                {{-- Password Change --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase">New Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-red-800 text-white font-bold rounded-xl hover:bg-indigo-800 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection