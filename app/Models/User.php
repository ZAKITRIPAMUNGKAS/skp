<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Helper Role ──────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }

    public function isFasilitator(): bool
    {
        return $this->role === 'fasilitator';
    }

    // ── Relasi ─────────────────────────────────

    public function assignedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_fasilitator', 'user_id', 'event_id')->withTimestamps();
    }

    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function scannedAbsensi()
    {
        return $this->hasMany(Absensi::class, 'scanned_by');
    }

    public function psikomotorNilaiDinilai()
    {
        return $this->hasMany(PsikomotorNilai::class, 'dinilai_oleh');
    }


}
