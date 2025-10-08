<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
public function index()
{
    $user = auth()->user();
    return view('pages.profile', compact('user'));
}

public function update(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Update nama & email
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Buat folder manual kalau belum ada
        $destinationPath = storage_path('app/public/profile_photos');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true); // recursive & writeable
        }

        // Hapus foto lama kalau ada
        if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
            unlink(public_path($user->profile_photo));
        }

        // Pindahkan file dari temp ke storage
        $file->move($destinationPath, $filename);

        // Simpan path di DB supaya bisa diakses via browser
        $user->profile_photo = 'storage/profile_photos/' . $filename;
        $user->save();
    }

    return back()->with('success', 'Profil berhasil diperbarui.');
}


public function updatePassword(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Password lama salah.']);
    }

    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('success', 'Password berhasil diubah.');
}
}
