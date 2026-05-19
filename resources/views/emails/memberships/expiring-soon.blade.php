<x-mail::message>
# ¡Hola, {{ $membership->client->name }}!

Queremos recordarte que tu membresía de **{{ $membership->membershipPlan->name }}** está próxima a vencer.

**Detalles de la membresía:**
- **Plan:** {{ $membership->membershipPlan->name }}
- **Fecha de vencimiento:** {{ $membership->end_date->format('d/m/Y') }} (en 3 días)

Te invitamos a renovar tu membresía para seguir disfrutando de nuestras instalaciones sin interrupciones.

<x-mail::button :url="config('app.url')">
Ir a GymControl
</x-mail::button>

Si ya realizaste tu renovación, por favor ignora este correo.

Atentamente,<br>
El equipo de **{{ config('app.name') }}**
</x-mail::message>
