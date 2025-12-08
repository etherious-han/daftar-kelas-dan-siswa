<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – SMKN 1 Ngawi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    animation: bgMove 10s infinite alternate;
}
@keyframes bgMove {
    0% { background: linear-gradient(135deg, #4f46e5, #3b82f6); }
    100% { background: linear-gradient(135deg, #3b82f6, #06b6d4); }
}
.card-login {
    width: 380px;
    padding: 30px;
    border-radius: 15px;
    background: #ffffffcc;
    backdrop-filter: blur(10px);
    box-shadow: 0 0 25px rgba(0,0,0,0.2);
    animation: fadeDown 0.7s ease;
}
@keyframes fadeDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.card-login:hover {
    transform: scale(1.02);
    transition: .3s ease;
}
.title-glow {
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    animation: glow 2s infinite alternate;
}
@keyframes glow {
    from { text-shadow: 0 0 5px #4f46e5; }
    to   { text-shadow: 0 0 20px #3b82f6; }
}
.form-control {
    border-radius: 8px;
    transition: 0.3s ease;
}
.form-control:focus {
    transform: scale(1.03);
    box-shadow: 0 0 10px #3b82f6;
}
.btn-login {
    width: 100%;
    border-radius: 8px;
    padding: 10px;
    font-weight: bold;
    background: #4f46e5;
    color: #fff;
    transition: 0.3s ease;
}
.btn-login:hover {
    background: #3b82f6;
    transform: scale(1.03);
    box-shadow: 0 0 15px #3b82f6;
}
.text-danger {
    font-size: 0.85rem;
}
</style>
</head>
<body>

<div class="card card-login">
    <h3 class="title-glow">Login Sistem</h3>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Alert error login --}}
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username..." value="{{ old('username') }}" required>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-login mt-3">Login</button>
    </form>

    <p class="mt-3 text-center">
        Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
    </p>
</div>

</body>
</html>
