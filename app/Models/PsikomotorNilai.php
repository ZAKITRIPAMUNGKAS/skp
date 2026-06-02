<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsikomotorNilai extends Model
{
    use HasFactory;

    protected $table = 'psikomotor_nilai';

    protected $fillable = [
        'event_id',
        'peserta_id',
        'template_id',
        'skor',
        'dinilai_oleh',
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

    public function template()
    {
        return $this->belongsTo(PsikomotorTemplate::class, 'template_id');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'dinilai_oleh');
    }
}
