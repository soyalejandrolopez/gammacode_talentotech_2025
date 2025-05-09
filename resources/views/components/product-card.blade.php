@props(['product'])

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="{{ !empty($product->images) && is_array($product->images) && count($product->images) > 0 ? asset('storage/' . $product->images[0]) : 'https://via.placeholder.com/300x200' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
        <p class="text-gray-600 mb-2">{{ Str::limit($product->description, 100) }}</p>
        <div class="flex justify-between items-center">
            <span class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
            <a href="{{ route('products.show', $product) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                View Details
            </a>
        </div>
        <div class="mt-2">
            <a href="{{ route('stores.show', $product->store) }}" class="text-sm text-gray-600 hover:text-gray-900">
                By: {{ $product->store->name }}
            </a>
            @if($product->store->whatsapp)
                <div class="mt-2">
                    <x-whatsapp-button :whatsapp="$product->store->whatsapp" :message="'Hello, I am interested in your product: ' . $product->name" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm inline-flex items-center">
                        <i class="fab fa-whatsapp mr-1"></i> Contact Seller
                    </x-whatsapp-button>
                </div>
            @endif
        </div>
        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
            </button>
        </form>
    </div>
</div>
