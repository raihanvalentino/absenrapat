{{--<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Sistem Presensi Rapat/Kegiatan</title>
    <link rel="icon" type="image/png" href="/Logo1.png">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- Background color #153D53 (Sama dengan Login) -->
<body class="min-h-screen flex flex-col bg-[#153D53]">

    <!-- Container Tengah -->
    <div class="flex-grow flex items-center justify-center px-6">

        <div class="bg-white/10 backdrop-blur-xl p-8 rounded-lg shadow-[0_8px_30px_rgba(0,0,0,0.3)]
                    max-w-md w-full border border-white/20 relative">

            <!-- Tombol Close (Visual Hint untuk ESC) -->
            <a href="{{ route('welcome') }}" class="absolute top-4 right-4 text-white/50 hover:text-white transition" title="Tekan ESC untuk kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <img src="/Logo1.png" alt="Logo" class="mx-auto h-16 w-auto mb-4 drop-shadow-lg">
                <h2 class="text-2xl font-bold text-white">Daftar Akun Baru</h2>
                <p class="text-white/70 text-sm mt-1">Digital Attendance for a New Era of Transmigration</p>
            </div>

            <!-- Tampilkan Error Validasi -->
            @if ($errors->any())
                <div class="mb-6 bg-red-100/90 border border-red-400 text-red-700 px-4 py-3 rounded-lg backdrop-blur-sm">
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('processRegister') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Username -->
                <div>
                    <label class="block text-white text-sm font-medium mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" 
                        class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 
                               focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-inner border border-transparent focus:border-blue-300 transition" 
                        placeholder="Contoh: staff_umum" required autofocus>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-white text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 
                               focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-inner border border-transparent focus:border-blue-300 transition" 
                        placeholder="Minimal 6 karakter" required>
                </div>

                <!-- Tombol Register -->
                <button type="submit" 
                    class="w-full bg-white text-[#153D53] font-bold py-3 rounded-xl 
                           hover:bg-blue-50 transition duration-200 shadow-lg transform hover:scale-[1.02]">
                    Daftar Sekarang
                </button>

                <!-- Link Kembali ke Login -->
                <div class="mt-6 text-center text-sm text-white/80">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-white font-bold hover:text-blue-200 transition underline decoration-blue-300/50 hover:decoration-blue-200">
                        Login disini
                    </a>
                </div>
            </form>
        </div>

    </div>

    {{-- SCRIPT KHUSUS ESC BACK --}}
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                // Arahkan kembali ke halaman welcome (root)
                window.location.href = "{{ route('welcome') }}";
            }
        });
    </script>

</body>
</html> --}}