<div class="p-6 bg-white rounded shadow" 
     x-data 
     @keydown.escape.window="window.history.back()">

{{-- TOMBOL KEMBALI --}}
    <div class="mb-4">
        <button type="button" 
                onclick="window.history.back()" 
                class="flex items-center text-gray-500 hover:text-blue-700 transition text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali (Tekan ESC)
        </button>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session()->has('success'))
        <div class="p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500 rounded shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <p class="font-bold">Berhasil!</p>
            </div>
            <p class="mt-1 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- FORM PRESENSI --}}
    <form wire:submit.prevent="submit">
        
        {{-- BAGIAN 1: PILIHAN UTAMA --}}
        <div class="mb-6 border-b pb-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Data Awal</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div class="mb-3">
                    <label class="font-medium text-gray-700 block mb-1">Jenis Peserta <span class="text-red-500">*</span></label>
                    {{-- Tambahkan px-4 py-2 disini --}}
                    <select wire:model.live="jenis_peserta" 
                            class="w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('jenis_peserta') border-red-500 @enderror">
                        <option value="">-- Pilih Jenis Peserta --</option>
                        <option value="Internal">Internal</option>
                        <option value="Eksternal">Eksternal</option>
                    </select>
                    @error('jenis_peserta') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                </div>

{{-- 
                <div class="mb-3">
                    <label class="font-medium text-gray-700 block mb-1">Tipe Peserta <span class="text-red-500">*</span></label>
                    <select wire:model="tipe_peserta" 
                            class="w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('tipe_peserta') border-red-500 @enderror">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Pimpinan">Pimpinan</option>
                        <option value="Staf">Staf / Anggota</option>
                    </select>
                    @error('tipe_peserta') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                </div> 
                --}}
                
            </div>
        </div>

        {{-- BAGIAN 2: FORM DINAMIS --}}
        @if (!empty($jenis_peserta))
            
            <div class="mb-6 animate-fade-in-down"> 
                <h2 class="text-xl font-bold mb-4 text-gray-800">Identitas Diri</h2>

                {{-- DATA UMUM --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="mb-3">
                        <label class="font-medium text-gray-700 block mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        {{-- Tambahkan px-4 py-2 disini --}}
                        <input wire:model="nama" type="text" 
                               class="w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('nama') border-red-500 @enderror" 
                               placeholder="Nama Lengkap beserta gelar">
                        @error('nama') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                    </div>

                {{-- TAMBAHAN: PANGKAT/GOLONGAN --}}
                <div class="mb-3">
                    <label class="font-medium text-gray-700 block mb-1">Pangkat / Golongan<span class="text-red-500">*</span></label>
                    <input wire:model="pangkat_golongan" type="text" 
                        class="w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('pangkat_golongan') border-red-500 @enderror" 
                        placeholder="Contoh: Penata Muda (III/a)">
                    @error('pangkat_golongan') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                </div>
                
                    <div class="mb-3">
                        <label class="font-medium text-gray-700 block mb-1">NIP / NIK <span class="text-red-500">*</span></label>
                        {{-- Tambahkan px-4 py-2 disini --}}
                        <input wire:model="nip_nik" type="number" 
                               class="w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('nip_nik') border-red-500 @enderror" 
                               placeholder="Nomor Induk Pegawai / KTP">
                        @error('nip_nik') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- FORM KHUSUS INTERNAL --}}
                @if ($jenis_peserta === 'Internal')
                    <div class="bg-blue-50 p-5 rounded-lg border border-blue-100 mb-6">
                        <h3 class="font-bold text-blue-800 mb-4 text-sm uppercase tracking-wide flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
                            Detail Unit Kerja
                        </h3>
                        
                        <div class="mb-3">
                            <label class="font-medium text-blue-900 block mb-1">Unit Kerja Eselon 1 <span class="text-red-500">*</span></label>
                            {{-- Tambahkan px-4 py-2 disini --}}
                            <select wire:model.live="unit_kerja" 
                                    class="w-full px-4 py-2 border-blue-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition bg-white @error('unit_kerja') border-red-500 @enderror">
                                <option value="">Pilih Unit Kerja Eselon 1...</option>
                                <option value="Sekretariat Jenderal">Sekretariat Jenderal</option>
                                <option value="Inspektorat Jenderal">Inspektorat Jenderal</option>
                                <option value="Direktorat Jenderal Pembangunan dan Pengembangan Kawasan Transmigrasi">Direktorat Jenderal Pembangunan dan Pengembangan Kawasan Transmigrasi</option>
                                <option value="Direktorat Jenderal Pengembangan Ekonomi dan Pemberdayaan Masyarakat Transmigrasi">Direktorat Jenderal Pengembangan Ekonomi dan Pemberdayaan Masyarakat Transmigrasi</option>
                            </select>
                            @error('unit_kerja') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="font-medium text-blue-900 block mb-1">Unit Kerja Eselon 2 <span class="text-red-500">*</span></label>
                            {{-- Tambahkan px-4 py-2 disini --}}
                            <select wire:model="unit_kerja_eselon2" 
                                    @if(!$unit_kerja) disabled @endif
                                    class="w-full px-4 py-2 border-blue-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition bg-white @error('unit_kerja_eselon2') border-red-500 @enderror disabled:bg-gray-100 disabled:text-gray-400">
                                <option value="">
                                    @if(!$unit_kerja) (Pilih Eselon 1 Terlebih Dahulu) @else Pilih Unit Kerja Eselon 2... @endif
                                </option>
                                @if($unit_kerja && count($eselon2Options) > 0)
                                    @foreach ($eselon2Options as $option)
                                        @if($option !== $unit_kerja)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('unit_kerja_eselon2') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label class="font-medium text-blue-900 block mb-1">Jabatan</label>
                                {{-- Tambahkan px-4 py-2 disini --}}
                                <input wire:model="jabatan" type="text" class="w-full px-4 py-2 border-blue-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('jabatan') border-red-500 @enderror" placeholder="Contoh: Kepala Subbagian">
                                @error('jabatan') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="font-medium text-blue-900 block mb-1">No. Kontak (WA) <span class="text-red-500">*</span></label>
                                {{-- Tambahkan px-4 py-2 disini --}}
                                <input wire:model="nomor_kontak" type="text" class="w-full px-4 py-2 border-blue-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('nomor_kontak') border-red-500 @enderror" placeholder="08xxxxxxxxxx">
                                @error('nomor_kontak') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                @endif

                {{-- FORM KHUSUS EKSTERNAL --}}
                @if ($jenis_peserta === 'Eksternal')
                    <div class="bg-orange-50 p-5 rounded-lg border border-orange-100 mb-6">
                        <h3 class="font-bold text-orange-800 mb-4 text-sm uppercase tracking-wide flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0 1 1 0 002 0zM16 9a3 3 0 100-6 3 3 0 000 6zM12.8 9.9a6.002 6.002 0 011.6 4.1H12v-1c0-1.162.29-2.246.799-3.201z"/></svg>
                            Detail Tamu
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            {{-- INPUT ASAL INSTANSI --}}
                            <div class="mb-3">
                                <label class="font-medium text-orange-900 block mb-1">Asal Instansi <span class="text-red-500">*</span></label>
                                <input wire:model="asal_instansi" type="text" 
                                    class="w-full px-4 py-2 border-orange-200 rounded-lg shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 transition bg-white @error('asal_instansi') border-red-500 @enderror"
                                    placeholder="Contoh: Dinas Tenaga Kerja Kab. X">
                                @error('asal_instansi') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                            </div>

                            {{-- INPUT JABATAN (BARU DITAMBAHKAN) --}}
                            <div class="mb-3">
                                <label class="font-medium text-orange-900 block mb-1">Jabatan <span class="text-red-500">*</span></label>
                                <input wire:model="jabatan" type="text" 
                                    class="w-full px-4 py-2 border-orange-200 rounded-lg shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 transition bg-white @error('jabatan') border-red-500 @enderror"
                                    placeholder="Contoh: Direktur / Staf">
                                @error('jabatan') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                            </div>

                            {{-- INPUT NO KONTAK --}}
                            <div class="mb-3">
                                <label class="font-medium text-orange-900 block mb-1">No. Kontak (WA) <span class="text-red-500">*</span></label>
                                <input wire:model="nomor_kontak" type="text" 
                                    class="w-full px-4 py-2 border-orange-200 rounded-lg shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 transition @error('nomor_kontak') border-red-500 @enderror" 
                                    placeholder="08xxxxxxxxxx">
                                @error('nomor_kontak') <small class="text-red-600 block mt-1 text-sm">{{ $message }}</small> @enderror
                            </div>
                            
                        </div>
                    </div>
                @endif
                
                {{-- TOMBOL SUBMIT --}}
                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="w-full md:w-auto px-8 py-3 bg-[#153D53] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center">
                        
                        <span wire:loading.remove>
                            Kirim Data Absensi
                        </span>
                        
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sedang Mengirim...
                        </span>
                    </button>
                </div>

            </div>
        @endif
        
    </form>

</div>