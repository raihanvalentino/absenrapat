<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Rapat</title>
    <link rel="icon" type="image/png" href="/Logo1.png">
    @include('layouts.header')
    @vite('resources/css/app.css') 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">
    
    @include('layouts.sidebar')
    
    <div class="p-6 sm:ml-64 mt-20">
          
        {{-- HEADER SECTION --}}
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Rapat (Super Admin)</h2>
            <button data-modal-target="tambah-modal" data-modal-toggle="tambah-modal"
                class="px-5 py-2.5 bg-[#153D53] text-white rounded-lg shadow-md hover:bg-[#102e3f] transition transform hover:scale-105">
                + Tambah Rapat
            </button>
        </div>

        {{-- SEARCH + FILTER SECTION --}}
        <form method="GET" action="{{ route('rapat') }}" class="flex flex-col sm:flex-row gap-3 mb-6 bg-white p-4 rounded-lg shadow-sm">
            <div class="relative w-full sm:w-1/3">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" name="search" id="searchInput" placeholder="Cari nama rapat..."
                    value="{{ request('search') }}"
                    class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#153D53] focus:border-[#153D53]">
            </div>

            <div class="flex gap-2 w-full sm:w-auto">
                <input type="date" name="tanggal" id="filterDate"
                    value="{{ request('tanggal') }}"
                    class="px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#153D53] text-sm text-gray-700">
                <button type="submit" class="px-4 py-2 bg-[#153D53] text-white text-sm rounded-lg hover:bg-[#102e3f] transition">Filter</button>
                @if(request('search') || request('tanggal'))
                <a href="{{ route('rapat') }}" class="px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 transition flex items-center justify-center">Reset</a>
                @endif
            </div>
        </form>

        {{-- ALERT MESSAGE --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- MAIN TABLE --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-200 flex flex-col justify-between min-h-[500px]">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-center w-16">No</th>
                            <th class="px-4 py-3">Nama Rapat</th>
                            <th class="px-4 py-3">Dibuat Oleh</th> {{-- KOLOM BARU --}}
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Ruang</th>
                            <th class="px-4 py-3 text-center">Notulensi</th>
                            <th class="px-4 py-3 text-center">Materi</th>
                            <th class="px-4 py-3 text-center">Dokumentasi</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Kontrol Presensi</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="rapatTableBody">
                        @forelse($rapat as $item)
                        <tr class="border-b hover:bg-gray-50 rapat-row transition-colors" 
                            data-nama="{{ strtolower($item->nama_rapat) }}" 
                            data-tanggal="{{ $item->tanggal }}">
                            
                            <td class="p-4 text-center font-medium row-number" 
                                data-original="{{ ($rapat->currentPage() - 1) * $rapat->perPage() + $loop->iteration }}">
                                {{ ($rapat->currentPage() - 1) * $rapat->perPage() + $loop->iteration }}
                            </td>
                            
                            <td class="p-4">
                                <button data-modal-target="peserta-modal-{{ $item->rapat_id }}"
                                        data-modal-toggle="peserta-modal-{{ $item->rapat_id }}"
                                        class="text-[#153D53] font-semibold hover:underline text-left">
                                    {{ $item->nama_rapat }}
                                </button>
                            </td>

                            {{-- KOLOM DIBUAT OLEH (BARU) --}}
                            <td class="p-4">
                                @if($item->admin)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
                                        {{ $item->admin->username }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs italic">Unknown</span>
                                @endif
                            </td>
                            
                            <td class="p-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="p-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}</td>
                            <td class="p-4">{{ $item->ruang }}</td>

                            {{-- KOLOM NOTULENSI --}}
                            <td class="p-4 text-center">
                                @if($item->notulensi)
                                    <a href="{{ asset('storage/' . $item->notulensi) }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-xs hover:bg-indigo-100 transition">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        PDF
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>

                            {{-- KOLOM MATERI (LINK) --}}
                            <td class="p-3 text-center whitespace-nowrap">
                                    @if($item->materi)
                                        <a href="{{ $item->materi }}" target="_blank" 
                                        class="inline-flex items-center px-3 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-full text-xs hover:bg-purple-100 transition shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Link Materi
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                            </td> 

                            {{-- KOLOM DOKUMENTASI (LINK) --}}
                            <td class="p-4 text-center">
                                @if($item->dokumentasi)
                                    <a href="{{ $item->dokumentasi }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs hover:bg-green-100 transition">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Foto/Link
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $startDateTime = \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu_mulai);
                                    $endDateTime = \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu_selesai);

                                    if ($now->lessThan($startDateTime)) {
                                        $statusLabel = 'Belum Dimulai'; $statusClass = 'bg-blue-100 text-blue-800 border border-blue-200';
                                    } elseif ($now->greaterThan($endDateTime)) {
                                        $statusLabel = 'Selesai'; $statusClass = 'bg-green-100 text-green-800 border border-green-200';
                                    } else {
                                        $statusLabel = 'Sedang Berlangsung'; $statusClass = 'bg-yellow-100 text-yellow-800 border border-yellow-200 animate-pulse font-bold';
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-center">
                                @if($item->status_presensi == 'auto')
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-500">Otomatis (Jadwal)</span>
                                @elseif($item->status_presensi == 'buka')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Dibuka Manual</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">Ditutup Manual</span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Edit --}}
                                    <button type="button"
                                        data-modal-target="edit-modal-{{ $item->rapat_id}}" 
                                        data-modal-toggle="edit-modal-{{ $item->rapat_id}}" 
                                        class="p-2 text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition"
                                        title="Edit & Upload">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                                    </button>

                                    {{-- Delete --}}
                                    <button type="button"
                                        data-modal-target="delete-modal-{{ $item->rapat_id }}"
                                        data-modal-toggle="delete-modal-{{ $item->rapat_id }}"
                                        class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 transition"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="py-12 text-center text-gray-500"> {{-- Colspan updated --}}
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <p class="text-lg font-medium">Data rapat tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="paginationLinks" class="px-6 py-4 border-t border-gray-200 flex justify-end">
                {{ $rapat->links() }}
            </div>
            
            <div id="noResults" class="hidden"></div>
        </div>

    </div>

    {{-- ================================================================= --}}
    {{-- AREA MODALS (Tidak ada perubahan, gunakan kode modal dari file sebelumnya) --}}
    
    {{-- 1. MODAL TAMBAH RAPAT --}}
    <div id="tambah-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Rapat Baru</h3>
                    <button type="button" data-modal-hide="tambah-modal" class="text-gray-400 hover:text-gray-900"><svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>
                </div>
                <div class="p-6">
                    <form action="{{ route('storeTambahRapat') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Nama Rapat</label>
                                <input type="text" name="nama_rapat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                <input type="date" name="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block mb-2 text-sm font-medium">Waktu Mulai</label><input type="time" name="waktu_mulai" class="w-full border p-2 rounded-lg bg-gray-50"></div>
                                <div><label class="block mb-2 text-sm font-medium">Waktu Selesai</label><input type="time" name="waktu_selesai" class="w-full border p-2 rounded-lg bg-gray-50"></div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Ruang</label>
                                <input type="text" name="ruang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required>
                            </div>
                            
                            {{-- UPLOAD NOTULENSI --}}
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Upload Notulensi (Opsional)</label>
                                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="notulensi" type="file" accept=".pdf,.doc,.docx">
                                <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX (Max 5MB).</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Link Materi (Google Drive)</label>
                                    <input type="url" name="materi" placeholder="https://..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                </div>
                                {{-- INPUT DOKUMENTASI (BARU) --}}
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Link Dokumentasi (Foto/Drive)</label>
                                    <input type="url" name="dokumentasi" placeholder="https://..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                </div>
                            </div>

                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="text-white bg-[#153D53] hover:bg-[#102e3f] font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
                        </div>
                        <div class="mt-4">
                             <label class="block mb-2 text-sm font-medium text-gray-900">Status Presensi Awal</label>
                             <select name="status_presensi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                 <option value="auto" selected>Otomatis (Sesuai Jam)</option>
                                 <option value="buka">Langsung Buka</option>
                                 <option value="tutup">Langsung Tutup</option>
                             </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- LOOPING MODALS --}}
    @foreach($rapat as $item)

        {{-- 2. MODAL EDIT --}}
        <div id="edit-modal-{{ $item->rapat_id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow-xl">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-xl font-semibold text-gray-900">Edit Rapat</h3>
                        <button type="button" data-modal-hide="edit-modal-{{ $item->rapat_id}}" class="text-gray-400 hover:text-gray-900"><svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('updateRapat', ['id' => $item->rapat_id]) }}" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="space-y-4">
                                <div><label class="block mb-2 text-sm font-medium">Nama Rapat</label><input type="text" name="nama_rapat" value="{{ $item->nama_rapat}}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required></div>
                                <div><label class="block mb-2 text-sm font-medium">Tanggal</label><input type="date" name="tanggal" value="{{ $item->tanggal}}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div><label class="block mb-2 text-sm font-medium">Mulai</label><input type="time" name="waktu_mulai" value="{{ $item->waktu_mulai}}" class="w-full border p-2 rounded-lg"></div>
                                    <div><label class="block mb-2 text-sm font-medium">Selesai</label><input type="time" name="waktu_selesai" value="{{ $item->waktu_selesai}}" class="w-full border p-2 rounded-lg"></div>
                                </div>
                                
                                {{-- UPDATE: Bagian Upload Notulensi dengan Checkbox Hapus --}}
                                <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Upload File Notulensi</label>
                                    
                                    @if($item->notulensi)
                                        <div class="mb-3">
                                            {{-- Link File Saat Ini --}}
                                            <div class="flex items-center text-sm text-green-600 mb-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                File tersimpan. <a href="{{ asset('storage/' . $item->notulensi) }}" target="_blank" class="underline ml-1 font-bold hover:text-green-800">Lihat File Saat Ini</a>
                                            </div>
                                
                                            {{-- Checkbox Hapus File --}}
                                            <div class="flex items-center bg-white p-2 rounded border border-red-200">
                                                <input id="hapus_notulensi_{{ $item->rapat_id }}" type="checkbox" name="hapus_notulensi" value="1" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500">
                                                <label for="hapus_notulensi_{{ $item->rapat_id }}" class="ml-2 text-sm font-medium text-red-600 cursor-pointer">
                                                    Hapus file saat ini (tanpa ganti baru)
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none" name="notulensi" type="file" accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah/menghapus file.</p>
                                </div>

                                <div><label class="block mb-2 text-sm font-medium">Ruang</label><input type="text" name="ruang" value="{{ $item->ruang}}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5"></div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium">Link Materi</label>
                                        <input type="url" name="materi" value="{{ $item->materi }}" placeholder="https://..." class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5">
                                    </div>
                                    
                                    {{-- INPUT EDIT DOKUMENTASI (BARU) --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium">Link Dokumentasi</label>
                                        <input type="url" name="dokumentasi" value="{{ $item->dokumentasi }}" placeholder="https://..." class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5">
                                    </div>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Status Presensi</label>
                                    <select name="status_presensi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                        <option value="auto" {{ $item->status_presensi == 'auto' ? 'selected' : '' }}>Otomatis (Sesuai Jadwal)</option>
                                        <option value="buka" {{ $item->status_presensi == 'buka' ? 'selected' : '' }}>Buka Sekarang (Override)</option>
                                        <option value="tutup" {{ $item->status_presensi == 'tutup' ? 'selected' : '' }}>Tutup (Override)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="text-white bg-[#153D53] hover:bg-[#102e3f] font-medium rounded-lg text-sm px-5 py-2.5">Update Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. MODAL DELETE (TIDAK ADA PERUBAHAN) --}}
        <div id="delete-modal-{{ $item->rapat_id}}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-xl text-center p-6">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Yakin ingin menghapus rapat ini?</h3>
                    <form method="POST" action="{{ route('deleteRapat', $item->rapat_id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 mr-2">Ya, Hapus</button>
                        <button data-modal-hide="delete-modal-{{ $item->rapat_id}}" type="button" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Batal</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- 4. MODAL PESERTA (UPDATED) --}}
        <div id="peserta-modal-{{ $item->rapat_id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/30 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-7xl max-h-full">
                <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all">
                    <div class="flex items-start justify-between p-5 border-b border-gray-200 bg-gray-50">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Daftar Peserta: <span class="text-[#153D53]">{{ $item->nama_rapat }}</span></h3>
                            <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</span>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 hover:bg-gray-200 rounded-lg w-8 h-8 flex justify-center items-center" data-modal-hide="peserta-modal-{{ $item->rapat_id }}">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        </button>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        {{-- Header Info Peserta & Tombol Print --}}
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-blue-50 border border-blue-100 p-4 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <div class="p-3 mr-4 text-[#153D53] bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total Peserta</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $item->peserta->count() }} <span class="text-sm font-normal text-gray-500">Orang</span></p>
                                </div>
                            </div>
                            @if($item->peserta->count() > 0)
                            <div class="flex gap-2">
                                <a href="{{ route('admin.exportPeserta', $item->rapat_id) }}" target="_blank" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                                    Excel
                                </a>
                                <button onclick="printTable('table-peserta-{{ $item->rapat_id }}', '{{ $item->nama_rapat }}')" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 transition">Print</button>
                            </div>
                            @endif
                        </div>

                        {{-- TABEL PESERTA --}}
                        <div class="relative overflow-hidden border border-gray-200 rounded-lg shadow-sm">
                            @if($item->peserta->count() > 0)
                            <div class="overflow-x-auto max-h-[400px]">
                                <table id="table-peserta-{{ $item->rapat_id }}" class="w-full text-sm text-left text-gray-600">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                                        <tr>
                                            <th class="px-4 py-4 font-bold text-center w-10">NO</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">NAMA</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">NIP/NIK</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">PANGKAT/GOL</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">JENIS</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">JABATAN</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">UNIT KERJA</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">ASAL INSTANSI</th>
                                            <th class="px-4 py-4 font-bold whitespace-nowrap">NO. KONTAK</th>
                                            <th class="px-4 py-4 font-bold text-center no-print">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($item->peserta as $peserta)
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="px-4 py-4 text-center">{{ $loop->iteration }}</td>
                                            
                                            <td class="px-4 py-4 font-semibold text-gray-900 whitespace-nowrap">
                                                {{ $peserta->nama }}
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap text-gray-600">
                                                {{ $peserta->nip_nik ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                {{ $peserta->pangkat_golongan ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if($peserta->jenis_peserta == 'Internal')
                                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded border border-blue-200">Internal</span>
                                                @else
                                                    <span class="bg-orange-100 text-orange-800 text-xs px-2 py-0.5 rounded border border-orange-200">Eksternal</span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-0.5 rounded border border-gray-200">{{ $peserta->jabatan ?? '-' }}</span>
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                {{ $peserta->unit_kerja ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                {{ $peserta->asal_instansi ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap font-mono text-xs">
                                                {{ $peserta->nomor_kontak ?? '-' }}
                                            </td>
                                            
                                            <td class="px-4 py-4 text-center no-print">
                                                <form action="{{ route('deletePeserta', $peserta->peserta_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta {{ $peserta->nama }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1 rounded-md hover:bg-red-50 transition" title="Hapus Peserta">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-10 bg-white"><p class="text-gray-500">Belum ada peserta.</p></div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-5 border-t border-gray-200 bg-gray-50">
                        <button data-modal-hide="peserta-modal-{{ $item->rapat_id }}" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- JAVASCRIPT --}}
    <script>
        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const dateValue = document.getElementById('filterDate').value;
            const rows = document.querySelectorAll('.rapat-row');
            let visibleCount = 0;
            const isFiltering = (searchValue.length > 0 || dateValue.length > 0);

            rows.forEach((row) => {
                const nama = row.getAttribute('data-nama');
                const tanggal = row.getAttribute('data-tanggal');
                const matchesSearch = nama.includes(searchValue);
                const matchesDate = !dateValue || tanggal === dateValue;
                const noCell = row.querySelector('.row-number');

                if (matchesSearch && matchesDate) {
                    row.style.display = '';
                    visibleCount++;
                    if (isFiltering) { noCell.textContent = visibleCount; } 
                    else { noCell.textContent = noCell.getAttribute('data-original'); }
                } else {
                    row.style.display = 'none';
                }
            });
            const noResults = document.getElementById('noResults');
            const hasVisible = rows.length > 0 && visibleCount > 0;
            noResults.classList.toggle('hidden', hasVisible);

            document.getElementById('searchInput').removeEventListener('keyup', filterTable);
            document.getElementById('filterDate').removeEventListener('change', filterTable);
            
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const filterDate = document.getElementById('filterDate');
                let typingTimer;
                const doneTypingInterval = 500;
                const submitForm = () => { const form = searchInput.closest('form'); if (form) form.submit(); };
                searchInput.addEventListener('keyup', () => { clearTimeout(typingTimer); typingTimer = setTimeout(submitForm, doneTypingInterval); });
                filterDate.addEventListener('change', submitForm);
            });
        }
        filterTable(); 

        // Print & Excel Logic
        function printTable(tableId, title) {
            var table = document.getElementById(tableId).cloneNode(true);
            var ths = table.querySelectorAll('.no-print'); ths.forEach(el => el.remove());
            var tds = table.querySelectorAll('td.no-print'); tds.forEach(el => el.remove());
            var win = window.open('', '', 'height=700,width=900');
            win.document.write('<html><head><title>Daftar Peserta - ' + title + '</title>');
            win.document.write('<style>body { font-family: sans-serif; padding: 20px; } h2 { text-align: center; margin-bottom: 20px; } table { width: 100%; border-collapse: collapse; font-size: 12px; } th, td { border: 1px solid #000; padding: 8px; text-align: left; } th { background-color: #f2f2f2; } .no-print { display: none !important; }</style>');
            win.document.write('</head><body><h2>Daftar Peserta: ' + title + '</h2>' + table.outerHTML + '</body></html>');
            win.document.close(); win.print();
        }
        function exportToExcel(tableId, filename = 'download') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableId);
            var tableClone = tableSelect.cloneNode(true);
            var noPrints = tableClone.querySelectorAll('.no-print'); noPrints.forEach(el => el.remove());
            var tableHTML = tableClone.outerHTML.replace(/ /g, '%20');
            downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            if(navigator.msSaveOrOpenBlob){ var blob = new Blob(['\ufeff', tableClone.outerHTML], { type: dataType }); navigator.msSaveOrOpenBlob( blob, filename); }
            else { downloadLink.href = 'data:' + dataType + ', ' + tableHTML; downloadLink.download = filename + '.xls'; downloadLink.click(); }
        }
    </script>
</body>
</html>