<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\EventPeserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function collection()
    {
        return EventPeserta::with(['peserta', 'peserta.user'])
            ->where('event_id', $this->event->id)
            ->where('status_aktif', true)
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Akun Login',
            'Nama Lengkap',
            'NIK',
            'NBM',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Status Pernikahan',
            'Alamat Lengkap',
            'Desa/Kelurahan',
            'Kecamatan',
            'Kabupaten',
            'No. WhatsApp',
            'Email',
            'Jabatan di AUM',
            'Unit Kerja / Instansi',
            'Pendidikan Terakhir',
            'Pendidikan SD',
            'Pendidikan SMP',
            'Pendidikan SMA',
            'Pendidikan S1',
            'Bahasa Dikuasai',
            'Kemampuan Baca Al-Quran',
            'Hafalan Al-Quran',
            'Aktivitas Sholat Masjid',
            'Kajian Agama',
            'Jumlah Buku Agama',
            'Sumber Info Muhammadiyah',
            'Langganan Suara Muhammadiyah',
            'Lembaga ZIS Diikuti',
            'Tokoh Inspirasi',
            'Alasan Pilih Tokoh',
            'Keaktifan Muhammadiyah',
            'Keaktifan ORTOM',
            'Organisasi Lain',
            'Harapan PCM',
            'Harapan Mengikuti BA',
            'Waktu Mendaftar',
        ];
    }

    public function map($row): array
    {
        $p = $row->peserta;
        
        return [
            $p->user ? $p->user->username : '-',
            $p->nama_lengkap,
            "'" . $p->nik,
            "'" . $p->nbm,
            $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '-'),
            $p->tempat_lahir,
            $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-',
            $p->umur,
            $p->status_pernikahan,
            $p->alamat_rumah,
            $p->desa_kelurahan,
            $p->kecamatan,
            $p->kabupaten,
            "'" . $p->no_hp,
            $p->email,
            $p->jabatan_aum,
            $p->unit_kerja,
            $p->pendidikan_terakhir,
            $p->pendidikan_sd,
            $p->pendidikan_smp,
            $p->pendidikan_sma,
            $p->pendidikan_s1,
            $p->bahasa_dikuasai,
            $p->kemampuan_baca_quran,
            $p->hafalan_quran_1,
            $p->aktivitas_sholat_masjid,
            $p->aktivitas_kajian_agama,
            $p->jumlah_buku_agama,
            $p->sumber_info_muhammadiyah,
            $p->langganan_suara_muhammadiyah,
            $p->lembaga_zis_diikuti,
            $p->tokoh_berpengaruh,
            $p->alasan_pilih_tokoh,
            $p->keaktifan_muhammadiyah,
            $p->keaktifan_ortom,
            $p->organisasi_lain,
            $p->harapan_pcm,
            $p->harapan_mengikuti_ba,
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true, 
                    'color' => ['argb' => 'FFFFFFFF']
                ], 
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 
                    'color' => ['argb' => 'FF1A6D9B'] // Biru Arqam
                ]
            ],
        ];
    }
}
