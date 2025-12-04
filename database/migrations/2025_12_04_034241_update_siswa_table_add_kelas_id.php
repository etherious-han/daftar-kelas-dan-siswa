<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('siswa', function (Blueprint $table) {

        // hapus kolom kelas (karena mau diganti kelas_id)
        $table->dropColumn('kelas');

        // tambah kolom kelas_id (relasi)
        $table->unsignedBigInteger('kelas_id')->after('id');
        $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('siswa', function (Blueprint $table) {
        $table->string('kelas'); // rollback
        $table->dropForeign(['kelas_id']);
        $table->dropColumn('kelas_id');
    });
}

};
