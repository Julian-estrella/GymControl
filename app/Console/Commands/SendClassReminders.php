<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendClassReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'classes:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios de clase a los clientes un día antes de que ocurra la clase.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysTranslation = [
            'Monday'    => 'Lunes',
            'Tuesday'   => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday'  => 'Jueves',
            'Friday'    => 'Viernes',
            'Saturday'  => 'Sábado',
            'Sunday'    => 'Domingo',
        ];

        $tomorrow = now()->addDay();
        $tomorrowEnglish = $tomorrow->englishDayOfWeek;
        $tomorrowSpanish = $daysTranslation[$tomorrowEnglish];
        $tomorrowDateString = $tomorrow->toDateString();

        $this->info("Buscando clases programadas para mañana ({$tomorrowSpanish}, {$tomorrowDateString})...");

        $classes = \App\Models\GymClass::where('is_active', true)->with(['trainer', 'clients'])->get();

        $count = 0;

        foreach ($classes as $class) {
            $tomorrowSlot = null;
            if (is_array($class->schedule)) {
                foreach ($class->schedule as $slot) {
                    if (isset($slot['day']) && $slot['day'] === $tomorrowSpanish) {
                        $tomorrowSlot = $slot;
                        break;
                    }
                }
            }

            if (!$tomorrowSlot) {
                continue;
            }

            $classTime = "{$tomorrowSlot['day']} de {$tomorrowSlot['start']} a {$tomorrowSlot['end']}";

            foreach ($class->clients as $client) {
                $lastSent = $client->pivot->last_reminder_sent_date;

                if ($lastSent && $lastSent === $tomorrowDateString) {
                    continue;
                }

                if (!empty($client->email)) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($client->email)
                            ->send(new \App\Mail\ClassReminderMail($class, $client, $classTime));

                        $class->clients()->updateExistingPivot($client->id, [
                            'last_reminder_sent_date' => $tomorrowDateString,
                        ]);

                        $count++;
                        $this->info("Recordatorio enviado al cliente {$client->name} para la clase {$class->name}.");
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Error al enviar recordatorio de clase al cliente ID {$client->id}: " . $e->getMessage());
                    }
                }
            }
        }

        $this->info("Se enviaron {$count} recordatorios de clases correctamente.");
    }
}
