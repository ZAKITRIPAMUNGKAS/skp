<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiTes extends Model
{
    use HasFactory;

    protected $table = 'sesi_tes';

    protected $fillable = [
        'event_id',
        'event_sesi_id',
        'tipe',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_menit',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'waktu_mulai' => 'datetime',
            'waktu_selesai' => 'datetime',
        ];
    }

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventSesi()
    {
        return $this->belongsTo(EventSesi::class, 'event_sesi_id');
    }
}
