<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // REGISTER PAGE
    public function showRegister()
    {
        return view('auth.register');
    }

    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    // LOGIN PAGE
    public function showLogin()
    {
        return view('auth.login');
    }

    //  LOGIN WITH REMEMBER ME
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials'
        ])->withInput();
    }

    // DASHBOARD
    public function dashboard()
    {
        return view('auth.dashboard');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    //  PROFILE PAGE
    public function profile()
    {
        return view('auth.profile', [
            'user' => auth()->user()
        ]);
    }

    //  UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $user = auth()->user();

        // UPDATE NAME + EMAIL
        $user->name = $request->name;
        $user->email = $request->email;

        // UPDATE PASSWORD ONLY IF FILLED
        if ($request->filled('new_password')) {

            // check old password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Current password is incorrect'
                ]);
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
