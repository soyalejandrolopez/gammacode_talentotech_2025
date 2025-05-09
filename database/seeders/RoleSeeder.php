<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrador',
                'slug' => 'admin',
                'description' => 'El Administrador tiene acceso completo al sistema',
            ],
            [
                'name' => 'Productor',
                'slug' => 'producer',
                'description' => 'El Productor puede gestionar su propia tienda y productos',
            ],
            [
                'name' => 'Cliente',
                'slug' => 'customer',
                'description' => 'El Cliente puede navegar por productos y realizar pedidos',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
