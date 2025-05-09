<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\GuestCart;
use App\Models\GuestCartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // No middleware required - cart is accessible to all users
    }

    /**
     * Get or create a guest cart for the current session
     */
    private function getGuestCart()
    {
        $sessionId = session()->getId();

        $guestCart = GuestCart::where('session_id', $sessionId)->first();

        if (!$guestCart) {
            $guestCart = GuestCart::create([
                'session_id' => $sessionId
            ]);
        }

        return $guestCart;
    }

    /**
     * Sync the session cart with the guest cart in the database
     */
    private function syncSessionCartToDatabase()
    {
        $sessionCart = session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        $guestCart = $this->getGuestCart();

        // Clear existing items
        $guestCart->items()->delete();

        // Add items from session
        foreach ($sessionCart as $productId => $details) {
            $product = Product::find($productId);
            if ($product) {
                $guestCart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $details['quantity']
                ]);
            }
        }
    }

    /**
     * Display the cart.
     */
    public function index()
    {
        // Sync session cart to database for guests
        if (!auth()->check()) {
            $this->syncSessionCartToDatabase();
        }

        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $details['quantity']
                ];
                $total += $product->price * $details['quantity'];
            }
        }

        // Si el usuario está autenticado y es un cliente, usar el layout de cliente
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('customer.cart.index', compact('items', 'total'));
        }

        // Si no, usar el layout normal
        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->product_id] = [
                'quantity' => $request->quantity
            ];
        }

        session()->put('cart', $cart);

        // Sync to database for guest users
        if (!auth()->check()) {
            $this->syncSessionCartToDatabase();
        }

        return redirect()->back()->with('success', '¡Producto agregado al carrito exitosamente!');
    }

    /**
     * Update the cart.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            // Sync to database for guest users
            if (!auth()->check()) {
                $this->syncSessionCartToDatabase();
            }
        }

        return redirect()->back()->with('success', '¡Carrito actualizado exitosamente!');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);

            // Sync to database for guest users
            if (!auth()->check()) {
                $this->syncSessionCartToDatabase();
            }
        }

        return redirect()->back()->with('success', '¡Producto eliminado del carrito exitosamente!');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        session()->forget('cart');

        // Clear database cart for guest users
        if (!auth()->check()) {
            $guestCart = $this->getGuestCart();
            $guestCart->items()->delete();
        }

        return redirect()->back()->with('success', '¡Carrito vaciado exitosamente!');
    }

    /**
     * Transfer guest cart to user account after login
     */
    public function transferGuestCart()
    {
        if (!auth()->check() || !auth()->user()->hasRole('customer')) {
            return;
        }

        $sessionId = session()->getId();
        $guestCart = GuestCart::where('session_id', $sessionId)->first();

        if (!$guestCart || $guestCart->items->isEmpty()) {
            return;
        }

        $cart = session()->get('cart', []);

        foreach ($guestCart->items as $item) {
            $productId = $item->product_id;

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $item->quantity;
            } else {
                $cart[$productId] = [
                    'quantity' => $item->quantity
                ];
            }
        }

        session()->put('cart', $cart);

        // Clear the guest cart
        $guestCart->items()->delete();
        $guestCart->delete();
    }
}
