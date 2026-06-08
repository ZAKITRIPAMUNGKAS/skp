<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketKomentar extends Model
{
    use HasFactory;

    protected $table = 'angket_komentar';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'komentar',
        'nominasi_disiplin_id',
        'nominasi_aktif_id',
        'nominasi_favorit_id',
    ];

    public function nominasiDisiplin()
    {
        return $this->belongsTo(Peserta::class, 'nominasi_disiplin_id');
    }

    public function nominasiAktif()
    {
        return $this->belongsTo(Peserta::class, 'nominasi_aktif_id');
    }

    public function nominasiFavorit()
    {
        return $this->belongsTo(Peserta::class, 'nominasi_favorit_id');
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
}
