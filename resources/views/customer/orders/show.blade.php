@extends('layouts.customer')

@section('title', 'Pedido #' . $order->order_number)

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-bag" style="color: var(--blue);"></i> Detalles del Pedido
                    </h5>
                    <div>
                        @if($order->status == 'pending' && $order->created_at->diffInHours(now()) <= 1)
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido? Solo puedes cancelar pedidos dentro de la primera hora.')">
                                    <i class="fas fa-times me-1"></i> Cancelar Pedido
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Volver a Pedidos
                        </a>
                    </div>
                </div>
                <div class="modern-card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <span class="badge rounded-pill" style="background-color: var(--blue); font-size: 1rem; padding: 10px 15px;">
                                        #{{ $order->order_number }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-0">Pedido #{{ $order->order_number }}</h4>
                                    <p class="text-muted mb-0">Realizado el {{ $order->created_at->format('d M, Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-2">Estado:</span>
                                    @if($order->status == 'pending')
                                        <span class="modern-badge badge-warning">Pendiente</span>
                                    @elseif($order->status == 'processing')
                                        <span class="modern-badge badge-info">Procesando</span>
                                    @elseif($order->status == 'completed')
                                        <span class="modern-badge badge-success">Completado</span>
                                    @elseif($order->status == 'declined')
                                        <span class="modern-badge badge-danger">Cancelado</span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">Pago:</span>
                                    @if($order->payment_status == 'pending')
                                        <span class="modern-badge badge-warning">Pendiente</span>
                                    @elseif($order->payment_status == 'paid')
                                        <span class="modern-badge badge-success">Pagado</span>
                                    @elseif($order->payment_status == 'failed')
                                        <span class="modern-badge badge-danger">Fallido</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Información de Envío</h5>
                                    <p class="mb-1"><strong>Dirección:</strong> {{ $order->shipping_address }}</p>
                                    <p class="mb-1"><strong>Ciudad:</strong> {{ $order->shipping_city }}</p>
                                    <p class="mb-1"><strong>Departamento:</strong> {{ $order->shipping_state }}</p>
                                    <p class="mb-1"><strong>Código Postal:</strong> {{ $order->shipping_zipcode }}</p>
                                    <p class="mb-0"><strong>Teléfono:</strong> {{ $order->shipping_phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3">Productos del Pedido</h5>
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
                                    <th>Contacto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            @if($item->product && $item->product->first_image)
                                                <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="{{ $item->product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none">
                                                    {{ $item->product->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Producto no disponible</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->store)
                                                <a href="{{ route('stores.show', $item->store->slug) }}" class="text-decoration-none">
                                                    {{ $item->store->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Tienda no disponible</span>
                                            @endif
                                        </td>
                                        <td>${{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->store && $item->store->whatsapp)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->store->whatsapp) }}?text=Hola, estoy consultando por mi pedido #{{ $order->order_number }} del producto: {{ $item->product ? $item->product->name : 'Producto' }}" class="btn-whatsapp" target="_blank">
                                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                                </a>
                                            @else
                                                <span class="text-muted">No disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                    <td colspan="2"><strong>${{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <div class="card mb-4 border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title mb-2">Notas del Pedido</h5>
                                <p class="card-text mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="timeline">
                        <div class="timeline-item {{ $order->status == 'pending' ? 'timeline-item-warning' : ($order->status == 'completed' ? 'timeline-item-success' : ($order->status == 'declined' ? 'timeline-item-danger' : '')) }}">
                            <div class="timeline-date">{{ $order->created_at->format('d M, Y H:i') }}</div>
                            <div class="timeline-title">Pedido Realizado</div>
                            <div class="timeline-text">Tu pedido ha sido recibido y está pendiente de procesamiento.</div>
                        </div>
                        
                        @if($order->status != 'pending')
                            <div class="timeline-item {{ $order->status == 'processing' ? '' : ($order->status == 'completed' ? 'timeline-item-success' : 'timeline-item-danger') }}">
                                <div class="timeline-date">{{ $order->updated_at->format('d M, Y H:i') }}</div>
                                <div class="timeline-title">
                                    @if($order->status == 'processing')
                                        Pedido en Procesamiento
                                    @elseif($order->status == 'completed')
                                        Pedido Completado
                                    @elseif($order->status == 'declined')
                                        Pedido Cancelado
                                    @endif
                                </div>
                                <div class="timeline-text">
                                    @if($order->status == 'processing')
                                        Tu pedido está siendo procesado por los productores.
                                    @elseif($order->status == 'completed')
                                        Tu pedido ha sido completado y entregado.
                                    @elseif($order->status == 'declined')
                                        Tu pedido ha sido cancelado.
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
