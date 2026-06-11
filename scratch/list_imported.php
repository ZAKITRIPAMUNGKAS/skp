<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$eps = App\Models\EventPeserta::where('event_id', 2)->with('peserta')->get();
foreach ($eps as $ep) {
    echo "Nama: " . $ep->peserta->nama_lengkap . " | Kesediaan: " . $ep->konfirmasi_kesediaan . " | Foto: " . ($ep->peserta->foto ? 'YA' : 'TIDAK') . "\n";
}
