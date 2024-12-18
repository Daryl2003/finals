<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // Import Hash for password changes
use App\Models\User;

class ProfileController extends Controller
{
    // Show the user profile page
    public function show()
    {
        $user = Auth::user(); // Get the currently authenticated user
        $cart = Session::get('cart', []); // Get cart items from session
        
        return view('profile.show', compact('user', 'cart'));
    }

    // Update the user profile information
    public function update(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800', // Validate the profile picture
            'gender' => 'nullable|string|in:male,female,other', // Validate gender
            'birthday' => 'nullable|date', // Validate birthday if needed
           
        ]);

        $user = auth()->user(); // Get the authenticated user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender; // Save gender
        $user->birthday = $request->birthday; // Save birthday if applicable
       
        // Handle profile picture upload if it exists
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!'); // Redirect back with a success message
    }

    // Change user password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the provided current password matches the user's actual current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password does not match.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password updated successfully!');
    }
}