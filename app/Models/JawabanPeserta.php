<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPeserta extends Model
{
    use HasFactory;

    protected $table = 'jawaban_peserta';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'soal_id',
        'pilihan_id',
        'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
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

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    public function pilihan()
    {
        return $this->belongsTo(PilihanJawaban::class, 'pilihan_id');
    }
}
