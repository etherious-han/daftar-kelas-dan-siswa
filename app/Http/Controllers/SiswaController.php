<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    function tampil() {
        $siswa = Siswa::get();
        return view('siswa.tampil', compact('siswa'));
    }

    function tambah() {
        return view('siswa.tambah');
    }

    function submit(Request $request) {
        $siswa = new Siswa();
        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->alamat = $request->alamat;
        $siswa->nis = $request->nis;
        $siswa->no_hp = $request->no_hp;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->save();


        return redirect()->route('siswa.tampil');
    }
    function edit($id)  {
        $siswa = Siswa::find($id);
        return view('siswa.edit', compact('siswa'));        
    }

    function update(request $request, $id) {
        $siswa = Siswa::find($id);
        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->alamat = $request->alamat;
        $siswa->nis = $request->nis;
        $siswa->no_hp = $request->no_hp;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->update();

         return redirect()->route('siswa.tampil');
    }

    function delete($id) {
        $siswa = Siswa::find($id);
        $siswa->delete();
        return redirect()->route('siswa.tampil');
    }
}
