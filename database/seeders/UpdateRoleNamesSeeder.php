<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class UpdateRoleNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Actualizar el rol de Administrador
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->update([
                'name' => 'Administrador',
                'description' => 'El Administrador tiene acceso completo al sistema',
            ]);
            $this->command->info('Rol de Administrador actualizado.');
        }

        // Actualizar el rol de Productor
        $producerRole = Role::where('slug', 'producer')->first();
        if ($producerRole) {
            $producerRole->update([
                'name' => 'Productor',
                'description' => 'El Productor puede gestionar su propia tienda y productos',
            ]);
            $this->command->info('Rol de Productor actualizado.');
        }

        // Actualizar el rol de Cliente
        $customerRole = Role::where('slug', 'customer')->first();
        if ($customerRole) {
            $customerRole->update([
                'name' => 'Cliente',
                'description' => 'El Cliente puede navegar por productos y realizar pedidos',
            ]);
            $this->command->info('Rol de Cliente actualizado.');
        }
    }
}
