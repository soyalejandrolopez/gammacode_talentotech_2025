<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:customer']);
    }

    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        $totalOrders = Order::where('user_id', Auth::id())->count();
        $pendingOrders = Order::where('user_id', Auth::id())->where('status', 'pending')->count();
        $completedOrders = Order::where('user_id', Auth::id())->where('status', 'completed')->count();
        
        $cart = session()->get('cart', []);
        $cartCount = count($cart);
        
        $recentOrders = Order::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();
            
        // Get recommended products based on user's order history
        $userOrderedProductIds = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->pluck('product_id')
            ->unique();
            
        // If user has ordered products, get products from the same categories
        if ($userOrderedProductIds->count() > 0) {
            $orderedProducts = Product::whereIn('id', $userOrderedProductIds)->get();
            $categoryIds = $orderedProducts->pluck('category_id')->unique()->filter();
            
            $recommendedProducts = Product::whereIn('category_id', $categoryIds)
                ->where('is_active', true)
                ->whereNotIn('id', $userOrderedProductIds)
                ->inRandomOrder()
                ->take(4)
                ->get();
        } else {
            // If user has no order history, get featured products
            $recommendedProducts = Product::where('is_active', true)
                ->where('is_featured', true)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }
        
        return view('customer.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'cartCount',
            'recentOrders',
            'recommendedProducts'
        ));
    }
}
