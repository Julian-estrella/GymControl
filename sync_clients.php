<?php
// Sync script to link existing clients and users
use App\Models\User;
use App\Models\Client;

User::where('role', 'cliente')->each(function($user) {
    if (!$user->client) {
        $client = Client::where('email', $user->email)->first();
        if ($client) {
            $client->updateQuietly(['user_id' => $user->id]);
        } else {
            Client::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'membership_status' => 'sin_membresia'
            ]);
        }
    }
});

Client::whereNull('user_id')->whereNotNull('email')->each(function($client) {
    $user = User::where('email', $client->email)->first();
    if (!$user) {
        $user = User::create([
            'name' => $client->name,
            'email' => $client->email,
            'phone' => $client->phone,
            'password' => bcrypt('password'),
            'role' => 'cliente',
            'is_active' => true
        ]);
    }
    $client->updateQuietly(['user_id' => $user->id]);
});
echo "Sync completed!\n";
