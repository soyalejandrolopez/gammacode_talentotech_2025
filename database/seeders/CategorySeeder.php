<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Verduras',
                'description' => 'Verduras frescas y de temporada',
                'image' => 'categories/vegetables.jpg',
            ],
            [
                'name' => 'Frutas',
                'description' => 'Frutas dulces y nutritivas',
                'image' => 'categories/fruits.jpg',
            ],
            [
                'name' => 'Lácteos',
                'description' => 'Productos lácteos artesanales',
                'image' => 'categories/dairy.jpg',
            ],
            [
                'name' => 'Miel y Derivados',
                'description' => 'Miel pura y productos derivados',
                'image' => 'categories/honey.jpg',
            ],
            [
                'name' => 'Carnes',
                'description' => 'Carnes de animales criados en libertad',
                'image' => 'categories/meat.jpg',
            ],
            [
                'name' => 'Hierbas y Especias',
                'description' => 'Hierbas aromáticas y especias',
                'image' => 'categories/herbs.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
                'is_active' => true,
            ]);
        }
    }
}
