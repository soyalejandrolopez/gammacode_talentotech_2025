<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     */
    public function index()
    {
        $stores = Store::where('is_active', true)->get();
        return view('stores.index', compact('stores'));
    }

    /**
     * Display the specified store.
     */
    public function show(Store $store)
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
