<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketItem extends Model
{
    use HasFactory;

    protected $table = 'angket_item';

    protected $fillable = [
        'event_id',
        'kategori',
        'teks_item',
        'tipe',
        'urutan',
    ];

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function jawaban()
    {
        return $this->hasMany(AngketJawaban::class, 'item_id');
    }
}
