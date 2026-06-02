<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'no_hp',
        'unit_kerja',
        'foto',
        'alamat_rumah',
        'jenis_kelamin',
        'nik',
        'nbm',
        'jabatan_aum',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'status_pernikahan',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'pendidikan_terakhir',
        'pendidikan_sd',
        'pendidikan_smp',
        'pendidikan_sma',
        'pendidikan_s1',
        'bahasa_dikuasai',
        'kemampuan_baca_quran',
        'hafalan_quran_1',
        'hafalan_quran_2',
        'aktivitas_sholat_masjid',
        'aktivitas_kajian_agama',
        'jumlah_buku_agama',
        'sumber_info_muhammadiyah',
        'langganan_suara_muhammadiyah',
        'lembaga_zis_diikuti',
        'tokoh_berpengaruh',
        'alasan_pilih_tokoh',
        'keaktifan_muhammadiyah',
        'keaktifan_ortom',
        'organisasi_lain',
        'harapan_pcm',
        'harapan_mengikuti_ba',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
    
    /**
     * Check if profile data is complete.
     */
    public function isComplete()
    {
        return !empty($this->nama_lengkap) && 
               !empty($this->no_hp) && 
               !empty($this->unit_kerja);
    }

    // ── Relasi ─────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventPeserta()
    {
        return $this->hasMany(EventPeserta::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_peserta');
    }

    public function jawabanPeserta()
    {
        return $this->hasMany(JawabanPeserta::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function afektifJawaban()
    {
        return $this->hasMany(AfektifJawaban::class);
    }

    public function psikomotorNilai()
    {
        return $this->hasMany(PsikomotorNilai::class);
    }

    public function angketJawaban()
    {
        return $this->hasMany(AngketJawaban::class);
    }

    public function angketKomentar()
    {
        return $this->hasMany(AngketKomentar::class);
    }

    public function penilaianAkhir()
    {
        return $this->hasMany(PenilaianAkhir::class);
    }
}
