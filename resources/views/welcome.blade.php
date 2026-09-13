<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sistem Presensi Rapat/Kegiatan</title>
    <link rel="icon" type="image/png" href="/Logo1.png">
    
    {{-- CDN Library --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Style Tambahan untuk Pagination Laravel --}}
    <style>
        .pagination { display: flex; gap: 0.5rem; }
        .page-item { display: inline-flex; }
        .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
            background-color: white;
            color: #374151;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        /* Warna Active Page menjadi #153D53 */
        .page-item.active .page-link {
            background-color: #153D53;
            color: white;
            border-color: #153D53;
        }
        .page-link:hover { background-color: #f3f4f6; }
        .page-item.disabled .page-link {
            color: #9ca3af;
            cursor: not-allowed;
            background-color: #f9fafb;
        }
        
        /* Custom Scrollbar (Opsional agar lebih rapi) */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8; 
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-relaxed flex flex-col min-h-screen">

    {{-- NAVBAR --}}
    <header class="bg-[#153D53] shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="/" class="group flex items-center space-x-4 hover:opacity-90 transition duration-200">
                {{-- Logo --}}
                <img src="/Logo3.png" alt="Kementrans Logo" class="h-12 w-auto rounded shadow-md" />
                
                {{-- Teks Aesthetic --}}
                <div class="flex flex-col">
                    <span class="text-white text-sm font-light tracking-[0.2em] uppercase">
                        Kementerian
                    </span>
                    <span class="text-white text-lg font-bold tracking-widest uppercase leading-none">
                        Transmigrasi
                    </span>
                </div>
            </a>
            <nav class="flex items-center space-x-6">
                <div class="flex space-x-3">
                    
                    <!-- {{-- TOMBOL REGISTER (BARU) --}}
                    <a href="{{ route('register') }}">s
                        <button type="button" class="text-white border border-white hover:bg-white hover:text-[#153D53] font-bold rounded-lg text-sm px-5 py-2.5 mb-2 focus:outline-none focus:ring-4 focus:ring-white/50 transition duration-200 shadow-sm">
                            Register
                        </button>
                    </a> -->

                    {{-- TOMBOL LOGIN --}}
                    <a href="{{ route('login') }}">
                        <button type="button" class="px-6 py-2 text-sm font-medium text-white transition-all duration-300 border border-white/40 rounded-lg hover:bg-white hover:text-[#153D53] hover:border-transparent hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] focus:outline-none">
                            Login
                        </button>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    {{-- HERO SECTION --}}
        <section class="h-[600px] flex items-center justify-center overflow-hidden bg-white">
            
            {{-- Content Container --}}
            <div class="relative z-10 text-center text-black px-6 max-w-4xl mx-auto" data-aos="fade-up">

                {{-- LOGO --}}
                <img src="/Logo2.png" alt="Logo Instansi"
                    class="mx-auto mb-6 w-24 h-auto md:w-32 drop-shadow-xl">

                {{-- JUDUL --}}
                <h2 class="text-4xl md:text-5xl font-bold mb-4 tracking-wide text-[#153D53]">
                    Sistem Presensi Rapat
                </h2>

                {{-- SUBJUDUL --}}
                <p class="text-lg md:text-xl font-light text-[#153D53]tracking-wider mb-6">
                    Digital Attendance for a New Era of Transmigration
                </p>

                {{-- GARIS --}}
                <div class="w-24 h-1 bg-[#153D53] mx-auto rounded-full"></div>
            </div>
        </section>
        
    {{-- MAIN CONTENT (LIST RAPAT - SCROLLABLE TABLE) --}}
    <section id="about" class="py-16 bg-white flex-grow">
        <div class="container mx-auto px-4 text-center max-w-6xl">
            
            <h2 class="text-3xl font-bold mb-2 text-gray-800">Daftar Rapat/Kegiatan</h2>
            <p class="text-gray-500 mb-6 font-medium text-lg">
                Bulan {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('F Y') }}
            </p>

            <div class="rounded-xl shadow-lg border border-gray-200 bg-white flex flex-col overflow-hidden">
                
                {{-- WRAPPER SCROLL --}}
                <div class="overflow-auto max-h-[70vh] w-full"> 
                    
                    {{-- TABLE --}}
                    <table class="w-full min-w-max text-sm text-left text-gray-700">

                        {{-- THEAD --}}
                        <thead class="text-xs text-gray-500 uppercase bg-gray-200 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th class="px-4 py-3 text-center whitespace-nowrap">No</th>
                                <th class="px-4 py-3 whitespace-nowrap">Nama Rapat/Kegiatan</th>
                                <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                                <th class="px-4 py-3 whitespace-nowrap">Waktu</th>
                                <th class="px-4 py-3 whitespace-nowrap">Ruang</th>
                                <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @php
                            // --- LOGIKA FILTERING & SORTING DATA ---
                            $now = \Carbon\Carbon::now('Asia/Jakarta');

                            // 1. Filter: Hanya tampilkan data bulan ini
                            $monthlyRapat = $rapat->filter(function ($item) use ($now) {
                                $meetingDate = \Carbon\Carbon::parse($item->tanggal);
                                return $meetingDate->isSameMonth($now);
                            });

                            // 2. Sorting: Prioritas tampilan
                            $sortedCollection = $monthlyRapat->sortBy(function ($item) use ($now) {
                                $start = \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu_mulai, 'Asia/Jakarta');
                                $end   = \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu_selesai, 'Asia/Jakarta');

                                if ($item->status_presensi == 'buka') return 0;
                                if ($item->status_presensi == 'tutup') return 4;
                                if ($now->between($start, $end)) return 1;
                                if ($now->lessThan($start)) return 2;
                                return 3;
                            });

                            // 3. Pagination Manual
                            $perPage = 10;
                            $currentPage = request()->input('page', 1);
                            $offset = ($currentPage - 1) * $perPage;
                            $currentItems = $sortedCollection->slice($offset, $perPage)->all();
                            
                            $paginatedRapat = new \Illuminate\Pagination\LengthAwarePaginator(
                                $currentItems, 
                                $sortedCollection->count(), 
                                $perPage, 
                                $currentPage,
                                ['path' => request()->url(), 'query' => request()->query()]
                            );
                            @endphp

                            {{-- --- LOOPING DATA --- --}}
                            @foreach($paginatedRapat as $item)
                            <tr class="hover:bg-gray-50 transition duration-150 bg-white">
                                {{-- Nomor Urut --}}
                                <td class="p-3 text-center whitespace-nowrap">
                                    {{ ($paginatedRapat->currentPage() - 1) * $paginatedRapat->perPage() + $loop->iteration }}
                                </td>

                                {{-- Nama --}}
                                <td class="p-3 font-medium text-gray-900 min-w-[200px] max-w-[300px]">
                                    <div class="line-clamp-2 hover:text-[#153D53] transition-colors cursor-help" title="{{ $item->nama_rapat }}">
                                        {{ $item->nama_rapat }}
                                    </div>
                                </td>

                                {{-- Tanggal --}}
                                <td class="p-3 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>

                                {{-- Waktu --}}
                                <td class="p-3 whitespace-nowrap">
                                    {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }} WIB
                                </td>

                                {{-- Ruang --}}
                                <td class="p-3 whitespace-normal w-48 break-words">
                                    {{ $item->ruang }}
                                </td>

                                {{-- Status --}}
                                <td class="p-3 text-center whitespace-nowrap">
                                    @php
                                        $start = \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu_mulai, 'Asia/Jakarta');
                                        $end   = \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu_selesai, 'Asia/Jakarta');

                                        if ($item->status_presensi == 'buka') {
                                            $statusLabel = 'Open';
                                            $badgeClass = 'bg-blue-100 text-blue-800 border border-blue-200 font-bold px-3 py-1';
                                        } elseif ($item->status_presensi == 'tutup') {
                                            $statusLabel = 'Closed';
                                            $badgeClass = 'bg-red-100 text-red-800 border border-red-200 px-3 py-1';
                                        } else {
                                            if ($now->lessThan($start)) {
                                                $statusLabel = 'Belum Dimulai';
                                                $badgeClass = 'bg-gray-200 text-gray-700 px-3 py-1';
                                            } elseif ($now->greaterThan($end)) {
                                                $statusLabel = 'Selesai';
                                                $badgeClass = 'bg-gray-200 text-gray-500 border border-gray-300 px-3 py-1';
                                            } else {
                                                $statusLabel = 'Sedang Berlangsung';
                                                $badgeClass = 'bg-green-100 text-green-800 border border-green-200 animate-pulse font-bold px-3 py-1';
                                            }
                                        }
                                    @endphp
                                    <span class="rounded-full text-xs {{ $badgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="p-3 text-center whitespace-nowrap">
                                    @php
                                        $canAbsen = false;
                                        $msgTitle = ''; $msgText = ''; $msgIcon = 'info';

                                        if ($item->status_presensi == 'tutup') {
                                            $canAbsen = false;
                                            $msgTitle = 'Ditutup Admin'; $msgText = 'Presensi ditutup secara manual oleh admin.'; $msgIcon = 'error';
                                        } elseif ($item->status_presensi == 'buka') {
                                            $canAbsen = true;
                                        } else {
                                            if ($now->between($start, $end)) {
                                                $canAbsen = true;
                                            } elseif ($now->lessThan($start)) {
                                                $canAbsen = false;
                                                $msgTitle = 'Belum Dimulai'; $msgText = 'Presensi baru dibuka otomatis pada pukul '.$item->waktu_mulai.' WIB.';
                                            } else {
                                                $canAbsen = false;
                                                $msgTitle = 'Waktu Habis'; $msgText = 'Batas waktu presensi otomatis telah berakhir.'; $msgIcon = 'warning';
                                            }
                                        }
                                    @endphp

                                    @if($canAbsen)
                                        <a href="{{ route('getForm', $item->rapat_id) }}"
                                        class="inline-block px-4 py-2 bg-[#153D53] hover:bg-[#102e40] text-white rounded-lg text-sm shadow-md transition transform hover:scale-105">
                                            Isi Daftar Hadir
                                        </a>
                                    @else
                                        <button type="button" 
                                            onclick="Swal.fire({ icon: '{{ $msgIcon }}', title: '{{ $msgTitle }}', text: '{{ $msgText }}', confirmButtonColor: '#3085d6' })"
                                            class="px-4 py-2 bg-gray-200 text-gray-500 rounded-lg text-sm cursor-not-allowed border border-gray-300 hover:bg-gray-300">
                                            Isi Daftar Hadir
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> {{-- End Scroll Wrapper --}}

                {{-- Pagination Links --}}
                @if($paginatedRapat->total() > 0)
                <div class="px-4 py-3 flex justify-end items-center border-t bg-gray-50 z-20 relative">
                    <div class="flex flex-col items-end">
                        <span class="text-xs text-gray-500 mb-1">
                            Menampilkan {{ $paginatedRapat->firstItem() }} sampai {{ $paginatedRapat->lastItem() }} dari {{ $paginatedRapat->total() }} data
                        </span>
                        <div class="pagination-container">
                            {{ $paginatedRapat->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @else
                    <div class="p-6 text-center text-gray-500 italic border-t">
                        Belum ada jadwal rapat/kegiatan tersedia pada bulan ini.
                    </div>
                @endif
                
            </div>
        </div>
    </section>

    <footer class="bg-[#153D53] text-white py-10 mt-auto relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

        <div class="container mx-auto px-4 flex flex-col items-center">

            {{-- BAGIAN 1: SOSIAL MEDIA --}}
            <div class="flex flex-wrap justify-center items-center gap-8 mb-8">
                
                {{-- Facebook --}}
                <a href="https://www.facebook.com/kementrans.ri" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center gap-3">
                    <div class="w-14 h-14 flex items-center justify-center rounded-full bg-white/10 border border-white/20 text-gray-300 group-hover:bg-[#1877F2] group-hover:border-[#1877F2] group-hover:text-white transition-all duration-300 shadow-lg group-hover:shadow-[#1877F2]/50 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 transform group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-400 group-hover:text-white tracking-wide transition-colors">Kementrans</span>
                </a>

                {{-- IG Kementrans --}}
                <a href="https://www.instagram.com/kementrans.ri/" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center gap-3">
                    <div class="w-14 h-14 flex items-center justify-center rounded-full bg-white/10 border border-white/20 text-gray-300 group-hover:bg-gradient-to-tr group-hover:from-yellow-400 group-hover:via-red-500 group-hover:to-purple-500 group-hover:border-transparent group-hover:text-white transition-all duration-300 shadow-lg group-hover:shadow-pink-500/50 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 transform group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-400 group-hover:text-white tracking-wide transition-colors">Kementrans</span>
                </a>

                {{-- IG Pusdatin --}}
                <a href="https://www.instagram.com/pusdatin.transmigrasi/" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center gap-3">
                    <div class="w-14 h-14 flex items-center justify-center rounded-full bg-white/10 border border-white/20 text-gray-300 group-hover:bg-gradient-to-tr group-hover:from-yellow-400 group-hover:via-red-500 group-hover:to-purple-500 group-hover:border-transparent group-hover:text-white transition-all duration-300 shadow-lg group-hover:shadow-pink-500/50 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 transform group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-400 group-hover:text-white tracking-wide transition-colors">Pusdatin</span>
                </a>

            </div>

            {{-- BAGIAN 2: ALAMAT & COPYRIGHT --}}
            <div class="w-full max-w-3xl flex flex-col items-center text-center border-t border-white/10 pt-8">
                
                {{-- Alamat --}}
                <div class="flex items-center justify-center gap-2 mb-3 text-gray-300 hover:text-white transition-colors duration-300 group cursor-default">
                    <div class="p-1.5 bg-white/5 rounded-full group-hover:bg-white/10 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 group-hover:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-sm tracking-wide">Jl. TMP Kalibata No.17, Jakarta Selatan, 12750</p>
                </div>

                {{-- Copyright --}}
                <p class="text-xs text-gray-500 font-light">
                    &copy; {{ date('Y') }} Kementerian Transmigrasi Republik Indonesia. All rights reserved.
                </p>

            </div>

        </div>
    </footer>
{{-- ============================================================ --}}
{{-- MODAL SURVEI (FINAL) - Paste di welcome.blade.php --}}
{{-- ============================================================ --}}

{{-- 1. CSS (Tampilan Modal) --}}
<style>
    /* Layar Gelap Belakang */
    .modal_survey {
        display: none;
        position: fixed;
        z-index: 99999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
    }

    /* Kotak Putih Modal */
    .modal-content_survey {
        background-color: #fff;
        margin: 5vh auto;
        width: 90%;
        max-width: 800px;
        height: 90vh; /* Tinggi modal */
        border-radius: 12px;
        position: relative;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }

    /* Header Modal */
    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #ddd;
        display: flex; justify-content: space-between; align-items: center;
        background: #f8f9fa;
        border-radius: 12px 12px 0 0;
    }

    /* Tombol Close (X) */
    .close-btn_survey {
        font-size: 30px; font-weight: bold; color: #666; cursor: pointer;
    }
    .close-btn_survey:hover { color: red; }

    /* Area Iframe */
    .iframe-container {
        flex: 1; width: 100%; position: relative; background: #fff; overflow: hidden;
    }
    #resultIframe { width: 100%; height: 100%; border: none; }

    /* Pesan Bantuan (Warna Kuning) */
    .fallback-msg {
        padding: 12px; text-align: center; background: #fff3cd; color: #856404; font-size: 14px;
        border-top: 1px solid #ffeeba;
    }
    .fallback-msg a { text-decoration: underline; font-weight: bold; color: #856404; }
</style>

{{-- 2. HTML (Kerangka Modal) --}}
<div id="statusModal" class="modal_survey">
    <div class="modal-content_survey">
        
        <div class="modal-header">
            <h3 style="margin:0; font-size:18px;">📋 Isi Survei Singkat</h3>
            <span class="close-btn_survey" onclick="tutupModal()">&times;</span>
        </div>
        
        {{-- TOMBOL PENYELAMAT JIKA LAYAR PUTIH --}}
        <div class="fallback-msg">
            Jika layar putih, <a href="#" id="manualLink" target="_blank">KLIK DI SINI untuk membuka survei</a>.
        </div>

        <div class="iframe-container">
            <iframe id="resultIframe" src=""></iframe>
        </div>

    </div>
</div>

{{-- 3. JAVASCRIPT (Logika Otomatis) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // --- LINK SURVEI ASLI KAMU ---
    const SURVEY_URL = "https://surveidigital.spbe.go.id/embed/survey/eyJzdXJ2ZXlfaWQiOjIsInNlcnZpY2VfaWQiOjE3MCwiaG9zdCI6Imh0dHBzOi8vcHJlc2Vuc2ktcmFwYXQudHJhbnNtaWdyYXNpLmdvLmlkLGh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8saHR0cDovLzEyNy4wLjAuMTo4MDAwLyIsImtleSI6ImgwaVRTUlR4In0=/embed/view/";

    const modal = document.getElementById('statusModal');
    const iframe = document.getElementById('resultIframe');
    const manualLink = document.getElementById('manualLink');

    // Fungsi Buka Modal
    function openSurveyModal() {
        modal.style.display = "block";
        document.body.style.overflow = "hidden"; // Stop scroll
        
        // Isi Link Iframe & Tombol Manual
        iframe.src = SURVEY_URL;
        manualLink.href = SURVEY_URL;
    }

    // Fungsi Tutup Modal
    function tutupModal() {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
        
        // Hapus '?survey=open' dari URL supaya pas refresh modal gak muncul lagi
        const url = new URL(window.location);
        url.searchParams.delete('survey');
        window.history.replaceState({}, '', url);
    }

    // --- LOGIC UTAMA: CEK URL SAAT HALAMAN DIBUKA ---
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil parameter URL
        const urlParams = new URLSearchParams(window.location.search);
        
        // Kalau di URL ada tulisan '?survey=open'
        if (urlParams.get('survey') === 'open') {
            
            // 1. Munculkan Alert "Berhasil" dulu
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data presensi Anda telah disimpan.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // 2. Setelah Alert hilang, Munculkan Modal Survei
                openSurveyModal();
            });
        }
    });

    // Tutup modal kalau klik area gelap
    window.onclick = function(event) {
        if (event.target == modal) {
            tutupModal();
        }
    }
</script>
</body>
</html>