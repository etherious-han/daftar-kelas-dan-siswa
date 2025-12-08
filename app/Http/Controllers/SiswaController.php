<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    // ============================================================
    //  TAMPIL SISWA PER KELAS (LIST)
    // ============================================================
    public function perKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        // Query siswa di dalam kelas itu
        $query = Siswa::where('kelas_id', $id);

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Wajib paginate biar bisa onEachSide
        $siswa = $query->paginate(10);

        return view('Siswa.perkelas', compact('kelas', 'siswa'));
    }



  // ============================================================
//  STORE / TAMBAH SISWA
// ============================================================
public function storeByKelas(Request $request, $id)
{
    // Ambil data kelas berdasarkan ID
    $kelas = \App\Models\Kelas::findOrFail($id);

    // Cek nama sudah ada atau belum di kelas itu
    $cekNama = \App\Models\Siswa::where('kelas_id', $id)
                ->where('nama', $request->nama)
                ->first();

    if ($cekNama) {
        return redirect()
            ->route('siswa.perkelas', $kelas->id)
            ->with('error', 'Nama siswa sudah ada di kelas ini!');
    }

    // Simpan siswa baru
    \App\Models\Siswa::create([
        'nama' => $request->nama,
        'nis' => $request->nis,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'jenis_kelamin' => $request->jenis_kelamin,
        'kelas_id' => $id,
    ]);

    return redirect()
        ->route('siswa.perkelas', $kelas->id)
        ->with('success', 'Siswa berhasil ditambahkan!');
}



    // ============================================================
    //  EDIT SISWA
    // ============================================================
    public function edit($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);
        $kelas = $siswa->kelas;

        return view('Siswa.edit', compact('siswa', 'kelas'));
    }


    // ============================================================
    //  UPDATE SISWA
    // ============================================================
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->update($request->all());

        return redirect()->route('siswa.perkelas', ['id' => $siswa->kelas_id])
                         ->with('success', 'Data siswa berhasil diupdate!');
    }


    // ============================================================
    //  DELETE SISWA
    // ============================================================
    public function delete($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas_id = $siswa->kelas_id;

        $siswa->delete();

        return redirect()->route('siswa.perkelas', ['id' => $kelas_id])
                         ->with('success', 'Siswa berhasil dihapus!');
    }


    // ============================================================
    //  TAMPILKAN FORM TAMBAH SISWA PER KELAS
    // ============================================================
    public function createByKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('Siswa.tambah', compact('kelas'));
    }


    // ============================================================
    //  HALAMAN INDEX SEMUA SISWA (JIKA ADA)
    // ============================================================
    public function tampil(Request $request)
    {
        $keyword = $request->keyword;

        $data = Siswa::when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('nis', 'like', '%' . $keyword . '%');
        })->paginate(10);

        return view('Siswa.index', compact('data', 'keyword'));
    }
}
