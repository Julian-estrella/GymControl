<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\MembershipPlan;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['client', 'membershipPlan', 'registeredBy'])->orderByDesc('created_at');

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $payments = $query->paginate(15);
        $clients = Client::orderBy('name')->get();

        return view('admin.payments.index', compact('payments', 'clients'));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $plans = MembershipPlan::where('is_active', true)->orderBy('name')->get();
        
        $selectedClient = $request->has('client_id') ? Client::find($request->client_id) : null;
        
        return view('admin.payments.create', compact('clients', 'plans', 'selectedClient'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer,other',
            'status' => 'required|in:paid,pending,cancelled',
            'notes' => 'nullable|string',
        ]);

        $data['registered_by'] = auth()->id();
        
        // Find active membership if exists to link it, though optional based on current flow
        $client = Client::find($data['client_id']);
        $activeMembership = $client->clientMemberships()
            ->where('membership_plan_id', $data['membership_plan_id'])
            ->where('status', 'activo')
            ->latest()
            ->first();

        if ($activeMembership) {
            $data['client_membership_id'] = $activeMembership->id;
        }

        $payment = Payment::create($data);

        // Enviar comprobante por correo electrónico al cliente (o al correo de pruebas si no tiene uno registrado)
        try {
            $payment->load(['client', 'membershipPlan']);
            $recipientEmail = !empty($payment->client->email) ? $payment->client->email : 'julianstarbe@gmail.com';
            
            \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(new \App\Mail\PaymentReceiptMail($payment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al enviar correo de recibo de pago: ' . $e->getMessage());
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Pago registrado',
            'text' => 'El pago ha sido registrado exitosamente.'
        ]);

        return redirect()->route('admin.payments.index');
    }

    public function show(Payment $payment)
    {
        $payment->load(['client', 'clientMembership', 'membershipPlan', 'registeredBy']);
        return view('admin.payments.show', compact('payment'));
    }

    public function cancel(Payment $payment)
    {
        $payment->update(['status' => 'cancelled']);

        session()->flash('swal', [
            'icon' => 'warning',
            'title' => 'Pago cancelado',
            'text' => 'El pago ha sido marcado como cancelado.'
        ]);

        return back();
    }

    public function downloadPdf(Payment $payment)
    {
        // Require barryvdh/laravel-dompdf to be fully installed.
        // If not installed, it will throw an error, which we handle or just let it crash since user knows.
        if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error de PDF',
                'text' => 'El paquete dompdf no está instalado.'
            ]);
            return back();
        }

        $payment->load(['client', 'clientMembership', 'membershipPlan', 'registeredBy']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.payments.pdf', compact('payment'));
        
        return $pdf->download('comprobante-pago-' . $payment->folio . '.pdf');
    }
}
