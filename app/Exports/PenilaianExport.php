<?php

namespace App\Exports;

use App\Models\PenilaianAkhir;
use App\Models\AhpBobot;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenilaianExport implements WithMultipleSheets
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function sheets(): array
    {
        // Ambil data peserta terurut ranking agar baris data sinkron di semua sheet
        $data = PenilaianAkhir::with('peserta')
            ->where('event_id', $this->eventId)
            ->whereHas('peserta.eventPeserta', function ($q) {
                $q->where('event_id', $this->eventId)->where('status_aktif', true);
            })
            ->orderBy('ranking', 'asc')
            ->get();

        return [
            new RankSawSheet($this->eventId, $data),
            new DetailPretestSheet($this->eventId, $data),
            new DetailPosttestSheet($this->eventId, $data),
            new DetailPsikomotorSheet($this->eventId, $data),
            new DetailAfektifSheet($this->eventId, $data),
            new DetailKehadiranSheet($this->eventId, $data),
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 1. SHEET RINGKASAN SAW (RANKING & BOBOT KRITERIA)
// ─────────────────────────────────────────────────────────────────────────────
class RankSawSheet implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithTitle, WithEvents
{
    protected $eventId;
    protected $data;
    protected $bobot;

    public function __construct($eventId, $data)
    {
        $this->eventId = $eventId;
        $this->data = $data;
        $this->bobot = AhpBobot::where('event_id', $this->eventId)->where('is_consistent', true)->first();
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Ringkasan SAW';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // Rank
            'B' => 30,  // Nama Lengkap
            'C' => 20,  // NIP/NBM
            'D' => 30,  // Unit Kerja
            'E' => 15,  // C1
            'F' => 15,  // C2
            'G' => 15,  // C3
            'H' => 15,  // C4
            'I' => 15,  // C5
            'J' => 20,  // Skor SAW Excel
            'K' => 20,  // Skor SAW DB
            'L' => 15,  // Predikat
            'M' => 18,  // Status Kelulusan
            'N' => 18,  // N-Gain Score
            'O' => 20,  // Efektivitas N-Gain
        ];
    }

    public function headings(): array
    {
        return [
            'Rank',
            'Nama Lengkap',
            'NIP/NBM',
            'Unit Kerja',
            'C1 (Pretest) - Dari Sheet Detail',
            'C2 (Posttest) - Dari Sheet Detail',
            'C3 (Psikomotor) - Dari Sheet Detail',
            'C4 (Afektif) - Dari Sheet Detail',
            'C5 (Kehadiran) - Dari Sheet Detail',
            'Skor SAW (Excel Formula)',
            'Skor SAW Database (Aplikasi)',
            'Predikat',
            'Status Kelulusan',
            'N-Gain (Kognitif)',
            'Efektivitas N-Gain'
        ];
    }

    public function map($row): array
    {
        static $index = 1;
        $index++;

        // Hubungkan nilai kriteria langsung ke sheet detail masing-masing berdasarkan baris
        $formulaC1 = "='Detail Pretest'!E{$index}";
        $formulaC2 = "='Detail Posttest'!E{$index}";
        $formulaC3 = "='Detail Psikomotor'!E{$index}";
        $formulaC4 = "='Detail Afektif'!E{$index}";
        $formulaC5 = "='Detail Kehadiran'!E{$index}";

        // Bobot AHP
        $w1 = $this->bobot ? $this->bobot->bobot_c1 : 0.20;
        $w2 = $this->bobot ? $this->bobot->bobot_c2 : 0.20;
        $w3 = $this->bobot ? $this->bobot->bobot_c3 : 0.20;
        $w4 = $this->bobot ? $this->bobot->bobot_c4 : 0.20;
        $w5 = $this->bobot ? $this->bobot->bobot_c5 : 0.20;

        $lastRow = $this->data->count() + 1;
        $normC1 = "E{$index} / MAX(E$2:E$lastRow)";
        $normC2 = "F{$index} / MAX(F$2:F$lastRow)";
        $normC3 = "G{$index} / MAX(G$2:G$lastRow)";
        $normC4 = "H{$index} / MAX(H$2:H$lastRow)";
        $normC5 = "I{$index} / MAX(I$2:I$lastRow)";

        // Rumus SAW lengkap di excel
        $sawFormula = "=({$w1} * {$normC1}) + ({$w2} * {$normC2}) + ({$w3} * {$normC3}) + ({$w4} * {$normC4}) + ({$w5} * {$normC5})";

        return [
            $row->ranking,
            $row->peserta->nama_lengkap ?? '-',
            $row->peserta->nim_nip_nbm ?? '-',
            $row->peserta->unit_kerja ?? '-',
            $formulaC1,
            $formulaC2,
            $formulaC3,
            $formulaC4,
            $formulaC5,
            $sawFormula,
            $row->skor_saw,
            $row->predikat,
            $row->status_kelulusan,
            $row->n_gain_score,
            $row->n_gain_category,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF114B32'] // Hijau gelap
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->data->count() + 1;

                // Terapkan format angka desimal
                $sheet->getStyle("E2:I{$lastRow}")->getNumberFormat()->setFormatCode('0.00');
                $sheet->getStyle("J2:K{$lastRow}")->getNumberFormat()->setFormatCode('0.0000');
                $sheet->getStyle("N2:N{$lastRow}")->getNumberFormat()->setFormatCode('0.00');

                // Tambahkan info bobot AHP yang digunakan
                $w1 = $this->bobot ? $this->bobot->bobot_c1 : 0.20;
                $w2 = $this->bobot ? $this->bobot->bobot_c2 : 0.20;
                $w3 = $this->bobot ? $this->bobot->bobot_c3 : 0.20;
                $w4 = $this->bobot ? $this->bobot->bobot_c4 : 0.20;
                $w5 = $this->bobot ? $this->bobot->bobot_c5 : 0.20;

                $infoRow = $lastRow + 3;
                $sheet->setCellValue("A{$infoRow}", "INFORMASI BOBOT KRITERIA AHP:");
                $sheet->getStyle("A{$infoRow}")->getFont()->setBold(true);

                $sheet->setCellValue("A" . ($infoRow+1), "C1 (Pretest)");
                $sheet->setCellValue("B" . ($infoRow+1), $w1);
                
                $sheet->setCellValue("A" . ($infoRow+2), "C2 (Posttest)");
                $sheet->setCellValue("B" . ($infoRow+2), $w2);

                $sheet->setCellValue("A" . ($infoRow+3), "C3 (Psikomotor)");
                $sheet->setCellValue("B" . ($infoRow+3), $w3);

                $sheet->setCellValue("A" . ($infoRow+4), "C4 (Afektif)");
                $sheet->setCellValue("B" . ($infoRow+4), $w4);

                $sheet->setCellValue("A" . ($infoRow+5), "C5 (Kehadiran)");
                $sheet->setCellValue("B" . ($infoRow+5), $w5);

                $sheet->getStyle("B" . ($infoRow+1) . ":B" . ($infoRow+5))
                    ->getNumberFormat()
                    ->setFormatCode('0.00%');
            }
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 2. SHEET DETAIL C1 (PRETEST)
// ─────────────────────────────────────────────────────────────────────────────
class DetailPretestSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $eventId;
    protected $data;
    protected $pretestTotal;

    public function __construct($eventId, $data)
    {
        $this->eventId = $eventId;
        $this->data = $data;
        $this->pretestTotal = \App\Models\Soal::where('event_id', $this->eventId)->where('tipe', 'pretest')->count() ?: 1;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Detail Pretest';
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIP/NBM',
            'Jawaban Benar (Pretest)',
            'Total Soal (Pretest)',
            'Nilai C1 (Excel Formula)'
        ];
    }

    public function map($row): array
    {
        static $index = 1;
        $index++;

        $pretestSoalIds = \App\Models\Soal::where('event_id', $this->eventId)->where('tipe', 'pretest')->pluck('id');
        $pretestBenar   = \App\Models\JawabanPeserta::where('event_id', $this->eventId)
            ->where('peserta_id', $row->peserta_id)
            ->whereIn('soal_id', $pretestSoalIds)
            ->where('is_correct', true)
            ->count();

        $formulaC1 = "=IF(D{$index}>0, (C{$index}/D{$index})*100, 0)";

        return [
            $row->peserta->nama_lengkap ?? '-',
            $row->peserta->nim_nip_nbm ?? '-',
            $pretestBenar,
            $this->pretestTotal,
            $formulaC1
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF1C64F2'] // Biru
                ]
            ],
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 3. SHEET DETAIL C2 (POSTTEST)
// ─────────────────────────────────────────────────────────────────────────────
class DetailPosttestSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $eventId;
    protected $data;
    protected $posttestTotal;

    public function __construct($eventId, $data)
    {
        $this->eventId = $eventId;
        $this->data = $data;
        $this->posttestTotal = \App\Models\Soal::where('event_id', $this->eventId)->where('tipe', 'posttest')->count() ?: 1;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Detail Posttest';
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIP/NBM',
            'Jawaban Benar (Posttest)',
            'Total Soal (Posttest)',
            'Nilai C2 (Excel Formula)'
        ];
    }

    public function map($row): array
    {
        static $index = 1;
        $index++;

        $posttestSoalIds = \App\Models\Soal::where('event_id', $this->eventId)->where('tipe', 'posttest')->pluck('id');
        $posttestBenar   = \App\Models\JawabanPeserta::where('event_id', $this->eventId)
            ->where('peserta_id', $row->peserta_id)
            ->whereIn('soal_id', $posttestSoalIds)
            ->where('is_correct', true)
            ->count();

        $formulaC2 = "=IF(D{$index}>0, (C{$index}/D{$index})*100, 0)";

        return [
            $row->peserta->nama_lengkap ?? '-',
            $row->peserta->nim_nip_nbm ?? '-',
            $posttestBenar,
            $this->posttestTotal,
            $formulaC2
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF047A55'] // Hijau Toska
                ]
            ],
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. SHEET DETAIL C3 (PSIKOMOTOR / PRAKTIK)
// ─────────────────────────────────────────────────────────────────────────────
class DetailPsikomotorSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $eventId;
    protected $data;
    protected $psikomotorMax;

    public function __construct($eventId, $data)
    {
        $this->eventId = $eventId;
        $this->data = $data;
        $this->psikomotorMax = \App\Models\PsikomotorTemplate::where('event_id', $this->eventId)->sum('skor_maks') ?: 100;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Detail Psikomotor';
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIP/NBM',
            'Skor Diperoleh (Psikomotor)',
            'Skor Maksimal (Praktik)',
            'Nilai C3 (Excel Formula)'
        ];
    }

    public function map($row): array
    {
        static $index = 1;
        $index++;

        $psikomotorSkor = \App\Models\PsikomotorNilai::where('event_id', $this->eventId)
            ->where('peserta_id', $row->peserta_id)
            ->sum('skor') ?: 0;

        $formulaC3 = "=IF(D{$index}>0, (C{$index}/D{$index})*100, 0)";

        return [
            $row->peserta->nama_lengkap ?? '-',
            $row->peserta->nim_nip_nbm ?? '-',
            $psikomotorSkor,
            $this->psikomotorMax,
            $formulaC3
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF7E3AF2'] // Ungu
                ]
            ],
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 5. SHEET DETAIL C4 (AFEKTIF / SIKAP)
// ─────────────────────────────────────────────────────────────────────────────
class DetailAfektifSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $eventId;
    protected $data;
    protected $afektifMax;

    public function __construct($eventId, $data)
    {
        $this->eventId = $eventId;
        $this->data = $data;
        $subAspekIds      = \App\Models\AfektifSubAspek::where('event_id', $this->eventId)->pluck('id');
        $this->afektifMax = (\App\Models\AfektifButir::whereIn('sub_aspek_id', $subAspekIds)->count() * 4) ?: 100;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Detail Afektif';
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIP/NBM',
            'Skor Angket Diperoleh',
            'Skor Angket Maksimal',
            'Nilai C4 (Excel Formula)'
        ];
    }

    public function map($row): array
    {
        static $index = 1;
        $index++;

        $afektifJawabans = \App\Models\AfektifJawaban::where('event_id', $this->eventId)
            ->where('peserta_id', $row->peserta_id)
            ->get();
        $afektifSkor = 0;
        foreach ($afektifJawabans as $aj) {
            $butir = \App\Models\AfektifButir::find($aj->butir_id);
            if ($butir) {
                $mapPos  = ['SS' => 4, 'S' => 3, 'TS' => 2, 'STS' => 1];
                $mapNeg  = ['SS' => 1, 'S' => 2, 'TS' => 3, 'STS' => 4];
                $afektifSkor += $butir->is_positif ? ($mapPos[$aj->jawaban] ?? 0) : ($mapNeg[$aj->jawaban] ?? 0);
            }
        }

        $formulaC4 = "=IF(D{$index}>0, (C{$index}/D{$index})*100, 0)";

        return [
            $row->peserta->nama_lengkap ?? '-',
            $row->peserta->nim_nip_nbm ?? '-',
            $afektifSkor,
            $this->afektifMax,
            $formulaC4
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFE02424'] // Merah
                ]
            ],
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. SHEET DETAIL C5 (KEHADIRAN / PRESENSI)
// ─────────────────────────────────────────────────────────────────────────────
class DetailKehadiranSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $eventId;
    protected $data;
    protected $totalSesi;

    public function __construct($eventId, $data)
    {
        $this->eventId = $eventId;
        $this->data = $data;
        $this->totalSesi = \App\Models\EventSesi::where('event_id', $this->eventId)->count() ?: 1;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Detail Kehadiran';
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIP/NBM',
            'Jumlah Kehadiran (Sesi)',
            'Total Sesi Kegiatan',
            'Nilai C5 (Excel Formula)'
        ];
    }

    public function map($row): array
    {
        static $index = 1;
        $index++;

        $hadirSesi = \App\Models\Absensi::where('event_id', $this->eventId)
            ->where('peserta_id', $row->peserta_id)
            ->count();

        $formulaC5 = "=IF(D{$index}>0, (C{$index}/D{$index})*100, 0)";

        return [
            $row->peserta->nama_lengkap ?? '-',
            $row->peserta->nim_nip_nbm ?? '-',
            $hadirSesi,
            $this->totalSesi,
            $formulaC5
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD03801'] // Oranye
                ]
            ],
        ];
    }
}
