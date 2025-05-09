<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
        ]);

        // Create admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach(\App\Models\Role::where('slug', 'admin')->first());

        // Create customer user
        $customer = \App\Models\User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'phone' => '0987654321',
            'address' => 'Customer Address',
        ]);
        $customer->roles()->attach(\App\Models\Role::where('slug', 'customer')->first());
    }
}
