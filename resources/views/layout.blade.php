<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <h1 class="text-center">Daftar Siswa Kelas {{ $kelas->nama_kelas }}</h1>

    <div class="mt-3 container text center">
        @yield('konten')
    </div>

</body>
</html>