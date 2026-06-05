<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAkhir extends Model
{
    use HasFactory;

    protected $table = 'penilaian_akhir';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'nilai_pretest',
        'nilai_posttest',
        'nilai_afektif',
        'nilai_psikomotor',
        'nilai_kehadiran',
        'skor_saw',
        'ranking',
        'predikat',
        'status_kelulusan',
        'verification_hash',
    ];

    protected function casts(): array
    {
        return [
            'nilai_pretest' => 'decimal:2',
            'nilai_posttest' => 'decimal:2',
            'nilai_afektif' => 'decimal:2',
            'nilai_psikomotor' => 'decimal:2',
            'nilai_kehadiran' => 'decimal:2',
            'skor_saw' => 'decimal:6',
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

    public function getSkorAkhirAttribute()
    {
        return $this->skor_saw;
    }
}
