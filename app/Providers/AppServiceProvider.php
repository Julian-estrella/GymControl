<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Solución para error SSL de Gmail SMTP en entorno local de Windows
        if (app()->environment('local')) {
            $username = config('mail.mailers.smtp.username');
            $password = config('mail.mailers.smtp.password');
            $host = config('mail.mailers.smtp.host');
            $port = config('mail.mailers.smtp.port');

            // Configurar URL dinámicamente con bypass de verificación SSL (verify_peer=0)
            if ($username && $password && $host) {
                $url = "smtp://" . urlencode($username) . ":" . urlencode($password) . "@{$host}:{$port}?verify_peer=0";
                config(['mail.mailers.smtp.url' => $url]);
            }
        }
    }
}
