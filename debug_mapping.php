<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Simulasi mapHeadersToKeys pakai logic terbaru dari service
$filePath = __DIR__ . '/SET UP DATA ARQAM V2.0/32. Baitul Arqam Dosen UMS_Karanganyar (Jawaban)(1).xlsx';

$sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new class {}, new \Illuminate\Http\UploadedFile(
    $filePath, basename($filePath), null, null, true
));

// Pilih Sheet 1 (index 1) yang sudah terverifikasi benar
$sheet = $sheets[1];
$header = $sheet[0];

// Bersihkan header
$cleanedHeaders = array_map(function($h) {
    return strtolower(trim(preg_replace('/[^a-zA-Z0-9;_]/', ' ', strval($h))));
}, $header);

// Test baris pertama
$row = $sheet[1];

$mappedRow = [];
foreach ($cleanedHeaders as $idx => $h) {
    $val = $row[$idx] ?? null;
    if (empty($val)) continue;
    
    // Cek kolom gabungan
    if (str_contains($h, 'no;nik;nama;homebase') && !empty($val)) {
        $parts = explode(';', $val);
        if (count($parts) >= 4) {
            if (empty($mappedRow['nik']))          $mappedRow['nik']          = trim($parts[1]);
            if (empty($mappedRow['nama_lengkap'])) $mappedRow['nama_lengkap'] = trim($parts[2]);
            if (empty($mappedRow['unit_kerja']))   $mappedRow['unit_kerja']   = trim($parts[3]);
        }
        echo "[$idx] Gabungan: nik={$parts[1]}, nama={$parts[2]}, unit={$parts[3]}\n";
        continue;
    }
    
    if      (str_contains($h, 'nama lengkap')) { $mappedRow['nama_lengkap'] = $val; echo "[$idx] nama_lengkap = $val\n"; }
    elseif  ($h === 'nama')                    { if (empty($mappedRow['nama_lengkap'])) { $mappedRow['nama_lengkap'] = $val; echo "[$idx] nama_lengkap (fallback) = $val\n"; } else echo "[$idx] nama SKIPPED (sudah ada)\n"; }
    elseif  (str_contains($h, 'nama panggilan')) { $mappedRow['nama_panggilan'] = $val; echo "[$idx] nama_panggilan = $val\n"; }
    elseif  ($h === 'nik')                     { if (empty($mappedRow['nik'])) { $mappedRow['nik'] = $val; echo "[$idx] nik = $val\n"; } else echo "[$idx] nik SKIPPED (sudah ada: {$mappedRow['nik']})\n"; }
    elseif  (str_contains($h, 'email'))        { $mappedRow['email'] = $val; echo "[$idx] email = $val\n"; }
    elseif  (str_contains($h, 'no hp'))        { $mappedRow['no_hp'] = $val; echo "[$idx] no_hp = $val\n"; }
    elseif  (str_contains($h, 'homebase') || str_contains($h, 'unit kerja')) { if (empty($mappedRow['unit_kerja'])) { $mappedRow['unit_kerja'] = $val; echo "[$idx] unit_kerja = $val\n"; } }
    elseif  (str_contains($h, 'jenis kelamin')) { $mappedRow['jenis_kelamin'] = $val; echo "[$idx] jenis_kelamin = $val\n"; }
    elseif  (str_contains($h, 'alamat asal') || str_contains($h, 'alamat rumah')) { $mappedRow['alamat_asal'] = $val; echo "[$idx] alamat_asal = " . substr($val,0,50) . "\n"; }
    elseif  (str_contains($h, 'dukuh') || str_contains($h, 'rt rw')) { $mappedRow['alamat_detail'] = $val; echo "[$idx] alamat_detail = $val\n"; }
    elseif  (str_contains($h, 'kalurahan') || str_contains($h, 'desa')) { $mappedRow['desa_kelurahan'] = $val; echo "[$idx] desa_kelurahan = $val\n"; }
    elseif  (str_contains($h, 'kecamatan'))    { $mappedRow['kecamatan'] = $val; echo "[$idx] kecamatan = $val\n"; }
    elseif  (str_contains($h, 'kabupaten') || str_contains($h, 'kota')) { $mappedRow['kabupaten'] = $val; echo "[$idx] kabupaten = $val\n"; }
    elseif  (str_contains($h, 'propinsi') || str_contains($h, 'provinsi')) { $mappedRow['provinsi'] = $val; echo "[$idx] provinsi = $val\n"; }
    elseif  (str_contains($h, 'umur'))         { $mappedRow['umur'] = $val; echo "[$idx] umur = $val\n"; }
    elseif  (str_contains($h, 'pernikahan') || str_contains($h, 'menikah')) { $mappedRow['status_pernikahan'] = $val; echo "[$idx] status_pernikahan = $val\n"; }
    elseif  (str_contains($h, 'jumlah anak'))  { $mappedRow['jumlah_anak'] = $val; echo "[$idx] jumlah_anak = $val\n"; }
    elseif  (str_contains($h, 'ortom'))        { $mappedRow['keaktifan_ortom'] = $val; echo "[$idx] keaktifan_ortom = " . substr($val,0,40) . "\n"; }
    elseif  (str_contains($h, 'persyarikatan') || (str_contains($h, 'muhammadiyah') && !str_contains($h, 'mengikuti')) || str_contains($h, 'aisyiyah')) { if (empty($mappedRow['keaktifan_muhammadiyah'])) { $mappedRow['keaktifan_muhammadiyah'] = $val; echo "[$idx] keaktifan_muhammadiyah = " . substr($val,0,40) . "\n"; } }
    elseif  (str_contains($h, 'baca') && (str_contains($h, 'quran') || str_contains($h, 'qur an') || str_contains($h, 'qur'))) { $mappedRow['kemampuan_baca_quran'] = $val; echo "[$idx] kemampuan_baca_quran = $val\n"; }
    elseif  (str_contains($h, 'kesediaan'))    { $mappedRow['konfirmasi_kesediaan'] = $val; echo "[$idx] konfirmasi_kesediaan = $val\n"; }
    elseif  (str_contains($h, 'sebab'))        { $mappedRow['alasan_tidak_hadir'] = $val; echo "[$idx] alasan_tidak_hadir = $val\n"; }
    elseif  ((str_contains($h, 'tidak bersedia') || str_contains($h, 'pernyataan tidak')) && str_contains($h, 'unggah')) { $mappedRow['surat_tidak_bersedia'] = $val; echo "[$idx] surat_tidak_bersedia = " . substr($val,0,50) . "\n"; }
    elseif  (str_contains($h, 'komitmen') && str_contains($h, 'unggah')) { $mappedRow['surat_komitmen'] = $val; echo "[$idx] surat_komitmen = " . substr($val,0,50) . "\n"; }
    elseif  (str_contains($h, 'kaos'))         { $mappedRow['ukuran_kaos'] = $val; echo "[$idx] ukuran_kaos = $val\n"; }
    elseif  (str_contains($h, 'keberangkatan')) { $mappedRow['rencana_keberangkatan'] = $val; echo "[$idx] rencana_keberangkatan = $val\n"; }
    elseif  (str_contains($h, 'duduk'))        { $mappedRow['aktivitas_duduk'] = $val; echo "[$idx] aktivitas_duduk = $val\n"; }
    elseif  (str_contains($h, 'tangga'))       { $mappedRow['aktivitas_tangga'] = $val; echo "[$idx] aktivitas_tangga = $val\n"; }
    elseif  (str_contains($h, 'sholat'))       { $mappedRow['aktivitas_sholat'] = $val; echo "[$idx] aktivitas_sholat = $val\n"; }
    elseif  (str_contains($h, 'keberagamaan')) { $mappedRow['kompetensi_keberagamaan'] = $val; echo "[$idx] kompetensi_keberagamaan = $val\n"; }
    elseif  (str_contains($h, 'akademis'))     { $mappedRow['kompetensi_akademis'] = $val; echo "[$idx] kompetensi_akademis = $val\n"; }
    elseif  (str_contains($h, 'sosial'))       { $mappedRow['kompetensi_sosial'] = $val; echo "[$idx] kompetensi_sosial = $val\n"; }
    elseif  (str_contains($h, 'keorganisasian') || str_contains($h, 'kepemimpinan')) { $mappedRow['kompetensi_keorganisasian'] = $val; echo "[$idx] kompetensi_keorganisasian = $val\n"; }
    elseif  (str_contains($h, 'makanan'))      { $mappedRow['catatan_makanan'] = $val; echo "[$idx] catatan_makanan = $val\n"; }
    elseif  (str_contains($h, 'kesehatan'))    { $mappedRow['catatan_kesehatan'] = $val; echo "[$idx] catatan_kesehatan = $val\n"; }
    elseif  (str_contains($h, 'hal lain') || str_contains($h, 'hal hal lain') || str_contains($h, 'kepada panitia')) { $mappedRow['catatan_panitia'] = $val; echo "[$idx] catatan_panitia = $val\n"; }
    elseif  (str_contains($h, 'keterlibatan') || str_contains($h, 'di ranting')) { if (empty($mappedRow['keaktifan_muhammadiyah'])) { $mappedRow['keaktifan_muhammadiyah'] = $val; echo "[$idx] keaktifan_muhammadiyah (ranting) = " . substr($val,0,50) . "\n"; } }
    elseif  (str_contains($h, 'foto') || str_contains($h, 'idcard')) { $mappedRow['foto'] = $val; echo "[$idx] foto = " . substr($val,0,50) . "\n"; }
    elseif  (str_contains($h, 'mengikuti') && str_contains($h, 'arqam')) { $mappedRow['arqam_ke'] = $val; echo "[$idx] arqam_ke = $val\n"; }
    else {
        echo "[$idx] TIDAK TERPETAKAN — header: '$h' = " . substr(strval($val),0,30) . "\n";
    }
}

echo "\n=== HASIL MAPPING BARIS PERTAMA ===\n";
foreach ($mappedRow as $k => $v) {
    echo "  $k => " . substr(strval($v), 0, 60) . "\n";
}
