<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($items) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="py-4 px-4 border-b border-gray-200">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        <img class="h-16 w-16 object-cover rounded" src="{{ !empty($item['product']->images) ? asset('storage/' . $item['product']->images[0]) : 'https://via.placeholder.com/150' }}" alt="{{ $item['product']->name }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a href="{{ route('products.show', $item['product']) }}" class="hover:text-blue-500">
                                                                {{ $item['product']->name }}
                                                            </a>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            Seller: {{ $item['product']->store->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                                ${{ number_format($item['product']->price, 2) }}
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200">
                                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <button type="submit" class="ml-2 text-blue-500 hover:text-blue-700">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm text-gray-900">
                                                ${{ number_format($item['product']->price * $item['quantity'], 2) }}
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <i class="fas fa-trash"></i> Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-between items-center">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-trash mr-2"></i> Clear Cart
                                </button>
                            </form>

                            <div class="text-right">
                                <div class="text-lg font-semibold mb-2">
                                    Total: ${{ number_format($total, 2) }}
                                </div>
                                @auth
                                    @if(auth()->user()->hasRole('customer'))
                                        <a href="{{ route('orders.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            <i class="fas fa-shopping-bag mr-2"></i> Finalizar Compra
                                        </a>
                                    @else
                                        <a href="{{ route('checkout.guest') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            <i class="fas fa-shopping-bag mr-2"></i> Finalizar Compra
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('checkout.guest') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-shopping-bag mr-2"></i> Finalizar Compra
                                    </a>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Inicia sesión</a> o continúa como invitado
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-shopping-cart text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">Tu Carrito está Vacío</h3>
                            <p class="text-gray-600 mb-4">Agrega algunos productos a tu carrito y regresa aquí para completar tu compra.</p>
                            <a href="{{ route('products.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-shopping-bag mr-2"></i> Explorar Productos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
