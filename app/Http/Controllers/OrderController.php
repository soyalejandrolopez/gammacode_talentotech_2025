<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', '¡Tu carrito está vacío!');
        }

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

        return view('customer.orders.create', compact('items', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', '¡Tu carrito está vacío!');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zipcode' => 'required|string|max:20',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,credit_card,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        $total = 0;
        $items = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'store_id' => $product->store_id,
                    'price' => $product->price,
                    'total' => $product->price * $details['quantity']
                ];
                $total += $product->price * $details['quantity'];
            }
        }

        if (empty($items)) {
            return redirect()->route('cart.index')
                ->with('error', '¡Tu carrito contiene productos inválidos!');
        }

        // Create order
        $order = new Order();
        $order->user_id = Auth::id();
        $order->order_number = 'ORD-' . strtoupper(Str::random(10));
        $order->status = 'pending';
        $order->total_amount = $total;
        $order->payment_method = $request->payment_method;
        $order->payment_status = 'pending';
        $order->shipping_address = $request->shipping_address;
        $order->shipping_city = $request->shipping_city;
        $order->shipping_state = $request->shipping_state;
        $order->shipping_zipcode = $request->shipping_zipcode;
        $order->shipping_phone = $request->shipping_phone;
        $order->notes = $request->notes;
        $order->save();

        // Create order items
        foreach ($items as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['product']->id;
            $orderItem->store_id = $item['store_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->total = $item['total'];
            $orderItem->status = 'pending';
            $orderItem->save();

            // Update product stock
            $product = $item['product'];
            $product->stock -= $item['quantity'];
            $product->save();
        }

        // Clear cart
        session()->forget('cart');

        try {
            // Send notifications to admin and store owners
            $this->sendOrderNotifications($order);
        } catch (\Exception $e) {
            // Log the error but continue with the order process
            \Log::error('Error sending order notifications: ' . $e->getMessage());
        }

        return redirect()->route('orders.show', $order)
            ->with('success', '¡Pedido realizado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['orderItems.product', 'orderItems.store']);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Display a listing of the producer's orders.
     */
    public function producerOrders()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create')
                ->with('error', '¡Necesitas crear una tienda primero!');
        }

        $orders = Order::whereHas('orderItems', function ($query) use ($store) {
            $query->where('store_id', $store->id);
        })->with('user')->latest()->paginate(10);

        return view('producer.orders.index', compact('orders'));
    }

    /**
     * Display the specified producer's order.
     */
    public function producerOrderShow(Order $order)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('producer.store.create')
                ->with('error', '¡Necesitas crear una tienda primero!');
        }

        $orderItems = $order->orderItems()->where('store_id', $store->id)->get();

        if ($orderItems->isEmpty()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['user', 'orderItems' => function ($query) use ($store) {
            $query->where('store_id', $store->id)->with('product');
        }]);

        return view('producer.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        if (Auth::user()->hasRole('admin')) {
            $request->validate([
                'status' => 'required|in:pending,processing,completed,declined',
                'payment_status' => 'required|in:pending,paid,failed',
            ]);

            $order->status = $request->status;
            $order->payment_status = $request->payment_status;
            $order->save();

            return redirect()->back()->with('success', '¡Estado del pedido actualizado exitosamente!');
        } elseif (Auth::user()->hasRole('producer')) {
            $store = Auth::user()->store;

            if (!$store) {
                return redirect()->route('producer.store.create')
                    ->with('error', '¡Necesitas crear una tienda primero!');
            }

            $orderItems = $order->orderItems()->where('store_id', $store->id)->get();

            if ($orderItems->isEmpty()) {
                abort(403, 'Unauthorized action.');
            }

            $request->validate([
                'status' => 'required|in:pending,processing,completed,declined',
            ]);

            // Only update the status of the order items belonging to this store
            foreach ($orderItems as $item) {
                $item->status = $request->status;
                $item->save();
            }

            return redirect()->back()->with('success', '¡Estado de los productos del pedido actualizado exitosamente!');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Cancel an order (only allowed within 1 hour of creation).
     */
    public function cancel(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the order is in pending status
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Solo se pueden cancelar pedidos pendientes.');
        }

        // Check if the order was created within the last hour
        if ($order->created_at->diffInHours(now()) > 1) {
            return redirect()->back()->with('error', 'Solo se pueden cancelar pedidos dentro de la primera hora después de realizarlos.');
        }

        // Update order status to declined
        $order->status = 'declined';
        $order->save();

        // Restore product stock
        foreach ($order->orderItems as $item) {
            if ($item->product) {
                $item->product->stock += $item->quantity;
                $item->product->save();
            }
        }

        return redirect()->back()->with('success', '¡Pedido cancelado exitosamente!');
    }

    /**
     * Update the status of a specific order item.
     */
    public function updateItemStatus(Request $request, Order $order, OrderItem $item)
    {
        // Check if the user is a producer
        if (Auth::user()->hasRole('producer')) {
            $store = Auth::user()->store;

            if (!$store) {
                return redirect()->route('producer.store.create')
                    ->with('error', '¡Necesitas crear una tienda primero!');
            }

            // Check if the order item belongs to this store
            if ($item->store_id !== $store->id) {
                abort(403, 'Unauthorized action.');
            }

            // Validate the request
            $request->validate([
                'status' => 'required|in:pending,processing,completed,declined',
            ]);

            // Update the status of the order item
            $item->status = $request->status;
            $item->save();

            return redirect()->back()->with('success', '¡Estado del producto actualizado exitosamente!');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Send order notifications to admin and store owners
     */
    private function sendOrderNotifications(Order $order)
    {
        // Load order items with store relationship
        $order->load('orderItems.store.user');

        // Get all admin users
        $admins = User::whereHas('roles', function($query) {
            $query->where('slug', 'admin');
        })->get();

        // Notify admins
        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($order, true));
        }

        // Get unique store owners from the order
        $storeOwners = collect();
        foreach ($order->orderItems as $item) {
            if ($item->store && $item->store->user) {
                $storeOwners->push($item->store->user);
            }
        }

        // Remove duplicates
        $storeOwners = $storeOwners->unique('id');

        // Notify store owners
        foreach ($storeOwners as $owner) {
            $owner->notify(new NewOrderNotification($order, false));
        }
    }
}
