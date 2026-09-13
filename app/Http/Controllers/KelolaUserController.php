<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KelolaUserController extends Controller
{
    // Halaman List User
    public function index(Request $request)
    {
        // SECURITY: Cek apakah yang akses adalah Super Admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang boleh masuk sini.');
        }

        $query = Admin::query();

        // Fitur Pencarian
        if ($request->has('search')) {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        // Urutkan: Super Admin di atas, lalu berdasarkan nama
        $users = $query->orderByRaw("FIELD(role, 'admin', 'adminbiasa')")
                       ->orderBy('username', 'asc')
                       ->paginate(10);

        return view('admin.kelolaUser', compact('users'));
    }

    // Tambah User Baru
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'username' => 'required|unique:admin,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,adminbiasa',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi Password
            'role'     => $request->role
        ]);

        return redirect()->back()->with('success', 'User admin berhasil ditambahkan.');
    }

    // Update User
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $user = Admin::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:admin,username,' . $id,
            'role'     => 'required|in:admin,adminbiasa',
        ]);

        $user->username = $request->username;
        $user->role = $request->role;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
    }

    // Hapus User
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        // Mencegah menghapus diri sendiri
        if ($id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user = Admin::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}