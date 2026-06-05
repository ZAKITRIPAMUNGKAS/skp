<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPeserta extends Model
{
    use HasFactory;

    protected $table = 'event_peserta';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'qr_code',
        'status_aktif',
        'konfirmasi_kesediaan',
        'alasan_tidak_hadir',
        'surat_tidak_hadir',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
        ];
    }

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function skor()
    {
        return $this->hasOne(PenilaianAkhir::class, 'peserta_id', 'peserta_id')
                    ->where('event_id', $this->event_id);
    }
}
