<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use App\Models\Rapat;
use App\Models\PesertaRapat; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PesertaRapatExport;

class AdminController extends Controller
{
    // ==========================================
    // 1. DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $user = Auth::user();

        // --- A. SIAPKAN QUERY ---
        $queryRapat = Rapat::query();
        $queryPeserta = PesertaRapat::query();

        // [FILTER ROLE]
        // Jika Admin Biasa, filter berdasarkan kolom 'admin_id'
        if ($user->role !== 'admin') {
            $queryRapat->where('admin_id', $user->id); 
            $queryPeserta->whereHas('rapat', function($q) use ($user) {
                $q->where('admin_id', $user->id);
            });
        }

        // --- B. HITUNG STATISTIK ---
        
        $totalRapat = (clone $queryRapat)
                        ->whereMonth('tanggal', Carbon::now()->month)
                        ->whereYear('tanggal', Carbon::now()->year)
                        ->count();

        $idRapatHariIni = (clone $queryRapat)->whereDate('tanggal', Carbon::today())->pluck('rapat_id'); 
        $totalPeserta = PesertaRapat::whereIn('rapat_id', $idRapatHariIni)->count();

        $totalInternal = (clone $queryPeserta)->where('jenis_peserta', 'Internal')->count();
        $totalEksternal = (clone $queryPeserta)->where('jenis_peserta', 'Eksternal')->count();

        // --- C. TABEL RAPAT TERDEKAT ---
        $candidates = (clone $queryRapat)
                           ->whereDate('tanggal', '>=', Carbon::today())
                           ->orderBy('tanggal', 'asc')
                           ->orderBy('waktu_mulai', 'asc')
                           ->get();

        $rapatTerdekat = [];
        foreach ($candidates as $item) {
            if (count($rapatTerdekat) >= 5) break; 
            
            $start = Carbon::parse($item->tanggal . ' ' . $item->waktu_mulai);
            $end   = Carbon::parse($item->tanggal . ' ' . $item->waktu_selesai);
            $now   = Carbon::now();

            if ($now->gt($end)) continue; 

            if ($now->lt($start)) {
                $item->status_text = 'Belum Mulai';
                $item->badge_color = 'bg-yellow-100 text-yellow-700';
            } else {
                $item->status_text = 'Sedang Berlangsung';
                $item->badge_color = 'bg-green-100 text-green-700';
            }
            $rapatTerdekat[] = $item;
        }

        // --- D. TABEL PRESENSI TERBARU ---
        $presensiTerbaru = (clone $queryPeserta)
                                ->with('rapat') 
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        $data = compact('user', 'totalRapat', 'totalPeserta', 'totalInternal', 'totalEksternal', 'rapatTerdekat', 'presensiTerbaru');

