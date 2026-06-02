<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfektifSubAspek extends Model
{
    use HasFactory;

    protected $table = 'afektif_sub_aspek';

    protected $fillable = [
        'event_id',
        'nama_sub_aspek',
        'sesi_id',
        'urutan',
        'status',
    ];

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sesi()
    {
        return $this->belongsTo(EventSesi::class, 'sesi_id');
    }

    public function butir()
    {
        return $this->hasMany(AfektifButir::class, 'sub_aspek_id');
    }

    public function jawaban()
    {
        return $this->hasMany(AfektifJawaban::class, 'sub_aspek_id');
    }
}
