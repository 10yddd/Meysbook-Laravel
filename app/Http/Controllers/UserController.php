<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ── Users Table (Controller) ───
    public function userstable()
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }

        // get all users record in database -
        $users = User::all();

        // it will load users and converts $users into ['users' => $users]
        // compact('users') is a shortcut of ['users' => $users] - 
        return view('users', compact('users'));
    }

    // ── Insert User Account (Controller) -
    public function addUser(Request $request)
    {
        // Checks if user email already exists in the database -
        if (User::where('email', $request->email)->exists()) {
            return back()->with('error', 'Account already exists');
        }

        if ($request->password !== $request->confirmpassword) {
            return back()->with('error', 'Passwords do not match');
        }

        // - added gender field
        User::create([
            'name'     => $request->fullname,
            'gender'   => $request->gender,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Account successfully created');
    }

    // ── Edit User ──────────────────────────────────────────────────────────────
    public function editUser($id)
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $editUser = User::findOrFail($id);
        $users    = User::all();

        return view('users', compact('users', 'editUser'));
    }

    // ── Update User ────────────────────────────────────────────────────────────
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name   = $request->fullname;
        $user->gender = $request->gender;
        $user->email  = $request->email;

        if ($request->filled('password')) {
            if ($request->password !== $request->confirmpassword) {
                return back()->with('error', 'Passwords do not match');
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/users')->with('success', 'User updated successfully');
    }

    // ── Delete User ────────────────────────────────────────────────────────────
    public function deleteUser($id)
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }

        User::findOrFail($id)->delete();

        return back()->with('success', 'User deleted successfully');
    }
}