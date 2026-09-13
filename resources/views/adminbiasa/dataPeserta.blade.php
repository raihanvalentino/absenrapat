<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta</title>
    <link rel="icon" type="image/png" href="/Logo1.png">
    @include('layouts.header')
    @vite('resources/css/app.css') 
</head>
<body class="bg-gray-100 min-h-screen">
    @include('layouts.sidebar')
    <div class="p-6 sm:ml-64 mt-20">
         <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-700">Data Peserta (Rapat Anda)</h2>
            </div>

            {{-- SEARCH + FILTER --}}
            <form action="{{ route('dataPeserta') }}" method="GET" class="flex gap-3 mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..."
                    class="w-1/3 px-3 py-2 border rounded-lg shadow-sm focus:ring-blue-300">
                <button type="submit" class="px-4 py-2 bg-[#153D53] text-white rounded-lg hover:bg-[#102e3f] transition">
                    Cari
                </button>
            </form>
            
            {{-- TABLE --}}
            <div class="overflow-x-auto bg-white p-4 rounded-xl shadow border border-gray-400">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-200">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Peserta</th>
                            <th class="px-4 py-3">Nama Rapat</th>
                            <th class="px-4 py-3">NIP/NIK</th>
                            <th class="px-4 py-3">Jabatan</th>
                            <th class="px-4 py-3">Instansi</th>
                            <th class="px-4 py-3">Jenis</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($dataPeserta as $peserta)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                            
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $peserta->nama }}
                                <div class="text-xs text-gray-500">{{ $peserta->nomor_kontak }}</div>
                            </td>

                            <td class="px-4 py-3 text-blue-600">
                                {{ $peserta->rapat->nama_rapat ?? 'Rapat Terhapus' }}
                                <div class="text-xs text-gray-500">
                                    {{ optional($peserta->rapat)->tanggal ? \Carbon\Carbon::parse($peserta->rapat->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </td>

                            <td class="px-4 py-3">{{ $peserta->nip_nik ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $peserta->jabatan ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $peserta->asal_instansi ?? '-' }}</td>
                            
                            <td class="px-4 py-3">
                                @if($peserta->jenis_peserta == 'Internal')
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded border border-blue-200">Internal</span>
                                @else
                                    <span class="bg-orange-100 text-orange-800 text-xs px-2 py-0.5 rounded border border-orange-200">Eksternal</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data peserta di rapat-rapat Anda.
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