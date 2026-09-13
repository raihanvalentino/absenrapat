<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Presensi Rapat/Kegiatan</title>
    <link rel="icon" type="image/png" href="/Logo1.png">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- Background color #153D53 -->
<body class="min-h-screen flex flex-col bg-[#153D53]">

    <!-- Container Tengah -->
    <div class="flex-grow flex items-center justify-center px-6">

        <div class="bg-white/10 backdrop-blur-xl p-4 rounded-lg shadow-[0_8px_30px_rgba(0,0,0,0.3)]
                    max-w-md w-full border border-white/20 relative">

            <!-- Tombol Close (Visual Hint untuk ESC) -->
            <a href="{{ route('welcome') }}" class="absolute top-4 right-4 text-white/50 hover:text-white transition" title="Tekan ESC untuk kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            <!-- Logo -->
            <div class="text-center mb-6">
                <img src="/Logo1.png" alt="Logo" class="mx-auto w-20 mb-4 drop-shadow-lg">
                <h1 class="text-3xl font-bold text-white">Sistem Presensi Rapat/Kegiatan</h1>
                <p class="text-white/70 text-sm tracking-wide mt-1">Digital Attendance for a New Era of Transmigration</p>
            </div>

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="text-sm">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Username -->
                <div>
                    <label for="username" class="text-white text-sm font-medium">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        class="mt-1 w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 
                               focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-inner"
                        placeholder="Masukkan Username Anda" required autofocus>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="text-white text-sm font-medium">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 w-full px-4 py-3 rounded-md bg-white/20 text-white placeholder-white/60
                        focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-inner" placeholder="•••••••••" required>
                </div>

                <!-- Tombol -->
                <button class="w-full bg-white text-[#153D53] font-semibold py-3 rounded-md 
                hover:bg-blue-100 transition duration-200 shadow-md">
                    Login
                </button>

            </form>
        </div>

    </div>

    {{-- SCRIPT KHUSUS ESC BACK --}}
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                window.location.href = "{{ route('welcome') }}";
            }
        });
    </script>

</body>
</html>