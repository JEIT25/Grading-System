<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('welcome');
    }

    // Handle login submission
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Check the role of the logged-in user
            $user = Auth::user();

            if ($user->role === 'admin') {
                // Redirect to the admin dashboard if the user is an admin
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
            } elseif ($user->role === 'facilitator') {
                // Redirect to the facilitator dashboard if the user is a facilitator
                return redirect()->route('facilitator.dashboard')->with('success', 'Logged in successfully!');
            } elseif ($user->role === 'student') {
                // Redirect to the facilitator dashboard if the user is a facilitator
                return redirect()->route('student.my-info')->with('success', 'Logged in successfully!');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }


    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
