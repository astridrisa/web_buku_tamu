<?php

namespace App\Http\Controllers;

use App\Models\TamuModel;
use App\Models\JenisIdentitasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TamuController extends Controller
{
    // Menampilkan form registrasi
    public function index()
    {
        $jenisIdentitas = JenisIdentitasModel::all(); // Ambil semua jenis identitas
        return view('pages.tamu.register', compact('jenisIdentitas'));
    }

    // Menyimpan data tamu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'tujuan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jumlah_rombongan' => 'nullable|integer|min:1',
            'jenis_identitas_id' => 'required|exists:jenis_identitas,id',
        ]);

        $validated['qr_code'] = Str::uuid();

        $tamu = Tamu::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi tamu berhasil',
            'tamu' => $tamu
        ], 201);
    }
}
