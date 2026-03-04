<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Logins;

class LoginController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboards');
        }

        // Returns back with an error message if login fails
        return back()->withErrors([
            'login_error' => 'Invalid username or password.',
        ])->withInput();
    }

    public function showRegister() {
        return view('register');
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|string|unique:logins|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Logins::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'User', // Uses hidden input from form
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}