@extends('layout')

@section('konten')

<h4>Edit Siswa</h4>

<form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
    @csrf
    {{-- Kalau pakai PUT/ PATCH --}}
    {{-- @method('PUT') --}}
    
    <label>Nama</label>
    <input type="text" name="nama" value="{{ $siswa->nama }}" class="form-control mb-2">

    <label>Alamat</label>
    <input type="text" name="alamat" value="{{ $siswa->alamat }}" class="form-control mb-2">

    <label>NIS</label>
    <input type="number" name="nis" value="{{ $siswa->nis }}" class="form-control mb-2">

    <label>No HP</label>
    <input type="text" name="no_hp" value="{{ $siswa->no_hp }}" class="form-control mb-2">

    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-control mb-2">
        <option value="Laki-laki" {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
        <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
    </select>

    <button class="btn btn-primary mt-3">Update</button>
</form>

@endsection
