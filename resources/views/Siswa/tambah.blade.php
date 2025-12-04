@extends('layout')

@section('konten')
<h4>Tambah Siswa di Kelas {{ $kelas->nama_kelas }}</h4>

<form action="{{ route('siswa.byKelas.store', ['id' => $kelas->id]) }}" method="POST">
    @csrf

    <label>Nama</label>
    <input type="text" name="nama" class="form-control mb-2" required>

    <label>Alamat</label>
    <input type="text" name="alamat" class="form-control mb-2" required>

    <label>NIS</label>
    <input type="number" name="nis" class="form-control mb-2" required>

    <label>No HP</label>
    <input type="text" name="no_hp" class="form-control mb-2" required>

    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-control mb-2" required>
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select>

    <button type="submit" class="btn btn-primary mt-3">Tambah</button>
</form>

<a href="{{ route('siswa.perkelas', ['id' => $kelas->id]) }}" class="btn btn-secondary mt-2">Kembali ke daftar siswa</a>
@endsection
