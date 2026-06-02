<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketJawaban extends Model
{
    use HasFactory;

    protected $table = 'angket_jawaban';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'item_id',
        'jawaban',
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

    public function item()
    {
        return $this->belongsTo(AngketItem::class, 'item_id');
    }
}
