<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaRapat extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'peserta_rapat';

    /**
     * Primary Key tabel.
     * Wajib diset 'peserta_id' agar Eloquent tahu kolom mana yang jadi ID utama.
     */
    protected $primaryKey = 'peserta_id';

    /**
     * Kolom-kolom yang boleh diisi secara massal (create/update).
     */
    protected $fillable = [
        'rapat_id',
        'jenis_peserta',   // Contoh: 'Internal' atau 'Eksternal'
        'tipe_peserta',    // (Opsional) Jika ada klasifikasi lain
        'nama',
        'pangkat_golongan',
        'jabatan',
        'unit_kerja',      // Biasanya untuk pegawai internal
        'asal_instansi',   // Biasanya untuk tamu eksternal
        'nomor_kontak',
        'nip_nik',
        'bukti_kehadiran', // Menyimpan path file gambar/foto
    ];

    /**
     * Relasi ke model Rapat.
     * Setiap Peserta milik satu Rapat.
     */
    public function rapat()
    {
        // Parameter 2: Foreign Key di tabel peserta_rapat (rapat_id)
        // Parameter 3: Primary Key di tabel rapat (rapat_id)
        return $this->belongsTo(Rapat::class, 'rapat_id', 'rapat_id');
    }
}