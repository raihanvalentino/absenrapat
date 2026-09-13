<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="icon" type="image/png" href="/Logo1.png">
    @include('layouts.header')
    @vite('resources/css/app.css') 
</head>
<body class="bg-gray-100 min-h-screen">
    @include('layouts.sidebar')

    <div class="p-6 sm:ml-64 mt-20">

        {{-- ======= 1. KARTU STATISTIK ======= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

            <div class="p-5 bg-white rounded-xl shadow border border-gray-100">
                <p class="text-sm text-gray-500">Total Rapat Bulan Ini</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalRapat }}</h3>
            </div>

            <div class="p-5 bg-white rounded-xl shadow border border-gray-100">
                <p class="text-sm text-gray-500">Total Peserta Hari Ini</p> 
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPeserta }}</h3>
            </div>

            <div class="p-5 bg-white rounded-xl shadow border border-gray-100">
                <p class="text-sm text-gray-500">Total Peserta Internal</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $totalInternal }}</h3>
            </div>

            <div class="p-5 bg-white rounded-xl shadow border border-gray-100">
                <p class="text-sm text-gray-500">Total Peserta Eksternal</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $totalEksternal }}</h3>
            </div>

        </div>


        {{-- ======= 2. TABEL RAPAT TERDEKAT ======= --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mb-8">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700">Rapat Terdekat</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-500 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3 font-medium">Tanggal & Waktu</th>
                            <th class="px-6 py-3 font-medium">Nama Rapat</th>
                            <th class="px-6 py-3 font-medium">Ruang</th> 
                            <th class="px-6 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($rapatTerdekat as $r)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d F Y') }}
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($r->waktu_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($r->waktu_selesai)->format('H:i') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $r->nama_rapat }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $r->ruang }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $r->badge_color }}">
                                    {{ $r->status_text }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p>Tidak ada rapat terdekat</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        {{-- ======= 3. TABEL PRESENSI TERBARU (YANG DIPERBAIKI) ======= --}}
        <div class="mt-10 mb-10">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Presensi Terbaru</h3>

            <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-100">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-medium">Nama Peserta</th>
                            <th class="px-6 py-3 font-medium">Nama Rapat</th>
                            <th class="px-6 py-3 font-medium">Jam Masuk</th>
                            <th class="px-6 py-3 font-medium">Jenis Peserta</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-100">
                        @forelse($presensiTerbaru as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $p->nama }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ optional($p->rapat)->nama_rapat ?? 'Data Rapat Terhapus' }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $p->created_at->format('H:i') }} WIB
                            </td>

                            <td class="px-6 py-4">
                                @if(strtolower($p->jenis_peserta) == 'internal')
                                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                                        Internal
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                        Eksternal
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p>Belum ada presensi terbaru</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</body>
</html>