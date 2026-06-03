<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory, \App\Traits\Loggable;

    protected $table = 'soal';

    protected $fillable = [
        'event_id',
        'event_sesi_id',
        'tipe',
        'teks_soal',
        'urutan',
    ];

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventSesi()
    {
        return $this->belongsTo(EventSesi::class, 'event_sesi_id');
    }

    public function pilihanJawaban()
    {
        return $this->hasMany(PilihanJawaban::class);
    }

    public function jawabanPeserta()
    {
        return $this->hasMany(JawabanPeserta::class);
    }
}
