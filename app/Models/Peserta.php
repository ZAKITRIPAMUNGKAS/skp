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
        'nama_panggilan',
        'email',
        'no_hp',
        'unit_kerja',
        'foto',
        'surat_komitmen',
        'surat_tidak_bersedia',
        'alamat_rumah',
        'jenis_kelamin',
        'nik',
        'nbm',
        'jabatan_aum',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'status_pernikahan',
        'jumlah_anak',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'pendidikan_terakhir',
        'pendidikan_sd',
        'pendidikan_smp',
        'pendidikan_sma',
        'pendidikan_s1',
        'bahasa_dikuasai',
        'kemampuan_baca_quran',
        'kompetensi_keberagamaan',
        'kompetensi_akademis',
        'kompetensi_sosial',
        'kompetensi_keorganisasian',
        'catatan_makanan',
        'catatan_kesehatan',
        'catatan_panitia',
        'hafalan_quran_1',
        'hafalan_quran_2',
        'aktivitas_sholat_masjid',
        'aktivitas_kajian_agama',
        'ukuran_kaos',
        'rencana_keberangkatan',
        'aktivitas_duduk',
        'aktivitas_tangga',
        'aktivitas_sholat',
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
        'arqam_ke',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getFotoUrlAttribute()
    {
        if (empty($this->foto)) {
            return null;
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            $url = $this->foto;
            if (str_contains($url, 'drive.google.com')) {
                $fileId = '';
                if (preg_match('/id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
                    $fileId = $matches[1];
                } elseif (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                    $fileId = $matches[1];
                }
                
                if (!empty($fileId)) {
                    return "https://lh3.googleusercontent.com/d/" . $fileId;
                }
            }
            return $url;
        }

        return asset('storage/' . $this->foto);
    }

    public function getFotoPdfPathAttribute()
    {
        if (empty($this->foto)) {
            return null;
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto_url;
        }

        return public_path('storage/' . $this->foto);
    }

    public function getFotoBase64Attribute()
    {
        if (empty($this->foto)) {
            return null;
        }

        $path = $this->foto;
        $isRemote = str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
        
        if ($isRemote) {
            try {
                $url = $this->foto_url;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 3); // 3 seconds timeout
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($ch);
                $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                curl_close($ch);

                if ($data && !empty($data)) {
                    if (empty($mime) || !str_contains($mime, 'image/')) {
                        $mime = 'image/jpeg';
                    }
                    return 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            } catch (\Exception $e) {
                // Ignore and fallback
            }
            return null;
        }

        // Local file
        $localPath = public_path('storage/' . $path);
        if (file_exists($localPath)) {
            $data = @file_get_contents($localPath);
            if ($data !== false) {
                $ext = strtolower(pathinfo($localPath, PATHINFO_EXTENSION));
                $mime = 'image/jpeg';
                if ($ext === 'png') $mime = 'image/png';
                elseif ($ext === 'gif') $mime = 'image/gif';
                elseif ($ext === 'webp') $mime = 'image/webp';
                return 'data:' . $mime . ';base64,' . base64_encode($data);
            }
        }

        return null;
    }

    /**
     * Check if profile data is complete.
     */
    public function isComplete()
    {
        return !empty($this->nama_lengkap) && 
               !empty($this->nama_panggilan) && 
               !empty($this->no_hp) && 
               !empty($this->unit_kerja) && 
               !empty($this->jenis_kelamin) && 
               !empty($this->nik) && 
               !empty($this->tempat_lahir) && 
               !empty($this->tanggal_lahir) && 
               !empty($this->status_pernikahan) && 
               !empty($this->jabatan_aum) && 
               !empty($this->ukuran_kaos) && 
               !empty($this->alamat_rumah);
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
