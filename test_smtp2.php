<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$caFile = __DIR__.'/cacert.pem';

ini_set('openssl.cafile', $caFile);
ini_set('curl.cainfo', $caFile);

try {
    \Illuminate\Support\Facades\Mail::raw('Prueba de conexión SMTP', function ($msg) {
        $msg->to('julianstarbe@gmail.com')->subject('Prueba GymControl Local');
    });
    echo "EXITO: Correo enviado sin errores SSL.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
