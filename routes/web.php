<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

/* =========================
   ROOT
   ========================= */
Route::get('/', function () {
    $user = Auth::user();
    if ($user) {
        return $user->role === 'admin' 
            ? redirect()->route('kelas.index')
            : redirect()->route('siswa.kelas');
    }
    return redirect()->route('login');
});

/* =========================
   AUTH (Login & Register)
   ========================= */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/* =========================
   PROFILE (ADMIN & SISWA)
   ========================= */
Route::middleware(['auth'])->group(function(){
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

/* =========================
   ROUTES ADMIN (ROLE: ADMIN)
   ========================= */
Route::middleware(['auth:admin', 'admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    
    // CRUD Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/delete/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    
    // CRUD Siswa (Admin) - ini untuk halaman /siswa yang list semua siswa
    Route::get('/siswa', [SiswaController::class, 'tampil'])->name('siswa.index');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::post('/siswa/delete/{id}', [SiswaController::class, 'delete'])->name('siswa.delete');
    
    // Siswa per Kelas (Admin view)
    Route::get('/kelas/{id}/siswa', [SiswaController::class, 'perKelas'])->name('siswa.perkelas');
    Route::get('/kelas/{id}/siswa/tambah', [SiswaController::class, 'createByKelas'])->name('siswa.byKelas.tambah');
    Route::post('/kelas/{id}/siswa/tambah', [SiswaController::class, 'storeByKelas'])->name('siswa.byKelas.store');
});

/* =========================
   ROUTES SISWA (ROLE: SISWA)
   ========================= */
Route::middleware(['auth:siswa', 'siswa'])->group(function(){
    // Dashboard Siswa
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    
    // Lihat kelas yang diikuti siswa
    Route::get('/siswa/kelas', [SiswaController::class, 'kelasSiswa'])->name('siswa.kelas');
    Route::get('/siswa/kelas/{id}', [SiswaController::class, 'perKelas'])->name('siswa.kelas.detail');
});