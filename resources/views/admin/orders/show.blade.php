@extends('layouts.admin')

@section('title', 'Detalles del Pedido')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Pedido #{{ $order->order_number }}</h2>
        <div>
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver a Pedidos
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Estado</h6>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info">Procesando</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success">Completado</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger">Cancelado</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Fecha del Pedido</h6>
                        <p class="mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Método de Pago</h6>
                        <p class="mb-0">{{ $order->payment_method ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total</h6>
                        <h4 class="text-primary">${{ number_format($order->total_amount, 2) }}</h4>
                    </div>
                </div>
                <div class="card-footer">
                    <h6 class="mb-3">Acciones</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning w-100">
                            <i class="fas fa-edit me-1"></i> Editar Pedido
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                <i class="fas fa-trash me-1"></i> Eliminar Pedido
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Nombre</h6>
                        @if($order->user)
                            <p class="mb-0">{{ $order->user->name }}</p>
                        @elseif($order->is_guest_order)
                            <p class="mb-0">{{ $order->guest_name }} <span class="badge bg-secondary">Invitado</span></p>
                        @else
                            <p class="mb-0">Cliente desconocido</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Email</h6>
                        @if($order->user)
                            <p class="mb-0">{{ $order->user->email }}</p>
                        @elseif($order->is_guest_order)
                            <p class="mb-0">{{ $order->guest_email }}</p>
                        @else
                            <p class="mb-0">No especificado</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Teléfono</h6>
                        <p class="mb-0">{{ $order->shipping_phone ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Dirección de Envío</h6>
                        <p class="mb-0">{{ $order->shipping_address ?? 'No especificada' }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-envelope me-1"></i> Enviar Mensaje al Cliente
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Notas del Pedido</h5>
                </div>
                <div class="card-body">
                    @if($order->notes)
                        <p>{{ $order->notes }}</p>
                    @else
                        <p class="text-muted">No hay notas para este pedido.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="fas fa-plus me-1"></i> Agregar Nota
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Productos del Pedido</h5>
        </div>
        <div class="card-body">
            @if($order->orderItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tienda</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="img-thumbnail me-3" width="50">
                                            @else
                                                <div class="bg-light text-center me-3" style="width: 50px; height: 50px; line-height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div>{{ $item->product_name }}</div>
                                                @if($item->product)
                                                    <small class="text-muted">{{ $item->product->slug }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->store->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                                <td class="text-end">${{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</td>
                            </tr>
                            @if($order->shipping_cost)
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Costo de Envío:</td>
                                    <td class="text-end">${{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                            @endif
                            @if($order->tax)
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Impuestos:</td>
                                    <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-box text-muted mb-3" style="font-size: 2rem;"></i>
                    <p class="text-muted">No hay productos en este pedido.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Note Modal -->
    <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Agregar Nota al Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $order->status }}">
                    <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Nota</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4">{{ $order->notes }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Nota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirm delete
        const deleteForm = document.querySelector('.delete-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que deseas eliminar este pedido? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endsection
