<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Rapat/Kegiatan</title>
    <link rel="icon" type="image/png" href="/Logo1.png">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .bg-pattern {
            background-color: #153D53;
            background-image: radial-gradient(circle at 50% 0%, #1e526e 0%, #153D53 60%);
        }
        
        /* Custom Scrollbar - PERBAIKAN DI SINI */
        .custom-scroll::-webkit-scrollbar {
            width: 6px; /* Sedikit diperlebar agar lebih mudah di-klik */
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent; /* Ubah jadi transparan agar menyatu dengan background */
            margin-bottom: 20px; /* Memberi jarak sedikit dari bawah agar tidak mentok */
            margin-top: 10px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px; /* Full rounded */
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @livewireStyles
</head>

<body class="bg-pattern h-screen w-full flex items-center justify-center py-4 px-4 relative overflow-hidden">

    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-teal-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>

    <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl border border-white/20 backdrop-blur-sm flex flex-col h-[90vh] md:h-auto md:max-h-[90vh] overflow-hidden">
        
        <div class="bg-white border-b border-gray-100 p-6 md:px-10 flex flex-col md:flex-row items-center justify-between gap-6 relative shrink-0 z-10">
       
            {{-- BAGIAN KIRI: Tombol & Logo --}}
            {{-- Tambahkan 'shrink-0' di container ini agar isinya tidak menyusut --}}
            <div class="flex items-center gap-5 w-full md:w-auto shrink-0">
                <a href="{{ route('welcome') }}" class="group flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-gray-50 text-[#153D53] rounded-full hover:bg-[#153D53] hover:text-white transition-all duration-300 shadow-sm border border-gray-200 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>

                <div class="h-10 w-[1px] bg-gray-200 hidden md:block"></div>

                <div class="flex items-center gap-3 shrink-0">
                    {{-- Tinggi gambar (h) saya naikkan sedikit ke h-14/h-16 agar lebih proporsional & aesthetic --}}
                    <img src="{{ asset('/Logo.jpg') }}" 
                         alt="Logo Kementrans" 
                         class="h-14 md:h-16 w-auto object-contain drop-shadow-sm">
                </div>
            </div>

            {{-- BAGIAN KANAN: Teks Judul --}}
            {{-- Ubah 'md:w-auto' menjadi 'md:flex-1 min-w-0' agar judul mengambil sisa ruang dengan pas --}}
            <div class="text-center md:text-right w-full md:flex-1 min-w-0">
                <div class="inline-flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-full mb-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-[#153D53] tracking-wider uppercase">Presensi Online</span>
                </div>
                
                {{-- Tambahkan 'break-words' agar jika teksnya kelewat panjang, otomatis turun ke baris baru tanpa merusak layout --}}
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight leading-tight break-words">
                    {{ $rapat->nama_rapat ?? 'Nama Kegiatan Belum Ada' }}
                </h1>
                <p class="text-gray-500 text-sm mt-1">Silakan lengkapi data di bawah ini</p>
            </div>
        </div>

        <div class="p-6 md:p-10 bg-gray-50/50 flex-1 overflow-y-auto custom-scroll min-h-0">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                @livewire(\App\Http\Livewire\MultiStepForm::class, ['rapat_id' => $rapat->rapat_id])
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>