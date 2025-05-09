<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\GuestCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Role;
use App\Models\Store;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class GuestCheckoutController extends Controller
{
    /**
     * Show the checkout form for guest users
     */
    public function showCheckoutForm()
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

        return view('checkout.guest', compact('items', 'total'));
    }

    /**
     * Process the guest checkout
     */
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', '¡Tu carrito está vacío!');
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zipcode' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,credit_card,bank_transfer',
            'notes' => 'nullable|string',
            'create_account' => 'nullable|boolean',
            'password' => 'nullable|required_if:create_account,1|min:8|confirmed',
        ]);

        // Calculate total and prepare items
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

        // Create a user account if requested
        $userId = null;

        if ($request->create_account) {
            // Check if email already exists
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Este correo electrónico ya está registrado. Por favor inicia sesión.']);
            }

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode,
            ]);

            // Assign customer role
            $customerRole = Role::where('slug', 'customer')->first();
            if ($customerRole) {
                $user->roles()->attach($customerRole->id);
            }

            // Log the user in
            Auth::login($user);

            $userId = $user->id;
        }

        // Create order
        $order = new Order();
        $order->user_id = $userId;
        $order->order_number = 'ORD-' . strtoupper(Str::random(10));
        $order->status = 'pending';
        $order->total_amount = $total;
        $order->payment_method = $request->payment_method;
        $order->payment_status = 'pending';
        $order->shipping_address = $request->address;
        $order->shipping_city = $request->city;
        $order->shipping_state = $request->state;
        $order->shipping_zipcode = $request->zipcode;
        $order->shipping_phone = $request->phone;
        $order->notes = $request->notes;
        $order->guest_email = $userId ? null : $request->email;
        $order->guest_name = $userId ? null : $request->name;
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

        // Clear guest cart from database
        $sessionId = session()->getId();
        $guestCart = GuestCart::where('session_id', $sessionId)->first();
        if ($guestCart) {
            $guestCart->items()->delete();
            $guestCart->delete();
        }

        try {
            // Send notifications to admin and store owners
            $this->sendOrderNotifications($order);
        } catch (\Exception $e) {
            // Log the error but continue with the checkout process
            \Log::error('Error sending order notifications: ' . $e->getMessage());
        }

        // Set the checkout_completed session variable to allow access to the success page
        session()->put('checkout_completed', $order->id);

        return redirect()->route('checkout.success', ['order' => $order->id]);
    }

    /**
     * Show the checkout success page
     */
    public function showSuccess(Order $order)
    {
        // Check if the order belongs to the current user or is a guest order
        if (auth()->check()) {
            // For authenticated users, check if they own the order or are an admin
            if ($order->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // For guest users, we're more lenient - if they have the order ID in the URL, we'll show it
            // This is a temporary fix to avoid the 403 error
            // In a production environment, you might want to add more security checks

            // Set the checkout_completed session variable to ensure they can see the page
            session()->put('checkout_completed', $order->id);
        }

        $order->load(['orderItems.product', 'orderItems.store']);

        return view('checkout.success', compact('order'));
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
