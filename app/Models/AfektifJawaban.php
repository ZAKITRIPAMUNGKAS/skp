<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfektifJawaban extends Model
{
    use HasFactory;

    protected $table = 'afektif_jawaban';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'sub_aspek_id',
        'butir_id',
        'jawaban',
        'skor',
    ];

    /**
     * Dapatkan skor afektif yang dibalik apabila pernyataannya negatif.
     */
    public function getSkorAttribute() 
    {
        $map_positif = ['SS' => 4, 'S' => 3, 'TS' => 2, 'STS' => 1];
        $map_negatif = ['SS' => 1, 'S' => 2, 'TS' => 3, 'STS' => 4];
        
        // Cek polaritas di relasi butir (is_positif = 1 -> True, 0 -> False)
        if ($this->relationLoaded('butir') || $this->butir) {
            return $this->butir->is_positif 
                ? $map_positif[$this->jawaban] 
                : $map_negatif[$this->jawaban];
        }

        return $this->attributes['skor'] ?? 0;
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

    public function subAspek()
    {
        return $this->belongsTo(AfektifSubAspek::class, 'sub_aspek_id');
    }

    public function butir()
    {
        return $this->belongsTo(AfektifButir::class, 'butir_id');
    }
}
