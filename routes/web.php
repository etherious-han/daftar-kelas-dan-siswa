<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;

/* Halaman welcome (langsung redirect ke /kelas kalau login) */
Route::get('/', function () {
    return Auth::check() ? redirect()->route('kelas.index') : redirect()->route('login');
});

/* ========================
   AUTH (Login & Register)
   ======================== */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/* ========================
   CRUD KELAS (Harus login)
   ======================== */
Route::middleware('auth')->group(function () {
    // CRUD KELAS
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/delete/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');


    // CRUD SISWA
    Route::get('/kelas/{id}/siswa', [SiswaController::class, 'perKelas'])->name('siswa.perkelas');
    Route::get('/kelas/{id}/siswa/tambah', [SiswaController::class, 'createByKelas'])->name('siswa.byKelas.tambah');
    Route::post('/kelas/{id}/siswa/tambah', [SiswaController::class, 'storeByKelas'])->name('siswa.byKelas.store');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::post('/siswa/delete/{id}', [SiswaController::class, 'delete'])->name('siswa.delete');
});
