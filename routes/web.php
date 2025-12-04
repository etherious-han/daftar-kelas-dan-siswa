<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* CRUD KELAS */
Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
Route::get('/kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
Route::delete('/kelas/delete/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

/* CRUD SISWA */
Route::get('/kelas/{id}/siswa', [SiswaController::class, 'perKelas'])->name('siswa.perkelas');
Route::get('/kelas/{id}/siswa/tambah', [SiswaController::class, 'createByKelas'])->name('siswa.byKelas.tambah');
Route::post('/kelas/{id}/siswa/tambah', [SiswaController::class, 'storeByKelas'])->name('siswa.byKelas.store');

Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
Route::post('/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
Route::post('/siswa/delete/{id}', [SiswaController::class, 'delete'])->name('siswa.delete');
