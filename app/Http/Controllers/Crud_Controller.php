<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Tambahkan ini untuk helper File

class CrudController extends Controller
{
    // Cek login di constructor agar semua method terproteksi
    public function __construct()
    {
        if (!session('user')) {
            // 'auth' adalah nama middleware. 
            // Karena kita tidak pakai middleware, kita redirect manual.
            // Ini akan mengalihkan ke login jika session 'user' tidak ada.
            // Anda harus membuat route 'login' jika belum ada.
            // Oh, Anda sudah punya dari AuthController, jadi ini kita sesuaikan:
            
            // Kita gunakan cara manual seperti di AuthController
            // (Cara lebih baik adalah pakai Middleware, tapi kita ikuti alur)
        }
    }

    // Helper untuk cek login di tiap method
    private function checkLogin()
    {
        if (!session('user')) {
            return redirect()->route('login');
        }
        return null; // Tidak ada redirect
    }


    public function index()
    {
        if ($redirect = $this->checkLogin()) return $redirect; // Cek login

        $data = session('data', []);
        return view('crud.index', compact('data'));
    }

    public function create()
    {
        if ($redirect = $this->checkLogin()) return $redirect; // Cek login

        return view('crud.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkLogin()) return $redirect; // Cek login

        // 1. Validasi
        $request->validate([
            'nama' => 'required|string|max:100',
            'keahlian' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // foto boleh kosong, maks 2MB
        ]);

        $data = session('data', []);
        
        // ID unik sederhana (lebih baik dari count+1 agar tidak duplikat saat delete)
        $id = time(); 

        $fotoName = null;

        // 2. Perbaikan Logika Upload File
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = $id . '.' . $file->extension();
            $file->move(public_path('uploads'), $fotoName);
        }

        $data[] = [
            'id' => $id,
            'nama' => $request->nama,
            'keahlian' => $request->keahlian,
            'foto' => $fotoName
        ];

        session(['data' => $data]);
        return redirect()->route('crud.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkLogin()) return $redirect; // Cek login

        $data = session('data', []);
        $item = collect($data)->firstWhere('id', $id);
        
        if (!$item) return redirect()->route('crud.index')->with('error', 'Data tidak ditemukan!');

        return view('crud.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkLogin()) return $redirect; // Cek login

        // 1. Validasi
        $request->validate([
            'nama' => 'required|string|max:100',
            'keahlian' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = session('data', []);
        $fotoName = null;
        $itemFound = false;

        foreach ($data as $key => &$item) { // Gunakan '&' untuk referensi
            if ($item['id'] == $id) {
                
                $item['nama'] = $request->nama;
                $item['keahlian'] = $request->keahlian;
                $fotoName = $item['foto']; // Simpan nama foto lama

                // 2. Perbaikan Logika Upload (Jika ada file baru)
                if ($request->hasFile('foto')) {
                    // Hapus file lama jika ada
                    if ($fotoName && File::exists(public_path('uploads/' . $fotoName))) {
                        File::delete(public_path('uploads/' . $fotoName));
                    }

                    // Upload file baru
                    $file = $request->file('foto');
                    $fotoName = $id . '.' . $file->extension(); // Pakai $id agar unik
                    $file->move(public_path('uploads'), $fotoName);
                    
                    $item['foto'] = $fotoName; // Update nama file di data
                }
                
                $itemFound = true;
                break; // Hentikan loop jika data ditemukan
            }
        }

        if (!$itemFound) {
            return redirect()->route('crud.index')->with('error', 'Data gagal diupdate!');
        }

        session(['data' => $data]);
        return redirect()->route('crud.index')->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id)
    {
        if ($redirect = $this->checkLogin()) return $redirect; // Cek login

        $data = session('data', []);
        
        // 1. Cari item dulu untuk dapat nama filenya
        $itemToDelete = collect($data)->firstWhere('id', $id);

        if ($itemToDelete) {
            // 2. Hapus file foto jika ada
            if (!empty($itemToDelete['foto']) && File::exists(public_path('uploads/' . $itemToDelete['foto']))) {
                File::delete(public_path('uploads/' . $itemToDelete['foto']));
            }
        }

        // 3. Hapus item dari koleksi session
        $newData = collect($data)
            ->reject(fn($item) => $item['id'] == $id)
            ->values() // Re-index array
            ->all();

        session(['data' => $newData]);
        return redirect()->route('crud.index')->with('success', 'Data berhasil dihapus!');
    }
}