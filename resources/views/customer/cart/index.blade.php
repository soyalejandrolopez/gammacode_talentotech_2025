@extends('layouts.customer')

@section('title', 'Mi Carrito')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-cart" style="color: var(--blue);"></i> Mi Carrito de Compras
                    </h5>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> Agregar Más Productos
                    </a>
                </div>
                <div class="modern-card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(count($items) > 0)
                        <div class="table-responsive mb-4">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;"></th>
                                        <th>Producto</th>
                                        <th>Tienda</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                @if($item['product']->first_image)
                                                    <img src="{{ asset('storage/' . $item['product']->first_image) }}" alt="{{ $item['product']->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.show', $item['product']->slug) }}" class="text-decoration-none">
                                                    {{ $item['product']->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('stores.show', $item['product']->store->slug) }}" class="text-decoration-none">
                                                    {{ $item['product']->store->name }}
                                                </a>
                                            </td>
                                            <td>${{ number_format($item['product']->price, 0, ',', '.') }}</td>
                                            <td>
                                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" class="form-control form-control-sm" style="width: 70px;">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2" title="Actualizar cantidad">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>${{ number_format($item['product']->price * $item['quantity'], 0, ',', '.') }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar del carrito">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                        <td colspan="2"><strong>${{ number_format($total, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas vaciar tu carrito?')">
                                        <i class="fas fa-trash-alt me-2"></i> Vaciar Carrito
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="d-flex flex-column flex-md-row justify-content-end gap-2">
                                    <a href="{{ route('orders.create') }}" class="btn btn-modern btn-modern-primary">
                                        <i class="fas fa-shopping-bag me-2"></i> Proceder al Pago
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-modern btn-modern-success dropdown-toggle" type="button" id="whatsappCheckoutDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fab fa-whatsapp me-2"></i> Finalizar por WhatsApp
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="whatsappCheckoutDropdown">
                                            @php
                                                $storeGroups = collect($items)->groupBy(function($item) {
                                                    return $item['product']->store_id;
                                                });
                                            @endphp

                                            @foreach($storeGroups as $storeId => $storeItems)
                                                @php
                                                    $store = $storeItems->first()['product']->store;
                                                    $storeTotal = $storeItems->sum(function($item) {
                                                        return $item['product']->price * $item['quantity'];
                                                    });

                                                    $message = "Hola, me gustaría realizar un pedido de los siguientes productos:\n\n";
                                                    foreach($storeItems as $item) {
                                                        $message .= "- " . $item['product']->name . " x " . $item['quantity'] . " = $" . number_format($item['product']->price * $item['quantity'], 0, ',', '.') . "\n";
                                                    }
                                                    $message .= "\nTotal: $" . number_format($storeTotal, 0, ',', '.') . "\n\n";
                                                    $message .= "Mi información de contacto:\n";
                                                    $message .= "Nombre: " . auth()->user()->name . "\n";
                                                    $message .= "Teléfono: " . auth()->user()->phone . "\n";
                                                    $message .= "Dirección: " . auth()->user()->address . ", " . auth()->user()->city . "\n\n";
                                                    $message .= "Por favor, indícame cómo proceder con el pago y envío.";
                                                    $encodedMessage = urlencode($message);
                                                @endphp

                                                @if($store->whatsapp)
                                                    <li>
                                                        <a class="dropdown-item" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->whatsapp) }}?text={{ $encodedMessage }}" target="_blank">
                                                            <i class="fas fa-store me-2"></i> {{ $store->name }} (${{ number_format($storeTotal, 0, ',', '.') }})
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-cart.svg') }}" alt="Carrito vacío" class="img-fluid mb-3" style="max-width: 150px;">
                            <h5>Tu carrito está vacío</h5>
                            <p class="text-muted mb-4">¡Agrega algunos productos a tu carrito para comenzar a comprar!</p>
                            <a href="{{ route('products.index') }}" class="btn btn-modern btn-modern-primary">
                                <i class="fas fa-shopping-basket me-2"></i> Explorar Productos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
