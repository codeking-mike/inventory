<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //

    public function index() {
    $users = User::all();
    return view('users.index', compact('users'));
    }

    public function create() {
        return view('users.create');
    }   
     

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->has('is_admin') ? $request->is_admin : false,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    } 
    
   

    // 1. Show the user's own profile
    public function profile() {
        return view('users.profile', ['user' => auth()->user()]);
    }

    // 2. User updates their own Name/Password
    public function profileUpdate(Request $request) {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    // 3. Admin resets someone else's password
    public function resetPassword(Request $request, User $user) {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', "Password for {$user->name} has been reset.");
    }

    
    public function destroy(User $user) {
        if($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
