<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSesi extends Model
{
    use HasFactory;

    protected $table = 'event_sesi';

    protected $fillable = [
        'event_id',
        'nama_sesi',
        'urutan',
    ];

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'sesi_id');
    }

    public function afektifSubAspek()
    {
        return $this->hasMany(AfektifSubAspek::class, 'sesi_id');
    }
}
