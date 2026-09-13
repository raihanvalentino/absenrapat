<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Rapat;
use App\Models\PesertaRapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // PENTING: Tambahkan ini untuk enkripsi password

class SesiController extends Controller
{
    // Halaman Login
    function index()
    {
        return view('login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            // Jika sukses, arahkan ke dashboard
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah'])->withInput();
    }

    // Halaman Form Presensi (Untuk Peserta)
    public function getForm($rapat_id)
    {
        $rapat = Rapat::findOrFail($rapat_id);
        return view('form', compact('rapat'));
    }

    // Halaman Depan (Landing Page)
    public function welcome()
    {
        // Menampilkan rapat urut dari yang paling baru
        $rapat = Rapat::orderBy('tanggal', 'desc')->orderBy('waktu_mulai', 'asc')->get();
        return view('welcome', compact('rapat'));
    }

    // Proses Logout
    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ==========================================
    // FITUR REGISTER (BARU DITAMBAHKAN)
    // ==========================================

    // 1. Tampilkan Halaman Register
    public function showRegister()
    {
        return view('register'); 
    }

    // 2. Proses Register Admin Biasa
    public function processRegister(Request $request)
    {
        // Validasi Input
        $request->validate([
            'username' => 'required|unique:admin,username', // Username tidak boleh sama
            'password' => 'required|min:6', // Password minimal 6 karakter
        ], [
            'username.unique' => 'Username ini sudah digunakan, silakan pilih yang lain.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        // Simpan ke Database
        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => 'adminbiasa' // Set default role ke 'adminbiasa'
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
    }
}