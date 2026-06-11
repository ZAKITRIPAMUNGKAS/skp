<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaTesMulai extends Model
{
    use HasFactory;

    protected $table = 'peserta_tes_mulai';

    protected $fillable = [
        'peserta_id',
        'event_id',
        'event_sesi_id',
        'tipe',
        'waktu_mulai',
    ];

    protected function casts(): array
    {
        return [
            'waktu_mulai' => 'datetime',
        ];
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventSesi()
    {
        return $this->belongsTo(EventSesi::class, 'event_sesi_id');
    }
}
