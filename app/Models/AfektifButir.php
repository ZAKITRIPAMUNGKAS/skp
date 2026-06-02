<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfektifButir extends Model
{
    use HasFactory;

    protected $table = 'afektif_butir';

    protected $fillable = [
        'sub_aspek_id',
        'teks_pernyataan',
        'is_positif',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'is_positif' => 'boolean',
        ];
    }

    // ── Relasi ─────────────────────────────────

    public function subAspek()
    {
        return $this->belongsTo(AfektifSubAspek::class, 'sub_aspek_id');
    }

    public function jawaban()
    {
        return $this->hasMany(AfektifJawaban::class, 'butir_id');
    }
}
