@extends('layout')

@section('konten')
<div class="container">
    <h4>List Siswa</h4>

    <div class="d-flex justify-content-between mb-3 align-items-center">
        <div>
            <a href="{{ route('siswa.byKelas.tambah', $kelas->id) }}" class="btn btn-success">Tambah Siswa</a>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <form action="{{ route('siswa.perkelas', $kelas->id) }}" method="GET" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control me-2" placeholder="Cari nama siswa..." style="width: 180px;">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
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
                    <a href="{{ route('siswa.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $data->id }}">
                        Hapus
                    </button>

                    <!-- Modal Hapus Centered -->
                    <div class="modal fade" id="hapusModal{{ $data->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $data->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-none">  <!-- <-- Tambahan penting -->
                                <div class="modal-header border-0"> <!-- Hilangin garis di header -->
                                    <h5 class="modal-title" id="hapusModalLabel{{ $data->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body text-center">
                                    Yakin ingin menghapus <strong>{{ $data->nama }}</strong>?
                                </div>

                                <div class="modal-footer justify-content-center border-0"> <!-- Hilangin garis footer -->
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('siswa.delete', $data->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
