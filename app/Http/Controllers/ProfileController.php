<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();
        return view('layouts.profile.my-profile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Update data profil
        $user->name = $request->name;
        $user->about = $request->about;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->date_birth = $request->date_birth;
        $user->place_birth = $request->place_birth;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Proses upload foto profil
        if ($request->hasFile('photo_profile_path')) {
            $file = $request->file('photo_profile_path');
            // Nama file unik
            $namaGambar = time() . '_user' . $user->id . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama jika ada
            if ($user->photo_profile_path) {
                $jalurLama = public_path('storage/profile/' . $user->photo_profile_path);
                if (File::exists($jalurLama)) {
                    File::delete($jalurLama);
                }
            }

            // Pindahkan foto baru
            $tujuan = public_path('storage/profile');
            $file->move($tujuan, $namaGambar);

            // Simpan nama file ke database
            $user->photo_profile_path = $namaGambar;
        }

        $user->save();

        return redirect()->back()->with('success', 'Update successfully');
    }

    public function deleteProfile()
    {
        $user = Auth::user();

        if ($user->photo_profile_path) {
            $jalurFoto = public_path('storage/profile/' . $user->photo_profile_path);
            if (File::exists($jalurFoto)) {
                File::delete($jalurFoto);
            }
            $user->photo_profile_path = null;
            $user->save();
        }

        return redirect()->back()->with('message', 'Delete successfully');
    }
}