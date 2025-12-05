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
