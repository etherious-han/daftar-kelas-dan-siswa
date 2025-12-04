<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    // tampil semua kelas
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    // form tambah kelas
    public function create()
    {
        return view('kelas.create');
    }

    // simpan kelas baru
    public function store(Request $request)
    {
        Kelas::create([
            'nama_kelas' => $request->nama_kelas
        ]);
        return redirect()->route('kelas.index');
    }

    // form edit kelas
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    // update kelas
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas
        ]);
        return redirect()->route('kelas.index');
    }

    // hapus kelas
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas.index');
    }
}
