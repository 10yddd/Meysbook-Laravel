<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Show Signup Page ───
    public function showSignup()
    {
        return view('signup');
    }

    // ── Registration with Toast (Controller) -
    public function register(Request $request)
    {
        // Checks if user email already exists in the database - 
        if (User::where('email', $request->email)->exists()) {
            return back()->with('error', 'Email already exists');
        }

        // Checks if password and confirm password matches - 
        if ($request->password !== $request->confirmpassword) {
            return back()->with('error', 'Passwords do not match');
        }

        // Successful account creation with success toast - 
        User::create([
            'name'     => $request->firstname . ' ' . $request->lastname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Account created successfully');
    }

    // ── Show Login Page (Controller) -
    public function showLogin()
    {
        return view('login');
    }

    // ── Login (Controller) - 
    public function login(Request $request)
    {
        // Checks if user email exists in the database
        // Used first() to check if it exists getting the first record found - 
        $user = User::where('email', $request->email)->first();

        // Checks if user is empty or if hashed password is incorrect in the db - 
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        // Creates session and saves the whole record of the user - 
        session(['user' => $user]);

        // Redirect page to dashboard with success message - 
        return redirect('/dashboard')->with('success', 'Login successful');
    }

    // ── Dashboard (Route) --
    public function showDashboard()
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $totalUsers        = User::count();
        $totalReservations = \App\Models\Reservation::count();

        return view('dashboard', compact('totalUsers', 'totalReservations'));
    }

    // ── Logout (Controller) - 
    public function logout()
    {
        session()->forget('user');
        return redirect('/login')->with('success', 'Logged-out successfully');
    }
}