<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanJawaban extends Model
{
    use HasFactory;

    protected $table = 'pilihan_jawaban';

    protected $fillable = [
        'soal_id',
        'huruf',
        'teks_pilihan',
        'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    // ── Relasi ─────────────────────────────────

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
