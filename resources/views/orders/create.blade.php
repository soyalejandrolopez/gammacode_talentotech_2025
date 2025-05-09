<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Checkout</h3>
                    
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        <div class="md:w-1/2">
                            <h4 class="text-lg font-semibold mb-4">Order Summary</h4>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                                <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td class="py-3 px-4 text-sm">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 object-cover rounded" src="{{ !empty($item['product']->images) ? asset('storage/' . $item['product']->images[0]) : 'https://via.placeholder.com/150' }}" alt="{{ $item['product']->name }}">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">{{ $item['product']->name }}</div>
                                                                <div class="text-sm text-gray-500">{{ $item['product']->store->name }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 text-sm text-gray-900">${{ number_format($item['product']->price, 2) }}</td>
                                                    <td class="py-3 px-4 text-sm text-gray-900">{{ $item['quantity'] }}</td>
                                                    <td class="py-3 px-4 text-sm text-gray-900">${{ number_format($item['product']->price * $item['quantity'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="py-3 px-4 text-right font-semibold">Total:</td>
                                                <td class="py-3 px-4 text-lg font-bold text-gray-900">${{ number_format($total, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:w-1/2">
                            <h4 class="text-lg font-semibold mb-4">Shipping & Payment Information</h4>
                            
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address', auth()->user()->address) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    </div>
                                    <div>
                                        <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                        <input type="text" name="shipping_state" id="shipping_state" value="{{ old('shipping_state') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="shipping_zipcode" class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                                        <input type="text" name="shipping_zipcode" id="shipping_zipcode" value="{{ old('shipping_zipcode') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    </div>
                                    <div>
                                        <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                        <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="cash">Cash on Delivery</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                                    <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('cart.index') }}" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-arrow-left mr-1"></i> Back to Cart
                                    </a>
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-check mr-2"></i> Place Order
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
