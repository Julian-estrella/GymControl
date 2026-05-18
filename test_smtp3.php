<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    config(['mail.mailers.smtp.url' => 'smtp://julianstarbe@gmail.com:dxuf%20klgn%20sljg%20juwc@smtp.gmail.com:587?verify_peer=0']);
    \Illuminate\Support\Facades\Mail::raw('Prueba de conexión SMTP', function ($msg) {
        $msg->to('julianstarbe@gmail.com')->subject('Prueba GymControl Local DSN');
    });
    echo "EXITO: Correo enviado sin errores SSL.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
