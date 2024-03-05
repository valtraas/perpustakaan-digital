<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserManagement extends Controller
{
    public function index()
    {
        return view('user.user', [
            'title' => 'User Management',
            'user' => User::where('roles_id', '<>', 2)->get(),
        ]);
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'nama_lengkap' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'unique:users,username'],
            'password' => 'required',
            'roles_id' => 'required',
        ]);
        $validate['password'] = Hash::make($validate['password']);
        User::create($validate);
        return redirect()->route('user.index')->with('success', 'Berhasil menambahkan user');
    }


    public function destroy(User $user)
    {
        if ($user->photo) {
            Storage::delete($user->photo);
        }
        $user->delete();
        return back()->with('success', 'Berhasil menghapus user');
    }
}
