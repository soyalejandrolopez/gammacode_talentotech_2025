@extends('layouts.producer')

@section('title', 'Pedido #' . $order->order_number)

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-cart text-primary"></i> Detalles del Pedido
                    </h5>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('producer.orders.update-status', $order) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select me-2">
                                <option value="pending">Pendiente</option>
                                <option value="processing">Procesando</option>
                                <option value="completed">Completado</option>
                                <option value="declined">Cancelado</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                Actualizar Estado de Todos los Productos
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-user text-primary me-2"></i> Información del Cliente
                            </h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-sm bg-light rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                                <div>
                                    @if($order->user)
                                        <h6 class="mb-0">{{ $order->user->name }}</h6>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    @elseif($order->is_guest_order)
                                        <h6 class="mb-0">{{ $order->guest_name }} <span class="badge bg-secondary">Invitado</span></h6>
                                        <small class="text-muted">{{ $order->guest_email }}</small>
                                    @else
                                        <h6 class="mb-0">Cliente desconocido</h6>
                                    @endif
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-2 border-top">
                                    <strong>Pedido:</strong> #{{ $order->order_number }}
                                </li>
                                <li class="list-group-item px-0 py-2">
                                    <strong>Fecha:</strong> {{ $order->created_at->format('d M, Y h:i A') }}
                                </li>
                                @if($order->user && $order->user->phone)
                                    <li class="list-group-item px-0 py-2">
                                        <strong>Teléfono:</strong> {{ $order->user->phone }}
                                        <a href="tel:{{ $order->user->phone }}" class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-shipping-fast text-primary me-2"></i> Información de Envío
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-2 border-top">
                                    <strong>Dirección:</strong> {{ $order->shipping_address }}
                                </li>
                                <li class="list-group-item px-0 py-2">
                                    <strong>Ciudad:</strong> {{ $order->shipping_city }}
                                </li>
                                <li class="list-group-item px-0 py-2">
                                    <strong>Estado:</strong> {{ $order->shipping_state }}
                                </li>
                                <li class="list-group-item px-0 py-2">
                                    <strong>Código Postal:</strong> {{ $order->shipping_zipcode }}
                                </li>
                                @if($order->shipping_phone)
                                    <li class="list-group-item px-0 py-2">
                                        <strong>Teléfono:</strong> {{ $order->shipping_phone }}
                                        <div class="btn-group ms-2">
                                            <a href="tel:{{ $order->shipping_phone }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-phone"></i>
                                            </a>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->shipping_phone) }}?text={{ urlencode('Hola, me comunico contigo respecto a tu pedido #' . $order->order_number) }}"
                                               class="btn btn-sm btn-outline-success" target="_blank">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-box text-primary me-2"></i> Productos del Pedido
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal = 0; @endphp
                                @foreach($order->orderItems as $item)
                                    @php $subtotal += $item->total; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 50px; height: 50px;">
                                                    <img class="rounded w-100 h-100 object-fit-cover" src="{{ !empty($item->product->images) ? asset('storage/' . $item->product->images[0]) : 'https://via.placeholder.com/150' }}" alt="{{ $item->product->name }}">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-primary">${{ number_format($item->price, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->status == 'pending')
                                                    <span class="modern-badge badge-warning me-2">Pendiente</span>
                                                @elseif($item->status == 'processing')
                                                    <span class="modern-badge badge-info me-2">Procesando</span>
                                                @elseif($item->status == 'completed')
                                                    <span class="modern-badge badge-success me-2">Completado</span>
                                                @elseif($item->status == 'declined')
                                                    <span class="modern-badge badge-danger me-2">Cancelado</span>
                                                @endif

                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                        <li>
                                                            <form action="{{ route('producer.orders.update-item-status', ['order' => $order->id, 'item' => $item->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="dropdown-item">Pendiente</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('producer.orders.update-item-status', ['order' => $order->id, 'item' => $item->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="processing">
                                                                <button type="submit" class="dropdown-item">Procesando</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('producer.orders.update-item-status', ['order' => $order->id, 'item' => $item->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="completed">
                                                                <button type="submit" class="dropdown-item">Completado</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('producer.orders.update-item-status', ['order' => $order->id, 'item' => $item->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="declined">
                                                                <button type="submit" class="dropdown-item">Cancelado</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($item->total, 2) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                    <td class="fw-bold fs-5 text-primary">${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-sticky-note text-primary me-2"></i> Notas del Pedido:
                            </h6>
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    @endif

                    <div class="mt-4 text-end">
                        <a href="{{ route('producer.orders.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i> Volver a Pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
