<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagement extends Controller
{
    public function index()
    {
        return view('user.user', [
            'title' => 'User Management',
            'user' => User::where('roles_id', '<>', 2)->get(),
        ]);
    }
    public function update(Request $request, User $user)
    {
        $role = $request->input('role');
        $user->update([
            'roles_id' => $role
        ]);
        return back()->with('success', 'Berhasil merubah role user');
    }
}
