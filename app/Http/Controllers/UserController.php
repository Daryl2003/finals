?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Assuming you have a Role model
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get(); // Fetch users with roles
        return view('admin.users.index', compact('users')); // Adjust path as necessary
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all roles to assign to the user
        return view('admin.users.create', compact('roles')); // Pass roles to the view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id', // Validate role selection
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);

        // Assign role to the user (assuming you have a roles relationship)
        $user->roles()->attach($request->role_id); // Adjust based on your role assignment logic

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // Fetch all roles for the edit form
        return view('admin.users.edit', compact('user', 'roles')); // Pass user and roles to the view
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,id', // Validate role selection
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); // Remove password if not filled
        }

        // Update user details
        $user->update($validatedData);

        // Sync roles with the user (this updates the user's role in the pivot table)
        $user->roles()->sync([$request->role]); 

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Optionally detach roles before deleting user if necessary
        $user->roles()->detach();
        
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}