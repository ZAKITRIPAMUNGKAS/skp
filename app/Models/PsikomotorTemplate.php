<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsikomotorTemplate extends Model
{
    use HasFactory;

    protected $table = 'psikomotor_template';

    protected $fillable = [
        'event_id',
        'jenis',
        'nama_aspek',
        'skor_maks',
    ];

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function nilai()
    {
        return $this->hasMany(PsikomotorNilai::class, 'template_id');
    }
}
