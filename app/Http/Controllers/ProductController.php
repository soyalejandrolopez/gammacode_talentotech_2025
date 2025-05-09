<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:producer'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['store', 'category'])
            ->where('is_active', true)
            ->paginate(12);

        // Asegurarse de que todos los productos tengan un array de imágenes válido
        foreach ($products as $product) {
            if (!isset($product->images) || !is_array($product->images)) {
                $product->images = [];
            }
        }

        // Si el usuario está autenticado y es un cliente, usar el layout de cliente
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('customer.products.index', compact('products'));
        }

        // Si no, usar el layout normal
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create')
                ->with('error', '¡Necesitas crear una tienda primero!');
        }

        $categories = Category::where('is_active', true)->get();

        return view('producer.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create')
                ->with('error', '¡Necesitas crear una tienda primero!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product = new Product();
        $product->store_id = $store->id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->slug = $this->generateUniqueSlug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->sku = $request->sku;
        $product->is_active = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }
        $product->images = $images;

        $product->save();

        return redirect()->route('producer.products.index')
            ->with('success', '¡Producto creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['store', 'category']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Asegurarse de que el producto tenga un array de imágenes válido
        if (!isset($product->images) || !is_array($product->images)) {
            $product->images = [];
        }

        // Asegurarse de que todos los productos relacionados tengan un array de imágenes válido
        foreach ($relatedProducts as $relatedProduct) {
            if (!isset($relatedProduct->images) || !is_array($relatedProduct->images)) {
                $relatedProduct->images = [];
            }
        }

        // Si el usuario está autenticado y es un cliente, usar el layout de cliente
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('customer.products.show', compact('product', 'relatedProducts'));
        }

        // Si no, usar el layout normal
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $store = Auth::user()->store;

        if (!$store || $product->store_id !== $store->id) {
            return redirect()->route('producer.products.index')
                ->with('error', '¡No estás autorizado para editar este producto!');
        }

        $categories = Category::where('is_active', true)->get();

        return view('producer.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $store = Auth::user()->store;

        if (!$store || $product->store_id !== $store->id) {
            return redirect()->route('producer.products.index')
                ->with('error', '¡No estás autorizado para editar este producto!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product->category_id = $request->category_id;
        $product->name = $request->name;

        // Solo generar un nuevo slug si el nombre ha cambiado
        if ($product->isDirty('name')) {
            $product->slug = $this->generateUniqueSlug($request->name, $product->id);
        }

        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->sku = $request->sku;
        $product->is_active = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');

        if ($request->hasFile('images')) {
            // Remove old images
            if (!empty($product->images)) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Upload new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
            $product->images = $images;
        }

        $product->save();

        return redirect()->route('producer.products.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $store = Auth::user()->store;

        if (!$store || $product->store_id !== $store->id) {
            return redirect()->route('producer.products.index')
                ->with('error', '¡No estás autorizado para eliminar este producto!');
        }

        // Remove images
        if (!empty($product->images)) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('producer.products.index')
            ->with('success', '¡Producto eliminado exitosamente!');
    }

    /**
     * Display a listing of the producer's products.
     */
    public function producerIndex()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create')
                ->with('error', '¡Necesitas crear una tienda primero!');
        }

        $products = Product::where('store_id', $store->id)
            ->with('category')
            ->paginate(10);

        // Asegurarse de que todos los productos tengan un array de imágenes válido
        foreach ($products as $product) {
            if (!isset($product->images) || !is_array($product->images)) {
                $product->images = [];
            }
        }

        return view('producer.products.index', compact('products'));
    }

    /**
     * Store a new category via AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->is_active = true;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Categoría creada exitosamente',
            'category' => [
                'id' => $category->id,
                'name' => $category->name
            ]
        ]);
    }

    /**
     * Generate a unique slug for a product.
     *
     * @param string $name
     * @param int|null $exceptId
     * @return string
     */
    protected function generateUniqueSlug($name, $exceptId = null)
    {
        $originalSlug = Str::slug($name);
        $slug = $originalSlug;
        $count = 1;

        // Construir la consulta para verificar si el slug ya existe
        $query = Product::where('slug', $slug);

        // Excluir el producto actual si estamos actualizando
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        // Si el slug ya existe, añadir un número incremental hasta que sea único
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count++;
            $query = Product::where('slug', $slug);

            if ($exceptId) {
                $query->where('id', '!=', $exceptId);
            }
        }

        return $slug;
    }

    /**
     * Display products by category.
     */
    public function byCategory(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['store', 'category'])
            ->paginate(12);

        // Si el usuario está autenticado y es un cliente, usar el layout de cliente
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('customer.products.index', compact('products', 'category'));
        }

        // Si no, usar el layout normal
        return view('products.index', compact('products', 'category'));
    }

    /**
     * Display products by store.
     */
    public function storeProducts(Store $store)
    {
        // Cargar los productos activos de la tienda
        $store->load(['products' => function($query) {
            $query->where('is_active', true)
                  ->with('category');
        }]);

        // Si el usuario está autenticado y es un cliente, usar el layout de cliente
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('customer.stores.show', compact('store'));
        }

        // Si no, usar el layout normal para usuarios no autenticados o con otros roles
        return view('stores.show', compact('store'));
    }
}
