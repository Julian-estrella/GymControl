<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientMembership;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class ClientMembershipController extends Controller
{
    public function create(Client $client)
    {
        $plans = MembershipPlan::where('is_active', true)->orderBy('name')->get();
        return view('admin.client-memberships.create', compact('client', 'plans'));
    }

    public function store(Request $request, Client $client)
    {
        $data = $request->validate([
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after:start_date',
            'notes'              => 'nullable|string',
        ]);

        $data['client_id'] = $client->id;
        $data['status']    = 'activo';

        // Mark previous active memberships as vencido
        $client->clientMemberships()
            ->where('status', 'activo')
            ->update(['status' => 'vencido']);

        ClientMembership::create($data);

        // Update client membership_status
        $client->update(['membership_status' => 'activo']);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Membresía asignada',
            'text'  => 'La membresía ha sido asignada al cliente correctamente.',
        ]);

        return redirect()->route('admin.clients.show', $client->id);
    }

    public function destroy(ClientMembership $clientMembership)
    {
        $client = $clientMembership->client;
        $clientMembership->update(['status' => 'cancelado']);

        // If no active membership remains, update client status
        if (!$client->clientMemberships()->where('status', 'activo')->exists()) {
            $client->update(['membership_status' => 'sin_membresia']);
        }

        session()->flash('swal', [
            'icon'  => 'warning',
            'title' => 'Membresía cancelada',
            'text'  => 'La membresía ha sido cancelada.',
        ]);

        return redirect()->route('admin.clients.show', $client->id);
    }
}
