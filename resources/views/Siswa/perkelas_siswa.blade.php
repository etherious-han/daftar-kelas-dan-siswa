@extends('layouts.layout')

@section('konten')

    <!-- Modal Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Error</h5>
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
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
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

     <!-- PROFILE DROPDOWN -->
        <div class="dropdown position-absolute top-0 end-0 m-3">
            <button class="btn btn-primary rounded-circle dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 45px; height: 45px; padding: 0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>


    <div class="container">
        <h1 class="text-center mb-4">DAFTAR SISWA - {{ $kelas->nama_kelas }}</h1>

        <!-- Bar atas: Tombol Kembali & Search -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            
            <!-- Tombol Kembali -->
            <a href="{{ route('siswa.kelas') }}" class="btn btn-secondary">Kembali</a>

            <!-- Search -->
            <form action="{{ route('siswa.kelas.detail', $kelas->id) }}" method="GET" class="d-flex">
                <div class="input-group">
                    @if(request('search'))
                    <a href="{{ route('siswa.kelas.detail', $kelas->id) }}" class="btn btn-outline-secondary">✕</a>
                    @endif
                    <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
                    <button class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

    

        <!-- Jika Tidak Ada Data -->
        @if ($siswa->isEmpty())
            <div class="alert alert-warning text-center">
                @if(request('search'))
                    Siswa dengan nama "{{ request('search') }}" tidak ditemukan.
                @else
                    Belum ada siswa di kelas ini.
                @endif
            </div>
        @else

        <!-- Tabel Siswa (Read-Only) -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Jenis Kelamin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $s)
                <tr>
                    <td>{{ $loop->iteration + ($siswa->currentPage()-1) * $siswa->perPage() }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->alamat }}</td>
                    <td>{{ $s->no_hp }}</td>
                    <td>{{ $s->jenis_kelamin }}</td>
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
    </h5>

@endsection

@section('script')
    <!-- Script Modal Error/Success -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var error = "{{ session('error') }}";
            var success = "{{ session('success') }}";

            if(error){
                var modal = new bootstrap.Modal(document.getElementById('errorModal'));
                modal.show();
            }
            if(success){
                var modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
            }
        });
    </script>
@endsection