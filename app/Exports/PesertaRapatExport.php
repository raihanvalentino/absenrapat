<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PesertaRapatExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $rapat;
    protected $peserta;

    public function __construct($rapat, $peserta)
    {
        $this->rapat = $rapat;
        $this->peserta = $peserta;
    }

    public function view(): View
    {
        // Pastikan nama file view sesuai dengan yang Anda buat (daftar_hadir)
        return view('exports.daftar_hadir', [
            'rapat' => $this->rapat,
            'peserta' => $this->peserta
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ===============================================
                // 1. SETUP HALAMAN (KUNCI AGAR 1 PAGE)
                // ===============================================
                
                // Set Ukuran Kertas A4 & Landscape
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                // FIT TO WIDTH: Paksa semua kolom masuk ke lebar 1 halaman
                $sheet->getPageSetup()->setFitToWidth(1);
                
                // FIT TO HEIGHT: 0 artinya "tidak terbatas ke bawah" (jika peserta 100, akan jadi 2 halaman tapi tetap rapi)
                // Jika ingin dipaksa 1 lembar mutlak (walau tulisan jadi kecil), ganti 0 jadi 1.
                $sheet->getPageSetup()->setFitToHeight(0);

                // Set Margin Tipis (Narrow) agar muat banyak
                $sheet->getPageMargins()->setTop(0.5);
                $sheet->getPageMargins()->setRight(0.5);
                $sheet->getPageMargins()->setLeft(0.5);
                $sheet->getPageMargins()->setBottom(0.5);

                // ===============================================
                // 2. STYLING TAMPILAN
                // ===============================================

                // Judul "DAFTAR HADIR" (Baris 1)
                $sheet->mergeCells('A1:H1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Header Tabel (Baris 8)
                $sheet->getStyle('A8:H8')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE0E0E0'], // Warna Abu-abu muda
                    ],
                ]);

                // Border untuk Seluruh Data (Mulai Baris 8 sampai bawah)
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A8:H' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_TOP, // Teks rata atas
                        'wrapText' => true, // Text Wrap aktif agar kolom tidak terlalu lebar
                    ],
                ]);

                // Format Khusus Kolom NIP (C) dan No Kontak (H) jadi Text
                $sheet->getStyle('C9:C'.$highestRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('H9:H'.$highestRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            },
        ];
    }
}