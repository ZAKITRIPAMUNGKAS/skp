<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'event_id',
        'sesi_id',
        'peserta_id',
        'waktu_scan',
        'scanned_by',
    ];

    protected function casts(): array
    {
        return [
            'waktu_scan' => 'datetime',
        ];
    }

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sesi()
    {
        return $this->belongsTo(EventSesi::class, 'sesi_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
