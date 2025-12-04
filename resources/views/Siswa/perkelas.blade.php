@extends('layout')

@section('konten')
<h4>Daftar List Siswa</h4>

<a href="{{ route('siswa.byKelas.tambah', $kelas->id) }}" class="btn btn-success mb-2">Tambah Siswa</a>
<a href="{{ route('kelas.index') }}" class="btn btn-secondary mb-2">Kembali</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>NIS</th>
            <th>No HP</th>
            <th>Jenis Kelamin</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($siswa as $no => $data)
        <tr>
            <td>{{ $no + 1 }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->alamat }}</td>
            <td>{{ $data->nis }}</td>
            <td>{{ $data->no_hp }}</td>
            <td>{{ $data->jenis_kelamin }}</td>
            <td>
                <a href="{{ route('siswa.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('siswa.delete', $data->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
