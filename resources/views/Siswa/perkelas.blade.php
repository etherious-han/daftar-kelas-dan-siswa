@extends('layout')

@section('konten')

<!-- ===================================================== -->
<!-- =================== JUDUL + BUTTON =================== -->
<!-- ===================================================== -->

<!-- PROFILE DROPDOWN -->
<div class="dropdown position-absolute top-0 end-0 m-3">
    <button class="btn btn-primary rounded-circle dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 45px; height: 45px; padding: 0;">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
        <!-- Profil -->
        <li>
            <a class="dropdown-item" href="{{ route('profile') }}">Profil</a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <!-- Logout -->
        <li>
            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Logout</button>
            </form>
        </li>
    </ul>
</div>




<div class="container">

    <h2 class="text-center mb-5">Daftar Siswa di Kelas {{ $kelas->nama_kelas }}</h2>
    <h5>List Siswa</h5>

    <div class="d-flex mb-3 align-items-center">

        <!-- Tombol Tambah + Kembali -->
        <div>
            <a href="{{ route('siswa.byKelas.tambah', $kelas->id) }}" class="btn btn-success">Tambah Siswa</a>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <!-- Search -->
        <form action="{{ route('siswa.perkelas', $kelas->id) }}" method="GET" class="d-flex ms-auto">
            <div class="input-group">
                @if(request('search'))
                <a href="{{ route('siswa.perkelas', $kelas->id) }}" class="btn btn-outline-secondary">✕</a>
                @endif

                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama siswa..." value="{{ request('search') }}">

                <button class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
</div>


<!-- ===================================================== -->
<!-- ===================== POPUP MODAL ==================== -->
<!-- ===================================================== -->

<!-- Modal Error -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Gagal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ session('error') }}
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


<!-- Modal Success -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Berhasil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ session('success') }}
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



<!-- ===================================================== -->
<!-- ====================== TABEL ========================= -->
<!-- ===================================================== -->

<div class="container">
    @if($siswa->isEmpty())

        <div class="alert alert-warning mt-3 text-center">
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
                    <th style="width: 120px">Aksi</th>
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
                            data-bs-toggle="modal"
                            data-bs-target="#hapusModal{{ $data->id }}">
                            Hapus
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal{{ $data->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">

                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        Yakin ingin menghapus <strong>{{ $data->nama }}</strong>?
                                    </div>

                                    <div class="modal-footer justify-content-center border-0">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                            Batal
                                        </button>

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
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
           {{ $siswa->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>
    @endif
</div>

    <h5 class="text-center text-muted mt-5" style="font-size: 12px;">
    © 2025 Sistem Informasi Kelas – SMKN 1 Ngawi

@endsection  {{-- ini nutup konten --}}

@section('script')

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('errorModal')).show();
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('successModal')).show();
        });
    </script>
    @endif

@endsection
