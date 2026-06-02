<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes, \App\Traits\Loggable;

    protected $fillable = [
        'nama_event',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'deskripsi',
        'status',
        'kuota',
        'created_by',
        'registration_token',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            if (!$event->registration_token) {
                $event->registration_token = \Illuminate\Support\Str::random(12);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    // ── Relasi ─────────────────────────────────

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sesi()
    {
        return $this->hasMany(EventSesi::class);
    }

    public function eventPeserta()
    {
        return $this->hasMany(EventPeserta::class);
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'event_peserta');
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    public function sesiTes()
    {
        return $this->hasMany(SesiTes::class);
    }

    public function jawabanPeserta()
    {
        return $this->hasMany(JawabanPeserta::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function afektifSubAspek()
    {
        return $this->hasMany(AfektifSubAspek::class);
    }

    public function afektifJawaban()
    {
        return $this->hasMany(AfektifJawaban::class);
    }

    public function psikomotorTemplate()
    {
        return $this->hasMany(PsikomotorTemplate::class);
    }

    public function psikomotorNilai()
    {
        return $this->hasMany(PsikomotorNilai::class);
    }

    public function angketItem()
    {
        return $this->hasMany(AngketItem::class);
    }

    public function angketJawaban()
    {
        return $this->hasMany(AngketJawaban::class);
    }

    public function angketKomentar()
    {
        return $this->hasMany(AngketKomentar::class);
    }

    public function ahpBobot()
    {
        return $this->hasMany(AhpBobot::class);
    }

    public function penilaianAkhir()
    {
        return $this->hasMany(PenilaianAkhir::class);
    }

}
