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
        'tipe',
        'teks_soal',
        'urutan',
    ];

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
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
