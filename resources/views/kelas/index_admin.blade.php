<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kelas SMKN 1 Ngawi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    
</head>
<body class="p-5">

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

    <div class="container">
        <h1 class="text-center mb-5">DAFTAR KELAS SMKN1 NGAWI</h1>

        <!-- Bar atas -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <!-- Tombol Tambah -->
            <a href="{{ route('kelas.create') }}" class="btn btn-success">Tambah Kelas</a>

            <!-- Search -->
            <div class="d-flex mb-3 align-items-center">
                <form action="{{ route('kelas.index') }}" method="GET" class="d-flex flex-grow-1">
                    <div class="input-group">
                        @if(request('search'))
                        <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary">✕</a>
                        @endif
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari kelas..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Jika Tidak Ada Data -->
        @if ($kelas->isEmpty())
            <div class="alert alert-warning text-center">
                Kelas tidak ditemukan.
            </div>
        @else

                                 <!-- Modal Info Tidak Bisa Dihapus -->
        <div class="modal fade" id="cannotDeleteModal" tabindex="-1" aria-labelledby="cannotDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="cannotDeleteLabel">Tidak Bisa Dihapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Kelas "<span id="kelasName"></span>" tidak bisa dihapus karena ada siswa di dalamnya.
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
        <!-- Profil -->
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



        <!-- Tabel -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Lainnya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $k)
                <tr>
                    <td>{{ $loop->iteration + ($kelas->currentPage()-1) * $kelas->perPage() }}</td>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>

                        <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>

                         <!-- Modal Info Tidak Bisa Dihapus -->
        <div class="modal fade" id="cannotDeleteModal" tabindex="-1" aria-labelledby="cannotDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content justify-content-center border-0">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="cannotDeleteLabel">Tidak Bisa Dihapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body justify-content-center border-0">
                Kelas "<span id="kelasName"></span>" tidak bisa dihapus karena kelas tersebut memiliki murid.
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
        </div>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('kelas.destroy', $k->id) }}" 
                              method="POST" class="d-inline"
                              onsubmit="event.preventDefault(); openDeleteModal(this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm  ">Hapus</button>
                        </form>

                        <a href="{{ route('siswa.perkelas', $k->id) }}" class="btn btn-info btn-sm">Daftar Siswa</a>
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

    <!-- Global Modal Delete (Universal) -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    Yakin ingin menghapus data ini?
                </div>

                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button id="confirmDeleteBtn" class="btn btn-danger btn-sm">Hapus</button>
                </div>

            </div>
        </div>
    </div>


    <h5 class="text-center text-muted mt-5" style="font-size: 12px;">
    © 2025 Sistem Informasi Kelas – SMKN 1 Ngawi
</h5>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        @if(session('cannotDelete'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var kelasName = "{{ session('cannotDelete') }}";
            document.getElementById('kelasName').innerText = kelasName;
            var cannotDeleteModal = new bootstrap.Modal(document.getElementById('cannotDeleteModal'));
            cannotDeleteModal.show();
        });
    </script>
    @endif

    
    
    <!-- Script Modal Delete -->
    <script>
        let deleteForm;

        function openDeleteModal(form) {
            deleteForm = form;
            var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            deleteForm.submit();
        });
    </script>

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

</body>
</html>
