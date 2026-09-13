<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelolaUserController; 

Route::get('/', function () {
    return view('welcome');
});

// Middleware GUEST (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/', [SesiController::class, 'welcome'])->name('welcome');
    
    // Login
    Route::get('/login', [SesiController::class, 'index'])->name('login');
    Route::post('/login', [SesiController::class, 'login']);
    
    // Form Absensi Peserta (Bisa diakses publik)
    Route::get('/form/{rapat}', [SesiController::class, 'getForm'])->name('getForm');

    // --- FITUR REGISTER (BARU) ---
    // Route ini menghubungkan tombol 'Register' di halaman welcome ke Controller
    Route::get('/register', [SesiController::class, 'showRegister'])->name('register');
    Route::post('/register', [SesiController::class, 'processRegister'])->name('processRegister');
});

// Middleware AUTH (Hanya bisa diakses jika SUDAH login)
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::match(['get', 'post'], '/logout', [SesiController::class, 'logout'])->name('logout');

    // Dashboard & Rapat
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/rapat', [AdminController::class, 'rapat'])->name('rapat');
    
    // Management Rapat (CRUD)
    Route::post('/admin/storeTambahRapat', [AdminController::class, 'storeTambahRapat'])->name('storeTambahRapat');
    Route::put('/admin/updateRapat/{id}', [AdminController::class, 'updateRapat'])->name('updateRapat');
    Route::delete('/admin/deleteRapat/{id}', [AdminController::class, 'deleteRapat'])->name('deleteRapat');

    // Route ini menangani tombol download Excel di modal rapat
    Route::get('/admin/rapat/{id}/export', [AdminController::class, 'exportExcel'])->name('admin.exportPeserta');
    
    // Management Peserta
    Route::delete('/admin/deletePeserta/{id}', [AdminController::class, 'deletePeserta'])->name('deletePeserta');
    Route::get('/admin/dataPeserta', [AdminController::class, 'dataPeserta'])->name('dataPeserta');

    // --- MANAGEMENT USER (KHUSUS SUPER ADMIN) ---
    // Route ini menghubungkan fitur "Kelola User" yang baru Anda buat
    Route::get('/admin/kelola-user', [KelolaUserController::class, 'index'])->name('admin.kelolaUser');
    Route::post('/admin/kelola-user', [KelolaUserController::class, 'store'])->name('admin.storeUser');
    Route::put('/admin/kelola-user/{id}', [KelolaUserController::class, 'update'])->name('admin.updateUser');
    Route::delete('/admin/kelola-user/{id}', [KelolaUserController::class, 'destroy'])->name('admin.deleteUser');
});