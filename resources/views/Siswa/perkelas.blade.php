@extends('layout')

@section('konten')
<div class="container">

    <!-- Judul Tengah -->
    <h2 class="text-center mb-5">Daftar Siswa di Kelas {{ $kelas->nama_kelas }}</h2>
    <h5>List Siswa</h5>

    <div class="d-flex mb-3 align-items-center">
        <div>
            <a href="{{ route('siswa.byKelas.tambah', $kelas->id) }}" class="btn btn-success">Tambah Siswa</a>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

                <!-- Search Siswa per Kelas -->
     <form action="{{ route('siswa.perkelas', $kelas->id) }}" method="GET" class="d-flex ms-auto">
        <div class="input-group">
            @if(request('search'))
            <a href="{{ route('siswa.perkelas', $kelas->id) }}" class="btn btn-outline-secondary">✕</a>
            @endif
            <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
    </div>

    @if($siswa->isEmpty())
        <div class="alert alert-warning mt-3 text-center" role="alert">
            Tidak ada siswa.
        </div>
    @else
        <table class="table table-bordered mt-2">
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

                        <button type="button" class="btn btn-danger btn-sm" 
                            data-bs-toggle="modal" data-bs-target="#hapusModal{{ $data->id }}">
                            Hapus
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal{{ $data->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-none">

                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        Yakin ingin menghapus <strong>{{ $data->nama }}</strong>?
                                    </div>

                                    <div class="modal-footer justify-content-center border-0">
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
    @endif

</div>
@endsection