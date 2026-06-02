<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AhpBobot extends Model
{
    use HasFactory;

    protected $table = 'ahp_bobot';

    protected $fillable = [
        'event_id',
        'matriks',
        'bobot_c1',
        'bobot_c2',
        'bobot_c3',
        'bobot_c4',
        'bobot_c5',
        'cr_value',
        'is_consistent',
    ];

    protected function casts(): array
    {
        return [
            'matriks' => 'array',
            'bobot_c1' => 'decimal:6',
            'bobot_c2' => 'decimal:6',
            'bobot_c3' => 'decimal:6',
            'bobot_c4' => 'decimal:6',
            'bobot_c5' => 'decimal:6',
            'cr_value' => 'decimal:6',
            'is_consistent' => 'boolean',
        ];
    }

    // ── Relasi ─────────────────────────────────

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
