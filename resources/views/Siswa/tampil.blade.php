@extends('layout')

@section('konten')
<div class="d-flex">
    <h4>List Siswa</h4>
    <div class="ms-auto">
        <a class="btn btn-success" href="{{ route('siswa.tambah') }}">Tambahkeun Siswa</a>
    </div>
</div>

<table class="table">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Alamat</th>
        <th>NIS</th>
        <th>No HP</th>
        <th>Jenis Kelamin</th>
        <th>Aksi</th>
    </tr>
    @foreach($siswa as $no=>$data)
    <tr>
            <td>{{ $no+1 }}</td>
            <td>{{ $data->nama}}</td>
            <td>{{ $data->kelas->nama_kelas }}</td>
            <td>{{ $data->alamat}}</td>
            <td>{{ $data->nis}}</td>
            <td>{{ $data->no_hp}}</td>
            <td>{{ $data->jenis_kelamin}}</td>
            <td>
                <a href="{{ route('siswa.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('siswa.delete', $data->id) }}" method="post" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

@endsection