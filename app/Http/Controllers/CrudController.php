<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Keahlian; 

class CrudController extends Controller
{
    private function checkLogin()
    {
        // Cek menggunakan Auth Laravel
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkLogin()) return $redirect;

        // Ambil data dari Database (terbaru diatas)
        $data = Keahlian::latest()->get(); 
        
        return view('crud.index', compact('data'));
    }

    public function create()
    {
        if ($redirect = $this->checkLogin()) return $redirect;
        return view('crud.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkLogin()) return $redirect;

        $request->validate([
            'nama' => 'required|string|max:100',
            'keahlian' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $fotoName = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '.' . $file->extension(); 
            $file->move(public_path('uploads'), $fotoName);
        }

        // Simpan ke Database
        Keahlian::create([
            'nama' => $request->nama,
            'keahlian' => $request->keahlian,
            'foto' => $fotoName
        ]);

        return redirect()->route('crud.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkLogin()) return $redirect;

        // Cari data di database
        $item = Keahlian::findOrFail($id); 
        
        return view('crud.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkLogin()) return $redirect;

        $request->validate([
            'nama' => 'required|string|max:100',
            'keahlian' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $item = Keahlian::findOrFail($id);

        $item->nama = $request->nama;
        $item->keahlian = $request->keahlian;
        
        if ($request->hasFile('foto')) {
            if ($item->foto && File::exists(public_path('uploads/' . $item->foto))) {
                File::delete(public_path('uploads/' . $item->foto));
            }

            $file = $request->file('foto');
            $fotoName = time() . '.' . $file->extension();
            $file->move(public_path('uploads'), $fotoName);
            
            $item->foto = $fotoName;
        }
        
        $item->save(); 

        return redirect()->route('crud.index')->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id)
    {
        if ($redirect = $this->checkLogin()) return $redirect;

        $item = Keahlian::findOrFail($id);
        
        if (!empty($item->foto) && File::exists(public_path('uploads/' . $item->foto))) {
            File::delete(public_path('uploads/' . $item->foto));
        }

        $item->delete(); 

        return redirect()->route('crud.index')->with('success', 'Data berhasil dihapus!');
    }
}