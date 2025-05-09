<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['store', 'category', 'search']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Redirect all users to the root path
        return redirect('/');
    }

    /**
     * Display the specified store.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function store(Store $store)
    {
        $store->load(['products' => function($query) {
            $query->where('is_active', true)
                  ->latest()
                  ->take(12);
        }]);

        // Asegurarse de que todos los productos tengan un array de imágenes válido
        foreach ($store->products as $product) {
            if (!isset($product->images) || !is_array($product->images)) {
                $product->images = [];
            }
        }

        return view('stores.show', compact('store'));
    }

    /**
     * Display products by category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['store', 'category'])
            ->paginate(12);

        // Asegurarse de que todos los productos tengan un array de imágenes válido
        foreach ($products as $product) {
            if (!isset($product->images) || !is_array($product->images)) {
                $product->images = [];
            }
        }

        return view('categories.show', compact('category', 'products'));
    }

    /**
     * Search for products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('store', function($storeQuery) use ($query) {
                      $storeQuery->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('category', function($categoryQuery) use ($query) {
                      $categoryQuery->where('name', 'like', "%{$query}%");
                  });
            })
            ->with(['store', 'category'])
            ->paginate(12);

        // Asegurarse de que todos los productos tengan un array de imágenes válido
        foreach ($products as $product) {
            if (!isset($product->images) || !is_array($product->images)) {
                $product->images = [];
            }
        }

        return view('search', compact('products', 'query'));
    }
}
