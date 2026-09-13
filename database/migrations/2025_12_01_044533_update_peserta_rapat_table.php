<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta_rapat', function (Blueprint $table) {
            // Ubah kolom yang terlalu pendek
            $table->string('tipe_peserta', 50)->nullable()->change();
            $table->string('jenis_peserta', 50)->change();
            $table->string('nama', 100)->change();
            $table->string('pangkat_golongan', 50)->nullable()->after('nama');
            $table->string('jabatan', 100)->change();
            $table->string('unit_kerja', 150)->nullable()->change();
            $table->string('asal_instansi', 150)->nullable()->change();
            $table->string('nomor_kontak', 20)->nullable()->change();
            $table->string('nip_nik', 30)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peserta_rapat', function (Blueprint $table) {
            // Kembalikan ke ukuran sebelumnya jika rollback
            $table->string('tipe_peserta', 10)->nullable()->change();
            $table->string('jenis_peserta', 10)->change();
            $table->string('nama', 50)->change();
            $table->string('pangkat_golongan', 50)->nullable()->change();
            $table->string('jabatan', 50)->change();
            $table->string('unit_kerja', 100)->nullable()->change();
            $table->string('asal_instansi', 100)->nullable()->change();
            $table->string('nomor_kontak', 15)->nullable()->change();
            $table->string('nip_nik', 20)->nullable()->change();
        });
    }
};