<x-mail::message>
# ¡Hola, {{ $client->name }}!

Te escribimos para recordarte que **mañana** tienes una clase programada en **{{ config('app.name') }}**.

**Detalles de la Clase:**
- **Clase:** {{ $gymClass->name }}
- **Entrenador:** {{ $gymClass->trainer ? $gymClass->trainer->name : 'Sin asignar' }}
- **Horario:** {{ $classTime }}

¡Prepárate y no faltes! Te esperamos para dar el máximo en tu entrenamiento.

<x-mail::button :url="config('app.url')">
Ver mis Clases
</x-mail::button>

Atentamente,<br>
El equipo de **{{ config('app.name') }}**
</x-mail::message>
