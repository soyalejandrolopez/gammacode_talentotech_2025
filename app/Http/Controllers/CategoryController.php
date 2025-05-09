<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Display products by category.
     */
    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['store', 'category'])
            ->paginate(12);
        
        // Si el usuario está autenticado y es un cliente, usar el layout de cliente
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('customer.products.index', compact('products', 'category'));
        }
        
        // Si no, usar el layout normal para usuarios no autenticados o con otros roles
        return view('products.index', compact('products', 'category'));
    }
}
