<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PesertaRapat;
use Illuminate\Support\Facades\Storage;

class MultiStepForm extends Component
{
    // protected $listeners = ['signatureSaved'];
    // public $step = 1;

    public $rapat_id;
    public $jenis_peserta;
    public $tipe_peserta;
    public $nama;
    public $pangkat_golongan;
    public $jabatan;
    public $unit_kerja;
    public $unit_kerja_eselon2;
    public $asal_instansi;
    public $nomor_kontak;
    public $nip_nik;
    // public $bukti_kehadiran;

    // Data Eselon 2 berdasarkan Eselon 1
    public $eselon2Options = [];

    public function mount($rapat_id)
    {
        $this->rapat_id = $rapat_id;
    }

    // Update Eselon 2 options ketika Eselon 1 berubah
    public function updatedUnitKerja($value)
    {
        $this->unit_kerja_eselon2 = '';
        $this->eselon2Options = $this->getEselon2Options($value);
    }

    // Fungsi untuk mendapatkan pilihan Eselon 2
    private function getEselon2Options($eselon1)
    {
        $options = [
            'Sekretariat Jenderal' => [
                'Biro Perencanaan, Kerja Sama, Dan Hubungan Masyarakat',
                'Biro Organisasi, Sumber Daya Manusia, Dan Reformasi Birokrasi',
                'Biro Umum Dan Layanan Pengadaan',
                'Biro Keuangan dan Barang Milik Negara',
                'Biro Hukum',
                'Pusat Strategi Kebijakan Transmigrasi',
                'Pusat Pengembangan Sumber Daya Manusia',
                'Pusat Data dan Informasi Transmigrasi',
                'Balai Besar Pelatihan dan Pemberdayaan Masyarakat Transmigrasi Yogyakarta',
                'Balai Pelatihan dan Pemberdayaan Masyarakat Transmigrasi Pekanbaru',
                'Balai Pelatihan dan Pemberdayaan Masyarakat Transmigrasi Banjarmasin',
                'Balai Pelatihan dan Pemberdayaan Masyarakat Transmigrasi Denpasar',
            ],
            'Inspektorat Jenderal' => [
                'Sekretariat Inspektorat Jenderal',
                'Inspektorat I',
                'Inspektorat II',
            ],
            'Direktorat Jenderal Pembangunan dan Pengembangan Kawasan Transmigrasi' => [
                'Sekretariat Direktorat Jenderal Pembangunan Dan Pengembangan Kawasan Transmigrasi',
                'Direktorat Perencanaan Perwujudan Kawasan Transmigrasi',
                'Direktorat Fasilitasi Penataan Persebaran Penduduk Di Kawasan Transmigrasi',
                'Direktorat Pengembangan Kawasan Transmigrasi',
                'Direktorat Pembangunan Kawasan Transmigrasi',
                'Direktorat Pengembangan Satuan Permukiman Dan Pusat Satuan Kawasan Pengembangan',
            ],
            'Direktorat Jenderal Pengembangan Ekonomi dan Pemberdayaan Masyarakat Transmigrasi' => [
                'Sekretariat Direktorat Jenderal Pengembangan Ekonomi Dan Pemberdayaan Masyarakat Transmigrasi',
                'Direktorat Perencanaan Teknis Pengembangan Ekonomi Dan Pemberdayaan Masyarakat Transmigrasi',
                'Direktorat Pengembangan Produk Unggulan Transmigrasi',
                'Direktorat Pemberdayaan Masyarakat Transmigrasi',
                'Direktorat Pengembangan Kelembagaan Ekonomi Transmigrasi',
                'Direktorat Promosi Dan Pemasaran Produk Unggulan Transmigrasi',
            ],
        ];

        return $options[$eselon1] ?? [];
    }

    // public function signatureSaved($signatureData)
    // {
    //     $this->bukti_kehadiran = $signatureData;
    // }

