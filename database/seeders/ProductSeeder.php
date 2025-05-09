<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::all();
        $categories = Category::all();
        
        $products = [
            // Productos para Finca El Paraíso (Verduras y Frutas)
            [
                'store_index' => 0,
                'category_index' => 0, // Verduras
                'name' => 'Canasta de Verduras Orgánicas',
                'description' => 'Selección de verduras frescas de temporada cultivadas sin pesticidas. Incluye lechuga, tomate, cebolla, zanahoria, pimentón y más.',
                'price' => 25000,
                'stock' => 20,
                'sku' => 'VRD-001',
                'images' => ['products/vegetable-basket-1.jpg', 'products/vegetable-basket-2.jpg'],
                'is_featured' => true,
            ],
            [
                'store_index' => 0,
                'category_index' => 0, // Verduras
                'name' => 'Tomates Orgánicos',
                'description' => 'Tomates cultivados sin pesticidas ni químicos. Dulces, jugosos y llenos de sabor.',
                'price' => 5000,
                'stock' => 50,
                'sku' => 'VRD-002',
                'images' => ['products/tomatoes-1.jpg', 'products/tomatoes-2.jpg'],
                'is_featured' => false,
            ],
            [
                'store_index' => 0,
                'category_index' => 1, // Frutas
                'name' => 'Fresas Frescas',
                'description' => 'Fresas dulces y jugosas recién cosechadas. Perfectas para postres o para comer directamente.',
                'price' => 8000,
                'stock' => 30,
                'sku' => 'FRT-001',
                'images' => ['products/strawberries-1.jpg', 'products/strawberries-2.jpg'],
                'is_featured' => true,
            ],
            
            // Productos para Lácteos La Vaca Feliz
            [
                'store_index' => 1,
                'category_index' => 2, // Lácteos
                'name' => 'Queso Campesino',
                'description' => 'Queso fresco elaborado artesanalmente con leche de vacas alimentadas con pasto. Suave y cremoso.',
                'price' => 12000,
                'stock' => 25,
                'sku' => 'QSO-001',
                'images' => ['products/cheese-1.jpg', 'products/cheese-2.jpg'],
                'is_featured' => true,
            ],
            [
                'store_index' => 1,
                'category_index' => 2, // Lácteos
                'name' => 'Yogurt Natural',
                'description' => 'Yogurt natural sin azúcar añadido. Elaborado con leche fresca y cultivos probióticos.',
                'price' => 7000,
                'stock' => 40,
                'sku' => 'YGT-001',
                'images' => ['products/yogurt-1.jpg', 'products/yogurt-2.jpg'],
                'is_featured' => false,
            ],
            
            // Productos para Miel Pura Cauca
            [
                'store_index' => 2,
                'category_index' => 3, // Miel y Derivados
                'name' => 'Miel Pura de Abeja',
                'description' => 'Miel 100% natural recolectada de colmenas en bosques nativos. Sin aditivos ni conservantes.',
                'price' => 15000,
                'stock' => 35,
                'sku' => 'MIL-001',
                'images' => ['products/honey-1.jpg', 'products/honey-2.jpg'],
                'is_featured' => true,
            ],
            [
                'store_index' => 2,
                'category_index' => 3, // Miel y Derivados
                'name' => 'Polen de Abeja',
                'description' => 'Polen de abeja recolectado por nuestras abejas. Rico en proteínas, vitaminas y minerales.',
                'price' => 18000,
                'stock' => 20,
                'sku' => 'POL-001',
                'images' => ['products/pollen-1.jpg', 'products/pollen-2.jpg'],
                'is_featured' => false,
            ],
            
            // Productos para Carnes El Potrero
            [
                'store_index' => 3,
                'category_index' => 4, // Carnes
                'name' => 'Carne de Res Premium',
                'description' => 'Carne de res de ganado criado en libertad, alimentado con pasto. Sin hormonas ni antibióticos.',
                'price' => 30000,
                'stock' => 15,
                'sku' => 'CRN-001',
                'images' => ['products/beef-1.jpg', 'products/beef-2.jpg'],
                'is_featured' => true,
            ],
            [
                'store_index' => 3,
                'category_index' => 4, // Carnes
                'name' => 'Pollo Campesino',
                'description' => 'Pollo criado en libertad, alimentado naturalmente. Carne firme y sabrosa.',
                'price' => 22000,
                'stock' => 20,
                'sku' => 'POL-001',
                'images' => ['products/chicken-1.jpg', 'products/chicken-2.jpg'],
                'is_featured' => false,
            ],
            
            // Productos para Hierbas del Macizo
            [
                'store_index' => 4,
                'category_index' => 5, // Hierbas y Especias
                'name' => 'Mix de Hierbas Aromáticas',
                'description' => 'Selección de hierbas aromáticas frescas: albahaca, tomillo, romero y orégano.',
                'price' => 10000,
                'stock' => 30,
                'sku' => 'HRB-001',
                'images' => ['products/herbs-1.jpg', 'products/herbs-2.jpg'],
                'is_featured' => true,
            ],
            [
                'store_index' => 4,
                'category_index' => 5, // Hierbas y Especias
                'name' => 'Té de Hierbas Medicinales',
                'description' => 'Mezcla de hierbas medicinales para infusión. Ayuda a la digestión y relajación.',
                'price' => 12000,
                'stock' => 25,
                'sku' => 'TE-001',
                'images' => ['products/tea-1.jpg', 'products/tea-2.jpg'],
                'is_featured' => false,
            ],
        ];
        
        foreach ($products as $productData) {
            Product::create([
                'store_id' => $stores[$productData['store_index']]->id,
                'category_id' => $categories[$productData['category_index']]->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'sku' => $productData['sku'],
                'images' => $productData['images'],
                'is_active' => true,
                'is_featured' => $productData['is_featured'],
            ]);
        }
    }
}
