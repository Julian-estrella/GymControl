<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago - GymControl</title>
</head>
<body style="font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; color: #1f2937; margin: 0; padding: 40px 20px; line-height: 1.6;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden;">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); padding: 30px 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">GymControl</h1>
            <p style="color: #e0e7ff; margin: 8px 0 0 0; font-size: 16px;">Comprobante de Pago de Membresía</p>
        </div>

        <!-- Body Content -->
        <div style="padding: 40px 30px;">
            <h2 style="margin: 0 0 20px 0; color: #111827; font-size: 22px; font-weight: 600;">¡Hola, {{ $payment->client->name }}!</h2>
            
            <p style="margin: 0 0 25px 0; color: #4b5563; font-size: 16px;">
                Queremos confirmarte que hemos registrado exitosamente tu pago en nuestro sistema. Agradecemos mucho tu puntualidad y tu compromiso continuo con tu entrenamiento y bienestar.
            </p>

            <!-- Summary Box -->
            <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px; margin-bottom: 30px;">
                <h3 style="margin: 0 0 16px 0; color: #374151; font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">Resumen del Pago</h3>
                
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 15px; font-weight: 500;">Folio:</td>
                        <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 600; text-align: right;">{{ $payment->folio }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 15px; font-weight: 500;">Plan Contratado:</td>
                        <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 600; text-align: right;">{{ $payment->membershipPlan->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 15px; font-weight: 500;">Monto Pagado:</td>
                        <td style="padding: 8px 0; color: #4f46e5; font-size: 18px; font-weight: 700; text-align: right;">${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 15px; font-weight: 500;">Fecha de Pago:</td>
                        <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 600; text-align: right;">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <p style="margin: 0 0 30px 0; color: #4b5563; font-size: 16px;">
                Hemos adjuntado a este correo tu comprobante oficial en formato PDF para tus registros personales.
            </p>

            <div style="text-align: center; margin: 40px 0 20px 0;">
                <p style="margin: 0; color: #111827; font-size: 18px; font-weight: 600;">¡Sigue esforzándote al máximo!</p>
                <p style="margin: 4px 0 0 0; color: #6b7280; font-size: 15px;">El equipo de GymControl</p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px; text-align: center;">
            <p style="margin: 0; color: #9ca3af; font-size: 13px;">
                Este es un mensaje automatizado enviado por GymControl. Por favor, no respondas a este correo.
            </p>
            <p style="margin: 8px 0 0 0; color: #9ca3af; font-size: 13px;">
                &copy; {{ date('Y') }} GymControl. Todos los derechos reservados.
            </p>
        </div>

    </div>

</body>
</html>
