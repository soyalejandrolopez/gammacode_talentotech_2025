@extends('layouts.customer')

@section('title', 'Mis Pedidos')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-bag" style="color: var(--blue);"></i> Historial de Pedidos
                    </h5>
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

                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Pedido #</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Pago</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_number }}</strong>
                                            </td>
                                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                                            <td>${{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="modern-badge badge-warning">Pendiente</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="modern-badge badge-info">Procesando</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="modern-badge badge-success">Completado</span>
                                                @elseif($order->status == 'declined')
                                                    <span class="modern-badge badge-danger">Cancelado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->payment_status == 'pending')
                                                    <span class="modern-badge badge-warning">Pendiente</span>
                                                @elseif($order->payment_status == 'paid')
                                                    <span class="modern-badge badge-success">Pagado</span>
                                                @elseif($order->payment_status == 'failed')
                                                    <span class="modern-badge badge-danger">Fallido</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary me-2" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($order->status == 'pending' && $order->created_at->diffInHours(now()) <= 1)
                                                        <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancelar pedido" onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido? Solo puedes cancelar pedidos dentro de la primera hora.')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-orders.svg') }}" alt="No hay pedidos" class="img-fluid mb-3" style="max-width: 150px;">
                            <h5>No tienes pedidos</h5>
                            <p class="text-muted mb-4">¡Explora nuestros productos y realiza tu primer pedido!</p>
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
