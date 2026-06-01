<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    // Display profile page - 
    public function showProfile()
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }
        return view('profile');
    }

    // Create function - 
    public function profile(Request $request)
    {
        // Gets the logged-in user's id - 
        $user = User::find(session('user')->id);

        // Upload Image if there is a value - 
        if ($request->hasFile('profile')) {

            // Gets the uploaded file - 
            $file = $request->file('profile');

            // Creates a unique file name using time() -
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Moves file to folder 'uploads' in public folder - 
            $file->move(public_path('uploads'), $filename);

            // Saves filename to database - 
            $user->profile_pic = $filename;
        }

        // Updates name and email in the database -
        $user->name  = $request->name;
        $user->email = $request->email;

        // Saves to database - 
        $user->save();

        // refresh session to display the updated data -
        session(['user' => $user]);

        // Go back to same page with success message -
        return back()->with('success', 'Profile updated successfully');
    }
}