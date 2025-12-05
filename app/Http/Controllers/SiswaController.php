<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{


    public function perKelas(Request $request, $id)
{
    $kelas = Kelas::findOrFail($id);

    // ambil relasi siswa dari kelas
    $query = $kelas->siswa();

    // Fitur search
    if ($request->has('search') && $request->search != '') {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    $siswa = $query->get();

    return view('Siswa.perkelas', compact('kelas', 'siswa'));
}


    public function storeByKelas(Request $request, $id)
{
    // validasi data input
    $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'nis' => 'required|string|unique:siswa,nis',
        'no_hp' => 'required|string',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    ]);

    // buat siswa baru dan hubungkan ke kelas sesuai $id
    Siswa::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'nis' => $request->nis,
        'no_hp' => $request->no_hp,
        'jenis_kelamin' => $request->jenis_kelamin,
        'kelas_id' => $id,
    ]);

    // redirect kembali ke daftar siswa kelas itu
    return redirect()->route('siswa.perkelas', $id)
                 ->with('success', 'Siswa berhasil ditambahkan!');
}

    // Edit siswa
    public function edit($id)
    {
        $siswa = Siswa::with('kelas')->find($id); 
        $kelas = $siswa->kelas; 
        return view('Siswa.edit', compact('siswa', 'kelas'));
    }


    // Update siswa
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());
        return redirect()->route('siswa.perkelas', ['id' => $siswa->kelas_id])
                         ->with('success', 'Data siswa berhasil diupdate!');
    }

    // Hapus siswa
    public function delete($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas_id = $siswa->kelas_id;
        $siswa->delete();
        return redirect()->route('siswa.perkelas', ['id' => $kelas_id])
                         ->with('success', 'Siswa berhasil dihapus!');
    }

public function createByKelas($id)
{
    // ambil data kelas sesuai ID
    $kelas = Kelas::findOrFail($id);

    // tampilkan view tambah siswa dengan data kelas
    return view('Siswa.tambah', compact('kelas'));
}



}
