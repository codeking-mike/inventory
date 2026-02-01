@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
            <p class="text-sm text-gray-500">Manage system access and administrator privileges.</p>
        </div>
        
        {{-- Button to the Admin-Only Registration Route --}}
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
            <span class="mr-2">+</span> Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">User Info</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Created Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->is_admin)
                            <span class="px-2 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold rounded-md uppercase">Admin</span>
                        @else
                            <span class="px-2 py-1 bg-gray-50 text-gray-600 text-[10px] font-bold rounded-md uppercase">Staff</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-medium text-sm">
                                    Delete
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400 italic">You (Current)</span>
                        @endif

                        <form action="{{ route('users.reset_password', $user) }}" method="POST" class="inline ml-2">
    @csrf @method('PUT')
    <button type="button" 
            onclick="let p = prompt('Enter new password for {{ $user->name }}:'); if(p) { this.nextElementSibling.value = p; this.parentElement.submit(); }"
            class="text-blue-500 hover:text-blue-700 text-sm">
        Reset Pass
    </button>
    <input type="hidden" name="new_password">
</form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
</div>
@endsection