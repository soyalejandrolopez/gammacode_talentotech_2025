<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Order #{{ $order->order_number }}</h3>
                            <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-gray-700 font-medium mr-2">Status:</span>
                                @if($order->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Pending</span>
                                @elseif($order->status == 'processing')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Processing</span>
                                @elseif($order->status == 'completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Completed</span>
                                @elseif($order->status == 'declined')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Declined</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-700 font-medium mr-2">Payment:</span>
                                @if($order->payment_status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Pending</span>
                                @elseif($order->payment_status == 'paid')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Paid</span>
                                @elseif($order->payment_status == 'failed')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Failed</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h4 class="text-lg font-semibold mb-3">Customer Information</h4>
                        <p class="mb-1"><span class="font-medium">Name:</span> {{ $order->user->name }}</p>
                        <p class="mb-1"><span class="font-medium">Email:</span> {{ $order->user->email }}</p>
                        @if($order->user->phone)
                            <p class="mb-1"><span class="font-medium">Phone:</span> {{ $order->user->phone }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h4 class="text-lg font-semibold mb-3">Shipping Information</h4>
                        <p class="mb-1"><span class="font-medium">Address:</span> {{ $order->shipping_address }}</p>
                        <p class="mb-1"><span class="font-medium">City:</span> {{ $order->shipping_city }}</p>
                        <p class="mb-1"><span class="font-medium">State:</span> {{ $order->shipping_state }}</p>
                        <p class="mb-1"><span class="font-medium">Zip Code:</span> {{ $order->shipping_zipcode }}</p>
                        <p class="mb-1"><span class="font-medium">Phone:</span> {{ $order->shipping_phone }}</p>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h4 class="text-lg font-semibold mb-3">Payment Information</h4>
                        <p class="mb-1"><span class="font-medium">Method:</span> 
                            @if($order->payment_method == 'cash')
                                Cash on Delivery
                            @elseif($order->payment_method == 'credit_card')
                                Credit Card
                            @elseif($order->payment_method == 'bank_transfer')
                                Bank Transfer
                            @endif
                        </p>
                        <p class="mb-1"><span class="font-medium">Status:</span> {{ ucfirst($order->payment_status) }}</p>
                        <p class="mb-1"><span class="font-medium">Total:</span> ${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h4 class="text-lg font-semibold mb-4">Order Items</h4>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 object-cover rounded" src="{{ !empty($item->product->images) ? asset('storage/' . $item->product->images[0]) : 'https://via.placeholder.com/150' }}" alt="{{ $item->product->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                            {{ $item->store->name }}
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                            ${{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                            ${{ number_format($item->total, 2) }}
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                            @if($item->store->whatsapp)
                                                <x-whatsapp-button :whatsapp="$item->store->whatsapp" :message="'Hello, I would like to inquire about my order #' . $order->order_number . ' for the product: ' . $item->product->name" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs inline-flex items-center">
                                                    <i class="fab fa-whatsapp mr-1"></i> Contact
                                                </x-whatsapp-button>
                                            @else
                                                <span class="text-gray-500">No contact</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="py-4 px-4 text-right font-semibold">Total:</td>
                                    <td colspan="2" class="py-4 px-4 text-lg font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    @if($order->notes)
                        <div class="mt-6">
                            <h5 class="font-semibold mb-2">Order Notes:</h5>
                            <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $order->notes }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('orders.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
