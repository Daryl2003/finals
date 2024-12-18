<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User; // Import the User model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Show the admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // List all users
    public function index()
    {
        $users = User::with('roles')->get(); // Fetch all users with their roles
        return view('admin.users.index', compact('users'));
    }

    // Show the form to create a new user
    public function create()
    {
        $roles = Role::all(); // Fetch all roles to assign
        return view('admin.users.create', compact('roles'));
    }

    // Store a new user in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Ensure password confirmation is present
            'role' => 'required|exists:roles,id', // Validate role as an ID
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role to user
        $user->roles()->attach($request->role);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Show the form to edit a user
    public function edit(User $user)
    {
        $roles = Role::all(); // Fetch all roles for the dropdown
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Update a user's details and role
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
        'role' => 'required|in:1,2', // Assuming 1 = Admin, 2 = Customer
    ]);

    // Update user's data
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    
    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    // Update role in the users table
    $user->role_id = $request->input('role');
    $user->role = Role::find($request->input('role'))->name;
    
    // Sync roles in the pivot table
    $user->roles()->sync([$request->input('role')]);

    // Save changes to the user
    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
}

    

    // Delete a user
    public function destroy(User $user)
    {
        $user->roles()->detach(); // Detach roles before deleting user if necessary
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}