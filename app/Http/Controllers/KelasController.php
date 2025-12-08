<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
   public function index(Request $request)
{
    $query = Kelas::query();

    // Search
    if ($request->search) {
        $query->where('nama_kelas', 'like', '%' . $request->search . '%');
    }

    // Wajib paginate biar layout berubah
    $kelas = $query->paginate(10)->withQueryString();

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
    try {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        // Ubah kata-kata popup sukses di sini
        return redirect()->route('kelas.index')
                         ->with('success', 'Yeay! Kelas berhasil ditambahkan');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Ubah kata-kata popup error di sini
        return redirect()->route('kelas.index')
                         ->with('error', 'Ups! Kelas ini sudah ada');
    }
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
         return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil di update!');
    }

    // hapus kelas
    public function destroy($id)
{
    $kelas = Kelas::findOrFail($id);

    if ($kelas->siswa()->count() > 0) {
        // kembalikan dengan session untuk trigger modal
        return redirect()->route('kelas.index')
                         ->with('cannotDelete', $kelas->nama_kelas);
    }

    $kelas->delete();
    return redirect()->route('kelas.index')
                     ->with('success', 'Kelas berhasil dihapus!');
}


}
