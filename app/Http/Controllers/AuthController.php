<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register', [
            'title' => 'Register'
        ]);
    }

    public function registerUser(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'email' => ['required', 'unique:users,email', 'email'],
            'username' => ['required', 'unique:users,username'],
            'password' => ['required', 'min:8'],
            'alamat' => 'required'
        ], [
            'email.unique' => 'Email telah terdaftar',
            'username.unique' => 'username sudah di gunakan'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        // dd($validated);
        User::create($validated);
        return redirect()->route('login.index')->with('success', 'Berhasil register silahkan login');
    }





    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }
        return back()->with('error', 'Periksa username dan password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index');
    }
}
