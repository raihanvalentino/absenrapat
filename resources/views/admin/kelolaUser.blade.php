<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User Admin</title>
    <link rel="icon" type="image/png" href="/Logo1.png">
    @include('layouts.header')
    @vite('resources/css/app.css') 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    @include('layouts.sidebar')
    
    <div class="p-6 sm:ml-64 mt-20">
          
        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen User (Admin)</h2>
            <button data-modal-target="tambah-user-modal" data-modal-toggle="tambah-user-modal"
                class="px-5 py-2.5 bg-[#153D53] text-white rounded-lg shadow-md hover:bg-[#102e3f] transition transform hover:scale-105">
                + Tambah Admin
            </button>
        </div>

        {{-- SEARCH --}}
        <form method="GET" action="{{ route('admin.kelolaUser') }}" class="mb-6 bg-white p-4 rounded-lg shadow-sm">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username..."
                    class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#153D53]">
            </div>
        </form>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- TABEL USER --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-600 uppercase bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-center w-10">No</th>
                        <th class="px-6 py-3">Username</th>
                        <th class="px-6 py-3">Role (Hak Akses)</th>
                        {{-- Kolom Dibuat Pada dihapus --}}
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $u)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center font-medium">{{ $users->firstItem() + $loop->index }}</td>
                        
                        <td class="px-6 py-4 font-bold text-gray-900">
                            {{ $u->username }}
                            @if($u->id == auth()->id())
                                <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full border border-green-200">Saya</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($u->role == 'admin')
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded border border-purple-400">Super Admin</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">Admin Biasa</span>
                            @endif
                        </td>

                        {{-- Data Created At dihapus --}}

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Edit Button --}}
                                <button data-modal-target="edit-user-{{ $u->id }}" data-modal-toggle="edit-user-{{ $u->id }}" 
                                    class="p-2 text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                                </button>

                                {{-- Delete Button (Tidak bisa delete diri sendiri) --}}
                                @if($u->id != auth()->id())
                                <button data-modal-target="delete-user-{{ $u->id }}" data-modal-toggle="delete-user-{{ $u->id }}" 
                                    class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"></path></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>

    {{-- MODAL TAMBAH USER --}}
    <div id="tambah-user-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Admin Baru</h3>
                    <button type="button" data-modal-hide="tambah-user-modal" class="text-gray-400 hover:text-gray-900"><svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.storeUser') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                                <input type="text" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                                <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required minlength="6">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                                <select name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                    <option value="adminbiasa">Admin Biasa (Hanya lihat rapat sendiri)</option>
                                    <option value="admin">Super Admin (Lihat semua)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="text-white bg-[#153D53] hover:bg-[#102e3f] font-medium rounded-lg text-sm px-5 py-2.5">Simpan User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- LOOPING MODAL EDIT & DELETE --}}
    @foreach($users as $u)
    
        {{-- Modal Edit --}}
        <div id="edit-user-{{ $u->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-xl">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-xl font-semibold text-gray-900">Edit User: {{ $u->username }}</h3>
                        <button type="button" data-modal-hide="edit-user-{{ $u->id }}" class="text-gray-400 hover:text-gray-900"><svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.updateUser', $u->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                                    <input type="text" name="username" value="{{ $u->username }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Password Baru (Opsional)</label>
                                    <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" placeholder="Kosongkan jika tidak diganti">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                                    <select name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                        <option value="adminbiasa" {{ $u->role == 'adminbiasa' ? 'selected' : '' }}>Admin Biasa</option>
                                        <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-sm px-5 py-2.5">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Delete --}}
        @if($u->id != auth()->id())
        <div id="delete-user-{{ $u->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-xl text-center p-6">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Yakin ingin menghapus user <b>{{ $u->username }}</b>?</h3>
                    <p class="text-sm text-red-500 mb-4">Semua rapat yang dibuat oleh user ini juga akan terhapus!</p>
                    <form method="POST" action="{{ route('admin.deleteUser', $u->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 mr-2">Ya, Hapus</button>
                        <button data-modal-hide="delete-user-{{ $u->id }}" type="button" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Batal</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

    @endforeach

</body>
</html>