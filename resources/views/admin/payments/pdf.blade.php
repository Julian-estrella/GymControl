<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago - {{ $payment->folio }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .header p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .receipt-details {
            width: 100%;
            margin-bottom: 30px;
        }
        .receipt-details td {
            vertical-align: top;
            width: 50%;
        }
        .box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .box-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
            margin-top: 0;
            margin-bottom: 10px;
            font-weight: bold;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .info-row {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 140px;
        }
        .amount-box {
            text-align: center;
            background-color: #4f46e5;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .amount-title {
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .amount-value {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }
        .badge-paid { background-color: #10b981; }
        .badge-pending { background-color: #f59e0b; }
        .badge-cancelled { background-color: #ef4444; }
    </style>
</head>
<body>

    <div class="header">
        <h1>GymControl</h1>
        <p>Comprobante de Pago de Membresía</p>
    </div>

    <table class="receipt-details">
        <tr>
            <td style="padding-right: 10px;">
                <div class="box">
                    <h3 class="box-title">Datos del Pago</h3>
                    <div class="info-row">
                        <span class="info-label">Folio:</span> {{ $payment->folio }}
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha Emisión:</span> {{ $payment->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="info-row">
                        <span class="info-label">Método de Pago:</span> 
                        @switch($payment->payment_method)
                            @case('cash') Efectivo @break
                            @case('card') Tarjeta @break
                            @case('transfer') Transferencia @break
                            @default Otro
                        @endswitch
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado:</span> 
                        @if($payment->status === 'paid')
                            <span class="badge badge-paid">PAGADO</span>
                        @elseif($payment->status === 'pending')
                            <span class="badge badge-pending">PENDIENTE</span>
                        @else
                            <span class="badge badge-cancelled">CANCELADO</span>
                        @endif
                    </div>
                    <div class="info-row">
                        <span class="info-label">Atendido por:</span> {{ $payment->registeredBy->name ?? 'Sistema' }}
                    </div>
                </div>
            </td>
            <td style="padding-left: 10px;">
                <div class="box">
                    <h3 class="box-title">Datos del Cliente</h3>
                    <div class="info-row">
                        <span class="info-label">Nombre:</span> {{ $payment->client->name }}
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span> {{ $payment->client->email ?? 'N/A' }}
                    </div>
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span> {{ $payment->client->phone ?? 'N/A' }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="box">
        <h3 class="box-title">Detalle de Membresía</h3>
        <div class="info-row">
            <span class="info-label">Plan Contratado:</span> {{ $payment->membershipPlan->name }}
        </div>
        
        @if($payment->clientMembership)
        <div class="info-row">
            <span class="info-label">Fecha de Inicio:</span> {{ $payment->clientMembership->start_date->format('d/m/Y') }}
        </div>
        <div class="info-row">
            <span class="info-label">Vencimiento:</span> {{ $payment->clientMembership->end_date->format('d/m/Y') }}
        </div>
        @endif
    </div>

    <div class="amount-box">
        <div class="amount-title">Total Pagado</div>
        <div class="amount-value">${{ number_format($payment->amount, 2) }}</div>
    </div>

    <div class="footer">
        <p>¡Gracias por su preferencia y compromiso con su salud!</p>
        <p>Este documento es un comprobante de pago interno de GymControl y no tiene validez fiscal.</p>
    </div>

</body>
</html>
