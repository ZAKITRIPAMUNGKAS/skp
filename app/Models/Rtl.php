<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rtl extends Model
{
    use HasFactory, \App\Traits\Loggable;

    protected $table = 'rtl';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'judul_kegiatan',
        'kategori_rtl',
        'tujuan',
        'sasaran',
        'indikator_keberhasilan',
        'waktu_pelaksanaan',
        'pihak_terlibat',
        'langkah_langkah',
        'status',
    ];

    protected $casts = [
        'langkah_langkah' => 'array',
    ];

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
