<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Nama tabel sesuai di database
    protected $table = 'siswa';

    protected $fillable = [
        'nama', 'alamat', 'nis', 'no_hp', 'jenis_kelamin', 'kelas_id'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
