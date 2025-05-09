<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'name' => 'Finca El Paraíso',
                'description' => 'Somos una finca familiar dedicada al cultivo de frutas y verduras orgánicas. Nuestros productos son cultivados sin pesticidas ni químicos, respetando el medio ambiente.',
                'logo' => 'stores/logos/finca-paraiso.jpg',
                'banner' => 'stores/banners/finca-paraiso-banner.jpg',
                'phone' => '3101234567',
                'whatsapp' => '573101234567',
                'email' => 'contacto@fincaelparaiso.com',
                'address' => 'Vereda La Esperanza, Popayán, Cauca',
            ],
            [
                'name' => 'Lácteos La Vaca Feliz',
                'description' => 'Producimos lácteos artesanales de la más alta calidad. Nuestras vacas son alimentadas con pasto natural y tratadas con respeto y cariño.',
                'logo' => 'stores/logos/lacteos-vaca-feliz.jpg',
                'banner' => 'stores/banners/lacteos-vaca-feliz-banner.jpg',
                'phone' => '3157654321',
                'whatsapp' => '573157654321',
                'email' => 'info@lavacafeliz.com',
                'address' => 'Km 5 vía Popayán - Timbío, Cauca',
            ],
            [
                'name' => 'Miel Pura Cauca',
                'description' => 'Producimos miel 100% pura y natural. Nuestras abejas polinizan en bosques nativos libres de contaminación.',
                'logo' => 'stores/logos/miel-pura-cauca.jpg',
                'banner' => 'stores/banners/miel-pura-cauca-banner.jpg',
                'phone' => '3209876543',
                'whatsapp' => '573209876543',
                'email' => 'contacto@mielpuracauca.com',
                'address' => 'Vereda El Rosal, Cajibío, Cauca',
            ],
            [
                'name' => 'Carnes El Potrero',
                'description' => 'Ofrecemos carnes de res, cerdo y pollo de animales criados en libertad, alimentados naturalmente y sin hormonas.',
                'logo' => 'stores/logos/carnes-potrero.jpg',
                'banner' => 'stores/banners/carnes-potrero-banner.jpg',
                'phone' => '3183456789',
                'whatsapp' => '573183456789',
                'email' => 'ventas@carneselpotrero.com',
                'address' => 'Vereda San Antonio, Popayán, Cauca',
            ],
            [
                'name' => 'Hierbas del Macizo',
                'description' => 'Cultivamos hierbas aromáticas y medicinales en las faldas del Macizo Colombiano, aprovechando su clima y suelos excepcionales.',
                'logo' => 'stores/logos/hierbas-macizo.jpg',
                'banner' => 'stores/banners/hierbas-macizo-banner.jpg',
                'phone' => '3167890123',
                'whatsapp' => '573167890123',
                'email' => 'info@hierbasdelmacizocom',
                'address' => 'Vereda Alto de las Hierbas, San Sebastián, Cauca',
            ],
        ];

        $producerRole = Role::where('slug', 'producer')->first();

        foreach ($stores as $index => $storeData) {
            // Create producer user
            $user = User::create([
                'name' => 'Productor ' . ($index + 1),
                'email' => 'productor' . ($index + 1) . '@example.com',
                'password' => bcrypt('password'),
                'phone' => $storeData['phone'],
                'address' => $storeData['address'],
            ]);
            
            // Assign producer role
            $user->roles()->attach($producerRole);
            
            // Create store
            Store::create([
                'user_id' => $user->id,
                'name' => $storeData['name'],
                'slug' => Str::slug($storeData['name']),
                'description' => $storeData['description'],
                'logo' => $storeData['logo'],
                'banner' => $storeData['banner'],
                'phone' => $storeData['phone'],
                'whatsapp' => $storeData['whatsapp'],
                'email' => $storeData['email'],
                'address' => $storeData['address'],
                'is_active' => true,
            ]);
        }
    }
}
