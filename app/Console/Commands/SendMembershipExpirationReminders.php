<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMembershipExpirationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'memberships:send-expiration-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo automáticamente a los clientes cuya membresía vence en 3 días.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = now()->addDays(3)->toDateString();

        $memberships = \App\Models\ClientMembership::with(['client', 'membershipPlan'])
            ->where('status', 'activo')
            ->whereDate('end_date', $targetDate)
            ->whereNull('reminder_sent_at')
            ->get();

        $count = 0;
        foreach ($memberships as $membership) {
            if ($membership->client && !empty($membership->client->email)) {
                try {
                    \Illuminate\Support\Facades\Mail::to($membership->client->email)
                        ->send(new \App\Mail\MembershipExpiringSoonMail($membership));

                    $membership->update([
                        'reminder_sent_at' => now(),
                    ]);
                    $count++;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Error al enviar recordatorio de vencimiento al cliente ID {$membership->client->id}: " . $e->getMessage());
                }
            }
        }

        $this->info("Se enviaron {$count} recordatorios de vencimiento correctamente.");
    }
}
