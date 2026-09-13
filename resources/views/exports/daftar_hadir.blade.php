<table>
    {{-- BARIS 1: JUDUL UTAMA --}}
    <tr>
        <td colspan="8" style="font-weight: bold; font-size: 14px; text-align: center; height: 30px; vertical-align: middle;">
            DAFTAR HADIR
        </td>
    </tr>
    
    {{-- BARIS 2: KOSONG --}}
    <tr></tr>

    {{-- BARIS 3-6: DETAIL RAPAT --}}
    <tr>
        <td colspan="2" style="font-weight: bold;">Agenda</td>
        <td colspan="6" style="text-align: left;">: {{ $rapat->nama_rapat }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Hari/Tanggal</td>
        <td colspan="6" style="text-align: left;">: {{ \Carbon\Carbon::parse($rapat->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Tempat</td>
        <td colspan="6" style="text-align: left;">: {{ $rapat->ruang }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Waktu</td>
        <td colspan="6" style="text-align: left;">: {{ $rapat->waktu_mulai }} - {{ $rapat->waktu_selesai }} WIB</td>
    </tr>

    {{-- BARIS 7: KOSONG --}}
    <tr></tr>

    {{-- BARIS 8: HEADER KOLOM --}}
    <tr>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">NO</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">NAMA</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">NIP/NIK</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">PANGKAT/GOL</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">JENIS</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">JABATAN</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">UNIT KERJA / INSTANSI</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle;">NO. KONTAK</th>
    </tr>

    {{-- BARIS DATA PESERTA --}}
    @foreach($peserta as $p)
    <tr>
        <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">{{ $loop->iteration }}</td>
        
        <td style="border: 1px solid #000000; vertical-align: top;">{{ $p->nama }}</td>
        
        {{-- TRIK FIX: Tambahkan spasi (. ' ') agar dibaca sebagai TEKS --}}
        <td style="border: 1px solid #000000; text-align: left; vertical-align: top;">
            ="{{ $p->nip_nik ?? '-' }}"
        </td>
        
        <td style="border: 1px solid #000000; vertical-align: top;">{{ $p->pangkat_golongan ?? '-' }}</td>

        <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">{{ $p->jenis_peserta }}</td>
        
        <td style="border: 1px solid #000000; vertical-align: top;">{{ $p->jabatan ?? '-' }}</td>
        
        <td style="border: 1px solid #000000; vertical-align: top;">
            @if($p->jenis_peserta == 'Internal')
                {{ $p->unit_kerja }}
            @else
                {{ $p->asal_instansi }}
            @endif
        </td>

        {{-- TRIK FIX: Tambahkan spasi (. ' ') agar dibaca sebagai TEKS --}}
        <td style="border: 1px solid #000000; vertical-align: top; mso-number-format:'\@';">
            {{ $p->nomor_kontak ?? '-' }}
        </td>
    </tr>
    @endforeach
</table>