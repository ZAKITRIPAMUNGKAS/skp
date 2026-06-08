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

    public function getResolvedAddressComponents()
    {
        if (empty($this->alamat_rumah)) {
            return [
                'provinsi' => $this->attributes['provinsi'] ?? null,
                'kabupaten' => $this->attributes['kabupaten'] ?? null,
                'kecamatan' => $this->attributes['kecamatan'] ?? null,
                'desa_kelurahan' => $this->attributes['desa_kelurahan'] ?? null,
            ];
        }

        $address = $this->alamat_rumah;
        $cleanAddress = strtolower($address);

        // 1. Resolve Provinsi
        $resolvedProv = $this->attributes['provinsi'] ?? null;
        if (empty($resolvedProv) || strtolower(trim($resolvedProv)) === 'lainnya') {
            $resolvedProv = null;
        }
        
        $provinces = [
            'jawa tengah' => 'Jawa Tengah',
            'jawa timur' => 'Jawa Timur',
            'jawa barat' => 'Jawa Barat',
            'dki jakarta' => 'DKI Jakarta',
            'jakarta' => 'DKI Jakarta',
            'yogyakarta' => 'DIY Yogyakarta',
            'diy' => 'DIY Yogyakarta',
            'banten' => 'Banten',
            'bali' => 'Bali',
            'aceh' => 'Aceh',
            'sumatera utara' => 'Sumatera Utara',
            'sumatera barat' => 'Sumatera Barat',
            'riau' => 'Riau',
            'kepulauan riau' => 'Kepulauan Riau',
            'jambi' => 'Jambi',
            'sumatera selatan' => 'Sumatera Selatan',
            'bangka belitung' => 'Bangka Belitung',
            'bengkulu' => 'Bengkulu',
            'lampung' => 'Lampung',
            'kalimantan barat' => 'Kalimantan Barat',
            'kalimantan tengah' => 'Kalimantan Tengah',
            'kalimantan selatan' => 'Kalimantan Selatan',
            'kalimantan timur' => 'Kalimantan Timur',
            'kalimantan utara' => 'Kalimantan Utara',
            'sulawesi utara' => 'Sulawesi Utara',
            'sulawesi tengah' => 'Sulawesi Tengah',
            'sulawesi selatan' => 'Sulawesi Selatan',
            'sulawesi tenggara' => 'Sulawesi Tenggara',
            'gorontalo' => 'Gorontalo',
            'sulawesi barat' => 'Sulawesi Barat',
            'nusa tenggara barat' => 'Nusa Tenggara Barat',
            'ntb' => 'Nusa Tenggara Barat',
            'nusa tenggara timur' => 'Nusa Tenggara Timur',
            'ntt' => 'Nusa Tenggara Timur',
            'maluku' => 'Maluku',
            'maluku utara' => 'Maluku Utara',
            'papua' => 'Papua'
        ];
        foreach ($provinces as $key => $name) {
            if (str_contains($cleanAddress, $key)) {
                $resolvedProv = $name;
                break;
            }
        }
        if (empty($resolvedProv)) {
            $resolvedProv = $this->attributes['provinsi'] ?? null;
        }

        // 2. Resolve Kabupaten
        $resolvedKab = $this->attributes['kabupaten'] ?? null;
        if (empty($resolvedKab) || strtolower(trim($resolvedKab)) === 'lainnya') {
            $resolvedKab = null;
        }

        if (preg_match('/((?:kabupaten|kab\.|kota)\s*[a-zA-Z\s]+)/i', $address, $matches)) {
            $captured = trim(explode(',', $matches[1])[0]);
            $captured = preg_replace('/^kab\./i', 'Kabupaten', $captured);
            $resolvedKab = ucwords(strtolower($captured));
        } else {
            $cities = [
                'pacitan' => 'Kabupaten Pacitan',
                'sragen' => 'Kabupaten Sragen',
                'surakarta' => 'Kota Surakarta',
                'solo' => 'Kota Surakarta',
                'rembang' => 'Kabupaten Rembang',
                'probolinggo' => 'Kota Probolinggo',
                'pekanbaru' => 'Kota Pekanbaru',
                'bantul' => 'Kabupaten Bantul',
                'semarang' => 'Kota Semarang',
                'klaten' => 'Kabupaten Klaten',
                'boyolali' => 'Kabupaten Boyolali',
                'karanganyar' => 'Kabupaten Karanganyar',
                'sukoharjo' => 'Kabupaten Sukoharjo',
                'yogyakarta' => 'Kota Yogyakarta',
                'jogja' => 'Kota Yogyakarta',
                'sleman' => 'Kabupaten Sleman',
                'wonogiri' => 'Kabupaten Wonogiri',
                'pati' => 'Kabupaten Pati',
                'kendal' => 'Kabupaten Kendal',
                'temanggung' => 'Kabupaten Temanggung',
                'magelang' => 'Kota Magelang',
                'purworejo' => 'Kabupaten Purworejo',
                'kebumen' => 'Kabupaten Kebumen',
                'banyumas' => 'Kabupaten Banyumas',
                'cilacap' => 'Kabupaten Cilacap',
                'brebes' => 'Kabupaten Brebes',
                'tegal' => 'Kota Tegal',
                'pemalang' => 'Kabupaten Pemalang',
                'pekalongan' => 'Kota Pekalongan',
                'batang' => 'Kabupaten Batang',
                'demak' => 'Kabupaten Demak',
                'kudus' => 'Kabupaten Kudus',
                'jepara' => 'Kabupaten Jepara',
                'blora' => 'Kabupaten Blora',
                'grobogan' => 'Kabupaten Grobogan',
                'ngawi' => 'Kabupaten Ngawi',
                'magetan' => 'Kabupaten Magetan',
                'madiun' => 'Kota Madiun',
                'ponorogo' => 'Kabupaten Ponorogo',
                'trenggalek' => 'Kabupaten Trenggalek',
                'tulungagung' => 'Kabupaten Tulungagung',
                'blitar' => 'Kota Blitar',
                'kediri' => 'Kota Kediri',
                'nganjuk' => 'Kabupaten Nganjuk',
                'bojonegoro' => 'Kabupaten Bojonegoro',
                'tuban' => 'Kabupaten Tuban',
                'lamongan' => 'Kabupaten Lamongan',
                'gresik' => 'Kabupaten Gresik',
                'surabaya' => 'Kota Surabaya',
                'sidoarjo' => 'Kabupaten Sidoarjo',
                'mojokerto' => 'Kota Mojokerto',
                'jombang' => 'Kabupaten Jombang',
                'malang' => 'Kota Malang',
                'pasuruan' => 'Kota Pasuruan',
                'lumajang' => 'Kabupaten Lumajang',
                'jember' => 'Kabupaten Jember',
                'bondowoso' => 'Kabupaten Bondowoso',
                'situbondo' => 'Kabupaten Situbondo',
                'banyuwangi' => 'Kabupaten Banyuwangi',
                'tangerang' => 'Kabupaten Tangerang',
                'jakarta' => 'Kota Jakarta',
                'bandung' => 'Kota Bandung',
                'bogor' => 'Kota Bogor',
                'depok' => 'Kota Depok',
                'bekasi' => 'Kota Bekasi'
            ];
            foreach ($cities as $key => $name) {
                if (str_contains($cleanAddress, $key)) {
                    $resolvedKab = $name;
                    break;
                }
            }
        }
        if (empty($resolvedKab)) {
            $resolvedKab = $this->attributes['kabupaten'] ?? null;
        }

        // 3. Resolve Kecamatan
        $resolvedKec = $this->attributes['kecamatan'] ?? null;
        if (preg_match('/(?:kecamatan|kec\.)\s*([a-zA-Z\s]+)/i', $address, $matches)) {
            $captured = trim(explode(',', $matches[1])[0]);
            if (!empty($captured) && strlen($captured) < 30) {
                $resolvedKec = ucwords(strtolower($captured));
            }
        }

        // 4. Resolve Desa/Kelurahan
        $resolvedDesa = $this->attributes['desa_kelurahan'] ?? null;
        if (preg_match('/(?:desa|kelurahan|ds\.|kel\.)\s*([a-zA-Z\s]+)/i', $address, $matches)) {
            $captured = trim(explode(',', $matches[1])[0]);
            if (!empty($captured) && strlen($captured) < 30) {
                $resolvedDesa = ucwords(strtolower($captured));
            }
        }

        // 5. Check for Mismatch with DB Kabupaten
        $dbKab = $this->attributes['kabupaten'] ?? '';
        $dbKabClean = strtolower(preg_replace('/[^a-z]/', '', $dbKab));
        $resolvedKabClean = strtolower(preg_replace('/[^a-z]/', '', $resolvedKab));

        if (!empty($dbKabClean) && $dbKabClean !== $resolvedKabClean && strtolower($dbKab) !== 'lainnya') {
            // Address mismatch! Extract details from comma-separated tokens
            $parts = array_map('trim', explode(',', $address));
            
            $filteredParts = [];
            foreach ($parts as $part) {
                $partClean = strtolower($part);
                $isProv = false;
                foreach ($provinces as $key => $name) {
                    if ($partClean === $key || $partClean === strtolower($name) || str_contains($partClean, $key)) {
                        $isProv = true;
                        break;
                    }
                }
                if (!$isProv) {
                    $filteredParts[] = $part;
                }
            }

            $fpCount = count($filteredParts);
            if ($fpCount >= 2) {
                $lastPart = strtolower($filteredParts[$fpCount - 1]);
                $kabWord = strtolower(str_replace(['kabupaten', 'kota'], '', $resolvedKab));
                $kabWord = trim($kabWord);

                if (str_contains($lastPart, $kabWord)) {
                    $kecPart = $filteredParts[$fpCount - 2];
                    $resolvedKec = ucwords(strtolower(preg_replace('/^(kecamatan|kec\.)\s*/i', '', $kecPart)));

                    if ($fpCount >= 3) {
                        $desaPart = $filteredParts[$fpCount - 3];
                        $resolvedDesa = ucwords(strtolower(preg_replace('/^(desa|kelurahan|ds\.|kel\.)\s*/i', '', $desaPart)));
                    } else {
                        $resolvedDesa = '—';
                    }
                }
            } else {
                $resolvedKec = '—';
                $resolvedDesa = '—';
            }
        }

        return [
            'provinsi' => $resolvedProv,
            'kabupaten' => $resolvedKab,
            'kecamatan' => $resolvedKec,
            'desa_kelurahan' => $resolvedDesa,
        ];
    }

    public function getProvinsiAttribute($value)
    {
        return $this->getResolvedAddressComponents()['provinsi'];
    }

    public function getKabupatenAttribute($value)
    {
        return $this->getResolvedAddressComponents()['kabupaten'];
    }

    public function getKecamatanAttribute($value)
    {
        return $this->getResolvedAddressComponents()['kecamatan'];
    }

    public function getDesaKelurahanAttribute($value)
    {
        return $this->getResolvedAddressComponents()['desa_kelurahan'];
    }

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
            $cacheKey = md5($path);
            $cacheDir = storage_path('photo_cache');
            $cachePath = $cacheDir . '/' . $cacheKey;

            if (file_exists($cachePath)) {
                $size = @filesize($cachePath);
                if ($size === 0) {
                    return null; // Failure marker
                }
                $data = @file_get_contents($cachePath);
                if ($data !== false && strlen($data) > 0) {
                    return $data;
                }
            }

            // Single fallback if not pre-fetched (or if cache was deleted/missed)
            try {
                $url = $this->foto_url;
                $data = null;
                $mime = 'image/jpeg';

                if (function_exists('curl_init')) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $data = curl_exec($ch);
                    $ct = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                    curl_close($ch);
                    if ($ct && str_contains($ct, 'image/')) {
                        $mime = $ct;
                    }
                } else {
                    $ctx = stream_context_create([
                        'http' => ['timeout' => 3],
                        'https' => ['timeout' => 3],
                    ]);
                    $data = @file_get_contents($url, false, $ctx);
                }

                if ($data && strlen((string)$data) > 100) {
                    $base64Data = 'data:' . $mime . ';base64,' . base64_encode($data);
                    if (!file_exists($cacheDir)) {
                        @mkdir($cacheDir, 0755, true);
                    }
                    @file_put_contents($cachePath, $base64Data);
                    return $base64Data;
                } else {
                    if (!file_exists($cacheDir)) {
                        @mkdir($cacheDir, 0755, true);
                    }
                    @file_put_contents($cachePath, '');
                }
            } catch (\Throwable $e) {
                if (!file_exists($cacheDir)) {
                    @mkdir($cacheDir, 0755, true);
                }
                @file_put_contents($cachePath, '');
            }
            return null;
        }

        // Local file — read directly from disk, no network involved
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

    public static function prefetchRemotePhotos($pesertaCollection)
    {
        $urls = [];
        $cacheDir = storage_path('photo_cache');
        if (!file_exists($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }

        foreach ($pesertaCollection as $p) {
            if ($p && $p->foto) {
                $path = $p->foto;
                $isRemote = str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
                if ($isRemote) {
                    $cacheKey = md5($path);
                    $cachePath = $cacheDir . '/' . $cacheKey;
                    if (!file_exists($cachePath)) {
                        $urls[$cacheKey] = $p->foto_url;
                    }
                }
            }
        }

        if (empty($urls)) {
            return;
        }

        if (function_exists('curl_multi_init')) {
            $mh = curl_multi_init();
            $handles = [];

            foreach ($urls as $key => $url) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 4); // 4 seconds max per request
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_multi_add_handle($mh, $ch);
                $handles[$key] = $ch;
            }

            $active = null;
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            while ($active && $mrc == CURLM_OK) {
                if (curl_multi_select($mh) != -1) {
                    do {
                        $mrc = curl_multi_exec($mh, $active);
                    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
                }
            }

            foreach ($handles as $key => $ch) {
                $data = curl_multi_getcontent($ch);
                $ct = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                curl_multi_remove_handle($mh, $ch);
                curl_close($ch);

                $cachePath = $cacheDir . '/' . $key;
                if ($data && strlen($data) > 100) {
                    $mime = ($ct && str_contains($ct, 'image/')) ? $ct : 'image/jpeg';
                    $base64Data = 'data:' . $mime . ';base64,' . base64_encode($data);
                    @file_put_contents($cachePath, $base64Data);
                } else {
                    // Mark as failed (0-byte file)
                    @file_put_contents($cachePath, '');
                }
            }

            curl_multi_close($mh);
        } else {
            // Fallback to serial downloads with low timeout
            foreach ($urls as $key => $url) {
                $cachePath = $cacheDir . '/' . $key;
                try {
                    $ctx = stream_context_create([
                        'http' => ['timeout' => 2],
                        'https' => ['timeout' => 2],
                    ]);
                    $data = @file_get_contents($url, false, $ctx);
                    if ($data && strlen($data) > 100) {
                        $mime = 'image/jpeg';
                        $base64Data = 'data:' . $mime . ';base64,' . base64_encode($data);
                        @file_put_contents($cachePath, $base64Data);
                    } else {
                        @file_put_contents($cachePath, '');
                    }
                } catch (\Throwable $e) {
                    @file_put_contents($cachePath, '');
                }
            }
        }
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
