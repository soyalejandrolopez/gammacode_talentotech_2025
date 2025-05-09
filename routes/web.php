<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GuestCheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ProducerChartController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Producer\NotificationController as ProducerNotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/home', function () {
    return redirect('/');
});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{store:slug}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Guest checkout routes
Route::get('/checkout', [GuestCheckoutController::class, 'showCheckoutForm'])->name('checkout.guest');
Route::post('/checkout', [GuestCheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success/{order}', [GuestCheckoutController::class, 'showSuccess'])->name('checkout.success');

// Authentication routes
Auth::routes();

// Customer routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.dashboard');

    // Profile
    Route::get('/profile', function () {
        return view('customer.profile.edit');
    })->name('profile.edit');
    Route::put('/profile', function (Request $request) {
        $request->user()->update($request->only('name', 'email', 'phone', 'address', 'city', 'state'));
        return back()->with('status', 'Perfil actualizado exitosamente.');
    })->name('profile.update');
    Route::put('/password', function (Request $request) {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);
        return back()->with('status', 'Contraseña actualizada exitosamente.');
    })->name('password.update');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Producer routes
Route::middleware(['auth', 'role:producer'])->prefix('producer')->name('producer.')->group(function () {
    Route::get('/dashboard', [ProducerController::class, 'index'])->name('dashboard');

    // Store management
    Route::get('/store/create', [ProducerController::class, 'storeCreate'])->name('store.create');
    Route::post('/store', [ProducerController::class, 'storeStore'])->name('store.store');
    Route::get('/store/edit', [ProducerController::class, 'storeEdit'])->name('store.edit');
    Route::put('/store', [ProducerController::class, 'storeUpdate'])->name('store.update');

    // Product management
    Route::get('/products', [ProductController::class, 'producerIndex'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Order management
    Route::get('/orders', [OrderController::class, 'producerOrders'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'producerOrderShow'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::put('/orders/{order}/items/{item}/status', [OrderController::class, 'updateItemStatus'])->name('orders.update-item-status');

    // Chart APIs
    Route::get('/charts/sales', [ProducerChartController::class, 'salesChart'])->name('charts.sales');
    Route::get('/charts/order-status', [ProducerChartController::class, 'orderStatusChart'])->name('charts.order-status');
    Route::get('/charts/products-by-category', [ProducerChartController::class, 'productsByCategoryChart'])->name('charts.products-by-category');

    // Category management
    Route::post('/categories', [ProductController::class, 'storeCategory'])->name('categories.store');

    // Notifications
    Route::get('/notifications', [ProducerNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [ProducerNotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [ProducerNotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'userCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');

    // Store management
    Route::get('/stores', [AdminController::class, 'stores'])->name('stores.index');
    Route::get('/stores/create', [AdminController::class, 'storeCreate'])->name('stores.create');
    Route::post('/stores', [AdminController::class, 'storeStore'])->name('stores.store');
    Route::get('/stores/{store}', [AdminController::class, 'storeShow'])->name('stores.show');
    Route::get('/stores/{store}/edit', [AdminController::class, 'storeEdit'])->name('stores.edit');
    Route::put('/stores/{store}', [AdminController::class, 'storeUpdate'])->name('stores.update');
    Route::delete('/stores/{store}', [AdminController::class, 'storeDestroy'])->name('stores.destroy');

    // Product management
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::get('/products/{product}', [AdminController::class, 'productShow'])->name('products.show');
    Route::get('/products/{product}/edit', [AdminController::class, 'productEdit'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'productDestroy'])->name('products.destroy');

    // Category management
    Route::post('/categories', [AdminController::class, 'categoryStore'])->name('categories.store');

    // Order management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'orderShow'])->name('orders.show');
    Route::get('/orders/{order}/edit', [AdminController::class, 'orderEdit'])->name('orders.edit');
    Route::put('/orders/{order}', [AdminController::class, 'orderUpdate'])->name('orders.update');
    Route::delete('/orders/{order}', [AdminController::class, 'orderDestroy'])->name('orders.destroy');

    // Settings management
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Reports management
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/annual', [ReportController::class, 'annual'])->name('reports.annual');

    // Notifications
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});
