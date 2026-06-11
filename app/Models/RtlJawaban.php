<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtlJawaban extends Model
{
    use HasFactory;

    protected $table = 'rtl_jawaban';

    protected $fillable = [
        'rtl_id',
        'rtl_soal_id',
        'jawaban',
    ];

    public function rtl()
    {
        return $this->belongsTo(Rtl::class);
    }

    public function soal()
    {
        return $this->belongsTo(RtlSoal::class, 'rtl_soal_id');
    }
}
