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
                <h2 class="text-xl font-semibold text-gray-700">Data Peserta</h2>
            </div>

            {{-- SEARCH + FILTER --}}
            <div class="flex gap-3 mb-4">
                <input type="text" id="searchInput" placeholder="Cari nama peserta atau rapat..."
                    class="w-1/3 px-3 py-2 border rounded-lg shadow-sm focus:ring-blue-300">

                <div class="flex gap-2">
                    <input type="date" id="filterDate"
                        class="px-3 py-2 border rounded-lg shadow-sm focus:ring-blue-300">
                    
                    <button id="clearDateBtn" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Hapus Filter
                    </button>
                </div>
            </div>
            
            {{-- TABLE --}}
            <div class="overflow-x-auto bg-white p-4 rounded-xl shadow border border-gray-400">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-200">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Rapat</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Ruang</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody id="rapatTableBody">
                        @forelse($dataPeserta as $p)
                        <tr class="border-b hover:bg-gray-50 peserta-row" 
                            data-nama-peserta="{{ strtolower($p->nama) }}" 
                            data-nama-rapat="{{ strtolower($p->rapat->nama_rapat ?? '-') }}">
                            
                            <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                            
                            {{-- Mengambil Nama Rapat dari relasi --}}
                            <td class="px-4 py-3 font-medium">
                                {{ $p->rapat->nama_rapat ?? 'Rapat Terhapus' }}
                            </td>
                            
                            <td class="px-4 py-3 font-bold text-gray-900">{{ $p->nama }}</td>
                            
                            {{-- Logika untuk Unit Kerja / Instansi --}}
                            <td class="px-4 py-3">
                                @if($p->jenis_peserta == 'Internal')
                                    {{ $p->unit_kerja ?? '-' }}
                                @else
                                    {{ $p->asal_instansi ?? '-' }}
                                @endif
                            </td>
                            
                            <td class="px-4 py-3">
                                {{ $p->jabatan ?? '-' }}
                            </td>
                            
                            <td class="px-4 py-3">
                                @if($p->jenis_peserta == 'Internal')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">Internal</span>
                                @else
                                    <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded border border-orange-400">Eksternal</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data peserta yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pesan jika tidak ada hasil pencarian -->
                <div id="noResults" class="hidden text-center py-8 text-gray-500">
                    Tidak ada data peserta yang sesuai dengan pencarian.
                </div>
            </div>

        </div>
    </div>

    <script>
        // Fungsi untuk filter tabel
        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const dateValue = document.getElementById('filterDate').value;
            const rows = document.querySelectorAll('.peserta-row');
            let visibleCount = 0;

            rows.forEach((row) => {
                const namaPeserta = row.getAttribute('data-nama-peserta');
                const namaRapat = row.getAttribute('data-nama-rapat');
                
                // Cek apakah search cocok dengan nama peserta atau nama rapat
                const matchesSearch = namaPeserta.includes(searchValue) || namaRapat.includes(searchValue);
                
                if (matchesSearch) {
                    row.style.display = '';
                    // Update nomor urut
                    row.querySelector('td:first-child').textContent = ++visibleCount;
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada hasil
            const noResults = document.getElementById('noResults');
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Event listener untuk search input
        document.getElementById('searchInput').addEventListener('keyup', filterTable);

        // Event listener untuk filter tanggal (jika dibutuhkan nanti)
        document.getElementById('filterDate').addEventListener('change', function() {
            // Tambahkan logika filter tanggal jika diperlukan
            console.log('Filter tanggal:', this.value);
        });

        // Event listener untuk tombol hapus filter tanggal
        document.getElementById('clearDateBtn').addEventListener('click', function() {
            document.getElementById('filterDate').value = '';
            // Trigger filter jika diperlukan
        });
    </script>
</body>
</html>