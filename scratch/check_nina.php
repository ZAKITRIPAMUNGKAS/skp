<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$user = App\Models\User::where('name', 'like', '%Nina%')->first();
print_r($user ? $user->toArray() : 'User Nina not found');
if ($user) {
    $peserta = App\Models\Peserta::where('user_id', $user->id)->first();
    print_r($peserta ? $peserta->toArray() : 'Peserta Nina not found');
}