    public function submit()
    {
        // Validasi final sebelum submit
        if ($this->jenis_peserta === 'Internal') {
            $this->validate([
                'jenis_peserta'       => 'required',
                'tipe_peserta'        => 'nullable',
                'nama'                => 'required|min:3',
                'pangkat_golongan'    => 'required|string',
                'nip_nik'             => 'required|numeric',
                'unit_kerja'          => 'required',
                'unit_kerja_eselon2'  => 'required',
                'jabatan'             => 'nullable',
                'nomor_kontak'        => 'required|numeric',
                // 'bukti_kehadiran'     => 'nullable',
            ], [
                'nama.required'                => 'Nama harus diisi!',
                'nama.min'                     => 'Nama minimal 3 karakter!',
                'pangkat_golongan.required'    => 'Pangkat/Golongan harus diisi!',
                'nip_nik.required'             => 'NIP/NIK harus diisi!',
                'nip_nik.numeric'              => 'NIP/NIK harus berupa angka!',
                'unit_kerja.required'          => 'Unit Kerja Eselon 1 harus dipilih!',
                'unit_kerja_eselon2.required'  => 'Unit Kerja Eselon 2 harus dipilih!',
                'nomor_kontak.required'        => 'Nomor kontak harus diisi!',
                'nomor_kontak.numeric'         => 'Nomor kontak harus berupa angka!',
                // 'bukti_kehadiran'     => 'Tanda tangan harus diisi!',
            ]);
        } else {
            $this->validate([
                'jenis_peserta'     => 'required',
                'tipe_peserta'      => 'nullable',
                'nama'              => 'required|min:3',
                'pangkat_golongan'    => 'required|string',
                'nip_nik'           => 'required|numeric',
                'asal_instansi'     => 'required',
                'nomor_kontak'      => 'required|numeric',
                // 'bukti_kehadiran'   => 'nullable',
            ], [
                'nama.required'          => 'Nama harus diisi!',
                'nama.min'               => 'Nama minimal 3 karakter!',
                'pangkat_golongan.required'    => 'Pangkat/Golongan harus diisi!',
                'nip_nik.required'       => 'NIP/NIK harus diisi!',
                'nip_nik.numeric'        => 'NIP/NIK harus berupa angka!',
                'asal_instansi.required' => 'Asal instansi harus diisi!',
                'nomor_kontak.required'  => 'Nomor kontak harus diisi!',
                'nomor_kontak.numeric'   => 'Nomor kontak harus berupa angka!',
                // 'bukti_kehadiran' => 'Tanda tangan harus diisi!',
            ]);
        }

        // // Proses base64 image
        // $image = str_replace('data:image/png;base64,', '', $this->bukti_kehadiran);
        // $image = str_replace(' ', '+', $image);

        // $fileName = 'ttd_' . time() . '_' . uniqid() . '.png';

        // // Simpan file
        // Storage::disk('public')->put(
        //     'uploads/bukti/' . $fileName,
        //     base64_decode($image)
        // );

        // Simpan data ke database
        PesertaRapat::create([
            'rapat_id'          => $this->rapat_id,
            'jenis_peserta'     => $this->jenis_peserta,
            'tipe_peserta'      => $this->tipe_peserta ?? '-',
            'nama'              => $this->nama,
            'pangkat_golongan'  => $this->pangkat_golongan,
            'jabatan'           => $this->jabatan ?? '-',
            'unit_kerja'        => $this->jenis_peserta === 'Internal' 
                                    ? $this->unit_kerja . ' - ' . $this->unit_kerja_eselon2
                                    : '-',
            'asal_instansi'     => $this->jenis_peserta === 'Internal' 
                                    ? 'Kementerian Transmigrasi' 
                                    : $this->asal_instansi,
            'nomor_kontak'      => $this->nomor_kontak,
            'nip_nik'           => $this->nip_nik,
            // 'bukti_kehadiran'   => $fileName,
        ]);

        // Reset form
        $this->reset();

        // Redirect dengan pesan sukses
        return redirect()->route('welcome', ['survey' => 'open']);
    }

    public function render()
    {
        return view('livewire.multi-step-form');
    }
}