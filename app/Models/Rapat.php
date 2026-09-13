<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    use HasFactory;

    protected $table = 'rapat'; 
    protected $primaryKey = 'rapat_id'; 

    protected $fillable = [
        'nama_rapat',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'ruang',
        'status_presensi',
        'notulensi',
        'materi',
        'dokumentasi',
        'admin_id' // <--- INI PALING PENTING
    ];

    // Relasi ke Peserta
    public function peserta()
    {
        // Parameter ke-2: Foreign Key di tabel peserta_rapat (rapat_id)
        // Parameter ke-3: Local Key di tabel rapat (rapat_id)
        return $this->hasMany(PesertaRapat::class, 'rapat_id', 'rapat_id');
    }

    // (Opsional tapi Direkomendasikan) Relasi ke Admin pembuat
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}