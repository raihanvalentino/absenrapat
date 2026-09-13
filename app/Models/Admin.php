<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; 

    // FIX: Matikan timestamps otomatis agar tidak error saat create user
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    // Relasi: Satu admin bisa punya banyak rapat
    public function rapat()
    {
        return $this->hasMany(Rapat::class, 'admin_id');
    }
}