        // --- E. RETURN VIEW SESUAI ROLE ---
        if ($user->role == 'adminbiasa') {
            return view('adminbiasa.dashboard', $data);
        } else {
            return view('admin.dashboard', $data); 
        }
    }

    // ==========================================
    // 2. HALAMAN RAPAT (LIST & SEARCH)
    // ==========================================
    public function rapat(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');
        $dateFilter = $request->get('tanggal');
        $now = Carbon::now()->toDateTimeString();

        $rapatQuery = Rapat::with('peserta');

        // [FILTER ROLE]
        if ($user->role !== 'admin') {
            $rapatQuery->where('admin_id', $user->id);
        }

        if ($search) {
            $rapatQuery->where('nama_rapat', 'like', '%' . $search . '%');
        }
        if ($dateFilter) {
            $rapatQuery->whereDate('tanggal', $dateFilter);
        }

        $rapatQuery->orderByRaw("
            CASE
                WHEN CONCAT(tanggal, ' ', waktu_selesai) < '$now' THEN 3
                WHEN CONCAT(tanggal, ' ', waktu_mulai) <= '$now' AND CONCAT(tanggal, ' ', waktu_selesai) >= '$now' THEN 1
                ELSE 2
            END ASC,
            tanggal DESC, waktu_mulai DESC
        ");

        $rapat = $rapatQuery->paginate(10)->withQueryString(); 

        if ($user->role == 'adminbiasa') {
            return view('adminbiasa.rapat', compact('rapat'));
        } else {
            return view('admin.rapat', compact('rapat')); 
        }
    }

    // ==========================================
    // 3. CRUD: CREATE
    // ==========================================
    public function storeTambahRapat(Request $request)
    {
        $validated = $request->validate([
            'nama_rapat' => 'required',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'ruang' => 'required',
            'status_presensi' => 'required|in:auto,buka,tutup',
            'notulensi' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'materi' => 'nullable|url', 
            'dokumentasi' => 'nullable|url',
        ]);

        // [PENTING] Simpan ID user login ke kolom admin_id
        $validated['admin_id'] = Auth::id();

        if ($request->hasFile('notulensi')) {
            $path = $request->file('notulensi')->store('notulensi', 'public');
            $validated['notulensi'] = $path;
        }

        Rapat::create($validated);

        return back()->with('success', 'Rapat berhasil ditambahkan!');
    }

    // ==========================================
    // 4. CRUD: UPDATE
    // ==========================================
    public function updateRapat(Request $request, $id) 
    {
        $rapat = Rapat::findOrFail($id);
        
        // [SECURITY] Cek kepemilikan
        if (Auth::user()->role !== 'admin' && $rapat->admin_id != Auth::id()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin mengedit rapat ini.');
        }

        $validatedData = $request->validate([
            'nama_rapat' => 'required',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'ruang' => 'required',
            'status_presensi' => 'required|in:auto,buka,tutup',
            'notulensi' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'materi' => 'nullable|url',
            'dokumentasi' => 'nullable|url',
        ]);

        if ($request->hasFile('notulensi')) {
            if ($rapat->notulensi && Storage::disk('public')->exists($rapat->notulensi)) {
                Storage::disk('public')->delete($rapat->notulensi);
            }
            $path = $request->file('notulensi')->store('notulensi', 'public');
            $validatedData['notulensi'] = $path;
        } 
        elseif ($request->has('hapus_notulensi') && $request->hapus_notulensi == '1') {
            if ($rapat->notulensi && Storage::disk('public')->exists($rapat->notulensi)) {
                Storage::disk('public')->delete($rapat->notulensi);
            }
            $validatedData['notulensi'] = null;
        }

        $rapat->update($validatedData);

        return redirect()->back()->with('success', 'Rapat berhasil diperbarui');
    }

    // ==========================================
    // 5. CRUD: DELETE RAPAT
    // ==========================================
    public function deleteRapat($id)
    {
        $rapat = Rapat::findOrFail($id);

        // [SECURITY]
        if (Auth::user()->role !== 'admin' && $rapat->admin_id != Auth::id()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin menghapus rapat ini.');
        }

        foreach($rapat->peserta as $peserta) {
            if($peserta->bukti_kehadiran) {
                Storage::disk('public')->delete($peserta->bukti_kehadiran);
            }
        }

        if ($rapat->notulensi && Storage::disk('public')->exists($rapat->notulensi)) {
            Storage::disk('public')->delete($rapat->notulensi);
        }

        $rapat->delete();
        return redirect()->back()->with('success', 'Rapat berhasil dihapus');
    }

    // ==========================================
    // 6. CRUD: DELETE PESERTA
    // ==========================================
    public function deletePeserta($id)
    {
        $peserta = PesertaRapat::with('rapat')->findOrFail($id);

        // [SECURITY]
        if (Auth::user()->role !== 'admin' && $peserta->rapat->admin_id != Auth::id()) {
            abort(403, 'Akses Ditolak: Peserta ini bukan dari rapat Anda.');
        }

        if ($peserta->bukti_kehadiran && Storage::disk('public')->exists($peserta->bukti_kehadiran)) {
            Storage::disk('public')->delete($peserta->bukti_kehadiran);
        }

        $peserta->delete();

        return redirect()->back()->with('success', 'Peserta berhasil dihapus.');
    }

    // ==========================================
    // 7. HALAMAN DATA PESERTA
    // ==========================================
    public function dataPeserta(Request $request)
    {
        $user = Auth::user();
        $query = PesertaRapat::with('rapat');

        // [FILTER ROLE]
        if ($user->role !== 'admin') {
            $query->whereHas('rapat', function($q) use ($user) {
                $q->where('admin_id', $user->id);
            });
        }

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $dataPeserta = $query->latest()->get(); 

        if ($user->role == 'adminbiasa') {
            return view('adminbiasa.dataPeserta', compact('dataPeserta'));
        } else {
            return view('admin.dataPeserta', compact('dataPeserta')); 
        }
    }

    // ==========================================
    // 8. EXPORT EXCEL (DAFTAR HADIR)
    // ==========================================
    public function exportExcel($id_rapat)
    {
        // 1. Ambil data rapat berdasarkan ID
        $rapat = Rapat::findOrFail($id_rapat);
        
        // 2. Ambil peserta yang terdaftar di rapat ini
        $peserta = PesertaRapat::where('rapat_id', $id_rapat)->get();

        // Tambahkan time() agar nama file selalu unik (misal: Daftar_Hadir_103055.xlsx)
        $namaFile = 'Daftar_Hadir_' . time() . '.xlsx'; 

        return Excel::download(new PesertaRapatExport($rapat, $peserta), $namaFile);
    }
}