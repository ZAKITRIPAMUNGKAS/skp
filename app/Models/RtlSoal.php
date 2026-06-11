<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtlSoal extends Model
{
    use HasFactory;

    protected $table = 'rtl_soal';

    protected $fillable = [
        'event_id',
        'pertanyaan',
        'tipe',
        'urutan',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function jawaban()
    {
        return $this->hasMany(RtlJawaban::class, 'rtl_soal_id');
    }
}
