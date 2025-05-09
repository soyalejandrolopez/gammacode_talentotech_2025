<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProducerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:producer']);
    }

    /**
     * Show the producer dashboard.
     */
    public function index()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create');
        }

        $totalProducts = Product::where('store_id', $store->id)->count();
        $totalOrders = OrderItem::where('store_id', $store->id)->distinct('order_id')->count();
        $recentOrders = Order::whereHas('orderItems', function ($query) use ($store) {
            $query->where('store_id', $store->id);
        })->with(['user', 'orderItems.product', 'orderItems.store'])->latest()->take(5)->get();

        return view('producer.dashboard', compact(
            'store',
            'totalProducts',
            'totalOrders',
            'recentOrders'
        ));
    }

    /**
     * Show the store creation form.
     */
    public function storeCreate()
    {
        if (Auth::user()->store) {
            return redirect()->route('producer.dashboard');
        }

        return view('producer.store.create');
    }

    /**
     * Store a newly created store.
     */
    public function storeStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $store = new Store();
        $store->user_id = Auth::id();
        $store->name = $request->name;
        $store->slug = \Str::slug($request->name);
        $store->description = $request->description;
        $store->phone = $request->phone;
        $store->whatsapp = $request->whatsapp;
        $store->email = $request->email;
        $store->address = $request->address;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $store->logo = $logoPath;
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('stores/banners', 'public');
            $store->banner = $bannerPath;
        }

        $store->save();

        return redirect()->route('producer.dashboard')->with('success', '¡Tienda creada exitosamente!');
    }

    /**
     * Show the store edit form.
     */
    public function storeEdit()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create');
        }

        return view('producer.store.edit', compact('store'));
    }

    /**
     * Update the store.
     */
    public function storeUpdate(Request $request)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $store->name = $request->name;
        $store->slug = \Str::slug($request->name);
        $store->description = $request->description;
        $store->phone = $request->phone;
        $store->whatsapp = $request->whatsapp;
        $store->email = $request->email;
        $store->address = $request->address;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $store->logo = $logoPath;
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('stores/banners', 'public');
            $store->banner = $bannerPath;
        }

        $store->save();

        return redirect()->route('producer.dashboard')->with('success', '¡Tienda actualizada exitosamente!');
    }
}
