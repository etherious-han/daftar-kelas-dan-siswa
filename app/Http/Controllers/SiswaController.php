<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Tampil semua siswa per kelas
    public function perKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $siswa = $kelas->siswa; // relasi hasMany
        return view('siswa.perkelas', compact('kelas', 'siswa'));
    }

    // Form tambah siswa per kelas
    public function createByKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('siswa.tambah', compact('kelas'));
    }

    // Simpan siswa per kelas
    public function storeByKelas(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'nis' => 'required|unique:siswa,nis',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        Siswa::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nis' => $request->nis,
            'no_hp' => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $id
        ]);

        return redirect()->route('siswa.perkelas', ['id' => $id])
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
}
