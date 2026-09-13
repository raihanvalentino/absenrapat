<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rapat', function (Blueprint $table) {
            // Menambahkan kolom notulensi (nullable karena tidak wajib)
            $table->string('notulensi')->nullable()->after('status_presensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapat', function (Blueprint $table) {
            //
        });
    }
};
