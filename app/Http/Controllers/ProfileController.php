<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        // dd($user);
        return view('profile.profile', [
            'title' => 'Profile ' . $user->username
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'alamat' => 'required',
            'photo' => 'image'
        ]);
        if ($request->file()) {
            $validated['photo'] = $request->file('photo')->store('photo-profile');
        }
        // dd($validated);
        $user->update($validated);
        return redirect()->route('profile.index', ['user' => $user->username])->with('success', 'Berhasil mengubah profile');
    }

    public function photoDestroy(User $user)
    {
        if ($user->photo) {
            File::delete(public_path('storage/photo-profile/' . $user->photo));
        }
        $user->photo = null;
        $user->save();
        return response()->json(['success' => true]);
    }
}
