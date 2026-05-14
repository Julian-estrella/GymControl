<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates the default admin account and a test member for GymControl.
     */
    public function run(): void
    {
        // ── 1. Administrador ───────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@gymcontrol.com'],
            [
                'name'     => 'Admin GymControl',
                'email'    => 'admin@gymcontrol.com',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_ADMIN,
                'phone'    => '1234567890',
            ]
        );

        // ── 2. Staff (Operador) ────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'staff@gymcontrol.com'],
            [
                'name'     => 'Staff Operativo',
                'email'    => 'staff@gymcontrol.com',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_STAFF,
                'phone'    => '0987654321',
            ]
        );

        // ── 3. Cliente (Miembro) ───────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'cliente@gymcontrol.com'],
            [
                'name'     => 'Juan Pérez (Cliente)',
                'email'    => 'cliente@gymcontrol.com',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_CLIENTE,
                'phone'    => '555666777',
            ]
        );

        $this->command->info('✅ Usuarios de GymControl creados:');
        $this->command->table(
            ['Rol', 'Email', 'Contraseña'],
            [
                ['Admin',   'admin@gymcontrol.com',   'password'],
                ['Staff',   'staff@gymcontrol.com',   'password'],
                ['Cliente', 'cliente@gymcontrol.com', 'password'],
            ]
        );
    }
}
