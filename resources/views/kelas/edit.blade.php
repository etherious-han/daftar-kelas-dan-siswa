<!DOCTYPE html>
<html>

    <h1 class="text-center mb-5">Edit Kelas SMKN 1 Ngawi</h1>

<head>
    <title>Edit Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Edit Kelas</h2>
        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
