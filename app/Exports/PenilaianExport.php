<?php

namespace App\Exports;

use App\Models\PenilaianAkhir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenilaianExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        return PenilaianAkhir::with('peserta')
            ->where('event_id', $this->eventId)
            ->orderBy('ranking', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Rank',
            'Nama Lengkap',
            'NIP/NBM',
            'Unit Kerja',
            'C1 (Pretest)',
            'C2 (Posttest)',
            'C3 (Afektif)',
            'C4 (Psikomotor)',
            'C5 (Kehadiran)',
            'Skor SAW',
            'Predikat',
            'Status Kelulusan'
        ];
    }

    public function map($row): array
    {
        return [
            $row->ranking,
            $row->peserta->nama_lengkap ?? '-',
            $row->peserta->nim_nip_nbm ?? '-',
            $row->peserta->unit_kerja ?? '-',
            $row->nilai_pretest,
            $row->nilai_posttest,
            $row->nilai_afektif,
            $row->nilai_psikomotor,
            $row->nilai_kehadiran,
            $row->skor_saw,
            $row->predikat,
            $row->status_kelulusan,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
