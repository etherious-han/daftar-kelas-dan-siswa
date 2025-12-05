<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kelas SMKN 1 Ngawi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <!-- MODAL KONFIRMASI DELETE -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus kelas ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->

    <div class="container">
        <h1 class="text-center mb-5">Daftar Kelas SMKN 1 Ngawi</h1>

        <div class="d-flex justify-content-between mb-4 align-items-center">
            <!-- Tombol Tambah -->
            <a href="{{ route('kelas.create') }}" class="btn btn-success">Tambah Kelas</a>

            <!-- Search -->
            <form action="{{ route('kelas.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="form-control" placeholder="Cari nama kelas..." style="width: 180px;">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <!-- Tabel Kelas -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Lainnya</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>
                        <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" 
                              style="display:inline;" 
                              onsubmit="event.preventDefault(); openDeleteModal(this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>

                        <a href="{{ route('siswa.perkelas', $k->id) }}" class="btn btn-info btn-sm">Daftar Siswa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
         <div class="d-flex justify-content-center mt-3">
            {{ $kelas->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS UNTUK MODAL -->
    <script>
        let deleteForm;

        function openDeleteModal(form) {
            deleteForm = form;
            var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            myModal.show();
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            deleteForm.submit();
        });
    </script>

</body>
</html>
