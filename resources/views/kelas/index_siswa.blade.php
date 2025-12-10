<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kelas SMKN 1 Ngawi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

    <div class="container">
        <h1 class="text-center mb-5">DAFTAR KELAS SMKN1 NGAWI</h1>

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

        <!-- Search Bar -->
        <div class="d-flex justify-content-end mb-4">
            <form action="{{ route('siswa.kelas') }}" method="GET" class="d-flex">
                <div class="input-group">
                    @if(request('search'))
                    <a href="{{ route('siswa.kelas') }}" class="btn btn-outline-secondary">✕</a>
                    @endif
                    <input type="text" name="search" class="form-control" placeholder="Cari kelas..." value="{{ request('search') }}">
                    <button class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

        <!-- Alert jika tidak ada kelas -->
        @if($kelas->isEmpty())
            <div class="alert alert-warning text-center">
                @if(request('search'))
                    Kelas "{{ request('search') }}" tidak ditemukan.
                @else
                    Anda belum terdaftar di kelas manapun. Silakan hubungi admin.
                @endif
            </div>
        @else

        <!-- Tabel Kelas -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                   
                    
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $k)
                <tr>
                    <td>{{ $loop->iteration + ($kelas->currentPage()-1) * $kelas->perPage() }}</td>
                    <td>{{ $k->nama_kelas }}</td>
                    
                  
                    <td>
                        <a href="{{ route('siswa.kelas.detail', $k->id) }}" class="btn btn-info btn-sm">Lihat Daftar Siswa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $kelas->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>

        @endif
    </div>

    <h5 class="text-center text-muted mt-5" style="font-size: 12px;">
        © 2025 Sistem Informasi Kelas – SMKN 1 Ngawi
    </h5>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>