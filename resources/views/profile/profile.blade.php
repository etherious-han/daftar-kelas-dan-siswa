<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('siswa.dashboard') }}">
                {{ auth()->user()->role === 'admin' ? 'Admin Panel' : 'Portal Siswa' }}
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Profile Saya</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label"><strong>Nama:</strong></label>
                            <p class="form-control-plaintext">{{ Auth::user()->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Email:</strong></label>
                            <p class="form-control-plaintext">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Role:</strong></label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'primary' : 'success' }}">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </p>
                        </div>

                        <a href="{{ auth()->user()->role === 'admin' ? route('kelas.index') : route('siswa.dashboard') }}" class="btn btn-secondary">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>