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
