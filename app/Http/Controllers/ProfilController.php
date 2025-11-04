<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        return view('user.profil-dummy');
    }


    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // base64
        ]);

        // Ambil base64
        $img = $request->image;

        // Decode base64 → file
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $imageData = base64_decode($img);

        // Buat filename
        $filename = 'profile_' . time() . '.png';

        // Simpan ke storage/app/public/profile/
        Storage::disk('public')->put('profile/' . $filename, $imageData);

        return response()->json([
            'status' => 'success',
            'file' => 'storage/profile/' . $filename
        ]);
    }
}
