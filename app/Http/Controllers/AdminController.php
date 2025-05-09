<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Get statistics for dashboard
        $totalUsers = User::count();
        $totalStores = Store::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        // Calculate total revenue
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        // Get new users, stores, products in the last 7 days
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $newStores = Store::where('created_at', '>=', now()->subDays(7))->count();
        $newProducts = Product::where('created_at', '>=', now()->subDays(7))->count();
        $newOrders = Order::where('created_at', '>=', now()->subDays(1))->count();

        // Get active vs inactive stores
        $activeStores = Store::where('is_active', true)->count();
        $inactiveStores = $totalStores - $activeStores;

        // Get active vs inactive products
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = $totalProducts - $activeProducts;

        // Get recent orders with user information
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->take(10)
            ->get();

        // Get top selling products
        $topProducts = Product::withCount(['orderItems as sales_count' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('status', 'completed');
                });
            }])
            ->orderBy('sales_count', 'desc')
            ->take(5)
            ->get();

        // Get top customers
        $topCustomers = User::whereHas('roles', function($q) {
                $q->where('slug', 'customer');
            })
            ->withCount(['orders as orders_count' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['orders as total_spent' => function($query) {
                $query->where('status', 'completed');
            }], 'total_amount')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // No chart data needed anymore

        // Add default values for variables used in the view
        $orderStatusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        // User roles distribution
        $userRoles = [
            'admin' => User::whereHas('roles', function($q) {
                $q->where('slug', 'admin');
            })->count(),
            'producer' => User::whereHas('roles', function($q) {
                $q->where('slug', 'producer');
            })->count(),
            'customer' => User::whereHas('roles', function($q) {
                $q->where('slug', 'customer');
            })->count(),
        ];

        // Monthly orders and revenue data
        $monthlyOrders = [0, 0, 0, 0, 0, 0];
        $monthlyRevenue = [0, 0, 0, 0, 0, 0];
        $monthlyLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');
        }

        // Add other variables that might be needed
        $topProducts = [];
        $categoryLabels = [];
        $categoryData = [];
        $storeLabels = [];
        $storeData = [];
        $storeOrdersData = [];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStores',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'newUsers',
            'newStores',
            'newProducts',
            'newOrders',
            'activeStores',
            'inactiveStores',
            'activeProducts',
            'inactiveProducts',
            'orderStatusCounts',
            'userRoles',
            'monthlyOrders',
            'monthlyRevenue',
            'monthlyLabels',
            'topProducts',
            'categoryLabels',
            'categoryData',
            'storeLabels',
            'storeData',
            'storeOrdersData'
        ));
    }

    /**
     * Show the users list.
     */
    public function users(Request $request)
    {
        $query = User::with('roles');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function userCreate()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,producer,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Assign role
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user.
     */
    public function userShow(User $user)
    {
        // Load relationships
        $user->load(['roles', 'store', 'orders' => function($query) {
            $query->latest()->take(5);
        }]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function userEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,producer,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function userDestroy(User $user)
    {
        // Log para depuración
        \Log::info('Intentando eliminar usuario: ' . $user->id . ' - ' . $user->name);
        \Log::info('Ruta completa: ' . request()->fullUrl());
        \Log::info('Método: ' . request()->method());
        \Log::info('Es solicitud AJAX: ' . (request()->ajax() ? 'Sí' : 'No'));
        \Log::info('Headers: ' . json_encode(request()->headers->all()));

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            \Log::warning('Intento de auto-eliminación: ' . $user->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes borrar tu propio usuario.'
                ], 403);
            }

            session()->flash('error', 'No puedes borrar tu propio usuario.');
            return redirect()->route('admin.users.index');
        }

        try {
            // Verificar si el usuario tiene tiendas
            if ($user->store) {
                \Log::warning('El usuario tiene una tienda asociada: ' . $user->store->name);

                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede borrar el usuario porque tiene una tienda asociada.'
                    ], 403);
                }

                session()->flash('error', 'No se puede borrar el usuario porque tiene una tienda asociada.');
                return redirect()->route('admin.users.index');
            }

            // Verificar si el usuario tiene pedidos
            if ($user->orders && $user->orders->count() > 0) {
                \Log::warning('El usuario tiene pedidos asociados: ' . $user->orders->count());

                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede borrar el usuario porque tiene pedidos asociados.'
                    ], 403);
                }

                session()->flash('error', 'No se puede borrar el usuario porque tiene pedidos asociados.');
                return redirect()->route('admin.users.index');
            }

            // Eliminar roles del usuario
            $user->roles()->detach();

            // Eliminar el usuario
            $user->delete();
            \Log::info('Usuario eliminado exitosamente: ' . $user->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario borrado exitosamente.'
                ]);
            }

            session()->flash('success', 'Usuario borrado exitosamente.');
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar usuario: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al borrar el usuario: ' . $e->getMessage()
                ], 500);
            }

            session()->flash('error', 'Error al borrar el usuario: ' . $e->getMessage());
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Show the stores list.
     */
    public function stores(Request $request)
    {
        $query = Store::with('user');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $stores = $query->paginate(10);
        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store.
     */
    public function storeCreate()
    {
        $users = User::whereHas('roles', function($q) {
            $q->where('slug', 'producer');
        })->get();
        return view('admin.stores.create', compact('users'));
    }

    /**
     * Store a newly created store in storage.
     */
    public function storeStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Debug information
        \Log::info('Store creation request', [
            'has_logo' => $request->hasFile('logo'),
            'has_banner' => $request->hasFile('banner'),
            'all_files' => $request->allFiles(),
            'request_data' => $request->all()
        ]);

        $store = new Store();
        $store->user_id = $request->user_id;
        $store->name = $request->name;
        $store->slug = Str::slug($request->name);
        $store->description = $request->description;
        $store->phone = $request->phone;
        $store->whatsapp = $request->whatsapp;
        $store->email = $request->email;
        $store->address = $request->address;
        $store->is_active = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $store->logo = $logoPath;
            \Log::info('Logo saved', ['path' => $logoPath]);
        } else {
            \Log::info('No logo file detected in request');
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('stores/banners', 'public');
            $store->banner = $bannerPath;
            \Log::info('Banner saved', ['path' => $bannerPath]);
        } else {
            \Log::info('No banner file detected in request');
        }

        $store->save();
        \Log::info('Store saved', ['store_id' => $store->id, 'logo' => $store->logo, 'banner' => $store->banner]);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Tienda creada exitosamente.');
    }

    /**
     * Display the specified store.
     */
    public function storeShow(Store $store)
    {
        // Load relationships
        $store->load(['user', 'products' => function($query) {
            $query->latest()->take(5);
        }]);

        return view('admin.stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified store.
     */
    public function storeEdit(Store $store)
    {
        $users = User::whereHas('roles', function($q) {
            $q->where('slug', 'producer');
        })->get();
        return view('admin.stores.edit', compact('store', 'users'));
    }

    /**
     * Update the specified store in storage.
     */
    public function storeUpdate(Request $request, Store $store)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $store->user_id = $request->user_id;
        $store->name = $request->name;
        $store->slug = Str::slug($request->name);
        $store->description = $request->description;
        $store->phone = $request->phone;
        $store->whatsapp = $request->whatsapp;
        $store->email = $request->email;
        $store->address = $request->address;
        $store->is_active = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $store->logo = $logoPath;
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('stores/banners', 'public');
            $store->banner = $bannerPath;
        }

        $store->save();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Tienda actualizada exitosamente.');
    }

    /**
     * Remove the specified store from storage.
     */
    public function storeDestroy(Store $store)
    {
        // Check if store has products
        if ($store->products()->count() > 0) {
            return redirect()->route('admin.stores.index')
                ->with('error', 'No se puede eliminar la tienda porque tiene productos asociados.');
        }

        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Tienda eliminada exitosamente.');
    }

    /**
     * Show the products list.
     */
    public function products(Request $request)
    {
        $query = Product::with(['store', 'category']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('store', function($storeQuery) use ($search) {
                      $storeQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by store
        if ($request->has('store_id') && $request->store_id) {
            $query->where('store_id', $request->store_id);
        }

        // Filter by status
        if ($request->has('is_active') && $request->is_active != 'all') {
            $query->where('is_active', $request->is_active == '1');
        }

        $products = $query->latest()->paginate(10);

        // Asegurarse de que todos los productos tengan un array de imágenes válido
        foreach ($products as $product) {
            if (!isset($product->images) || !is_array($product->images)) {
                $product->images = [];
            }
        }

        $categories = \App\Models\Category::all();
        $stores = Store::all();

        return view('admin.products.index', compact('products', 'categories', 'stores'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function productCreate()
    {
        $categories = \App\Models\Category::all();
        $stores = Store::where('is_active', true)->get();
        return view('admin.products.create', compact('categories', 'stores'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function productStore(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product = new Product();
        $product->store_id = $request->store_id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->sku = $request->sku;
        $product->is_active = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');

        // Initialize images as an empty array
        $images = [];

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
            $product->images = $images;
        } else {
            // Ensure product->images is an array even if no images are uploaded
            $product->images = $images;
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified product.
     */
    public function productShow(Product $product)
    {
        $product->load(['store', 'category']);

        // Asegurarse de que el producto tenga un array de imágenes válido
        if (!isset($product->images) || !is_array($product->images)) {
            $product->images = [];
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function productEdit(Product $product)
    {
        $categories = \App\Models\Category::all();
        $stores = Store::all();

        // Asegurarse de que el producto tenga un array de imágenes válido
        if (!isset($product->images) || !is_array($product->images)) {
            $product->images = [];
        }

        return view('admin.products.edit', compact('product', 'categories', 'stores'));
    }

    /**
     * Update the specified product in storage.
     */
    public function productUpdate(Request $request, Product $product)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product->store_id = $request->store_id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->sku = $request->sku;
        $product->is_active = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');

        // Ensure product->images is an array
        if (!isset($product->images) || !is_array($product->images)) {
            $product->images = [];
        }

        // Handle images
        if ($request->hasFile('images')) {
            $images = $product->images;
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
            $product->images = $images;
        }

        // Remove images if requested
        if ($request->has('remove_images')) {
            $currentImages = $product->images;
            $imagesToRemove = $request->remove_images;
            $newImages = array_filter($currentImages, function($image) use ($imagesToRemove) {
                return !in_array($image, $imagesToRemove);
            });
            $product->images = array_values($newImages); // Re-index the array
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function productDestroy(Product $product)
    {
        // Check if product has order items
        if ($product->orderItems()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'No se puede eliminar el producto porque tiene pedidos asociados.');
        }

        // Delete product images
        if (!empty($product->images) && is_array($product->images)) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Create a new category via AJAX.
     */
    public function categoryStore(Request $request)
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
     * Show the orders list.
     */
    public function orders(Request $request)
    {
        $query = Order::with('user');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the order details.
     */
    public function orderShow(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'orderItems.store']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function orderEdit(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'orderItems.store']);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function orderUpdate(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'notes' => 'nullable|string',
        ]);

        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->notes = $request->notes;
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function orderDestroy(Order $order)
    {
        // Delete order items first
        $order->orderItems()->delete();

        // Then delete the order
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }
}
