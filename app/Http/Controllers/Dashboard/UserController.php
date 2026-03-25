<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.users', compact('users'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // validation
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile_number' => 'required|string|max:20|unique:users,mobile_number,' . $user->id,
            'phone_code' => 'required|string|max:3',
            'birthdate' => 'nullable|date',
            'role' => 'required|in:user',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'profile_photo' => 'nullable|image',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
