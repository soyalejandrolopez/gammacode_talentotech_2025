@extends('layouts.producer')

@section('title', 'Administrar Pedidos')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-cart text-primary"></i> Pedidos de Tu Tienda
                    </h5>
                </div>
                <div class="modern-card-body">

                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Pedido #</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user text-secondary"></i>
                                                    </div>
                                                    @if($order->user)
                                                        <span>{{ $order->user->name }}</span>
                                                    @elseif($order->is_guest_order)
                                                        <span>{{ $order->guest_name }} <small class="modern-badge badge-secondary">Invitado</small></span>
                                                    @else
                                                        <span>Cliente desconocido</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $order->created_at->format('d M, Y') }}</td>
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
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('producer.orders.show', $order) }}" class="action-icon action-icon-primary" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($order->user && $order->user->phone)
                                                        <a href="tel:{{ $order->user->phone }}" class="action-icon" style="background-color: rgba(76, 175, 80, 0.15); color: #4CAF50;" title="Llamar">
                                                            <i class="fas fa-phone"></i>
                                                        </a>
                                                    @endif
                                                    @if($order->shipping_phone)
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->shipping_phone) }}?text={{ urlencode('Hola, me comunico contigo respecto a tu pedido #' . $order->order_number) }}"
                                                           class="action-icon" style="background-color: rgba(37, 211, 102, 0.15); color: #25D366;"
                                                           target="_blank" title="WhatsApp">
                                                            <i class="fab fa-whatsapp"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-orders.svg') }}" alt="No hay pedidos" class="img-fluid mb-3" style="max-width: 150px;">
                            <h5>No se encontraron pedidos</h5>
                            <p class="text-muted">Aún no has recibido ningún pedido.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
