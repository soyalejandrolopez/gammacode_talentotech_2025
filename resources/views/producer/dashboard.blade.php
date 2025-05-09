@extends('layouts.producer')

@section('title', 'Panel de Productor')

@section('content')
    <!-- Bienvenida y resumen con efecto 3D -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            <div class="rounded-circle overflow-hidden mx-auto" style="width: 120px; height: 120px; border: 3px solid var(--yellow); box-shadow: 0 10px 20px rgba(0,0,0,0.1); transform: perspective(800px) rotateY(10deg);">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, rgba(255,193,7,0.2), rgba(13,71,161,0.2), rgba(211,47,47,0.2));">
                                        <i class="fas fa-store text-secondary fa-3x"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h2 class="h3 mb-2" style="text-shadow: 0 2px 4px rgba(0,0,0,0.1);">¡Bienvenido a tu tienda, {{ Auth::user()->name }}!</h2>
                            <h3 class="h5 mb-3" style="color: var(--yellow); text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{ $store->name }}</h3>
                            <p class="text-muted mb-3">{{ $store->description ?: 'Añade una descripción a tu tienda para que tus clientes conozcan más sobre ti y tus productos.' }}</p>
                            <div class="row g-2">
                                @if($store->phone)
                                    <div class="col-auto">
                                        <span class="modern-badge" style="background: linear-gradient(135deg, var(--yellow-light), var(--yellow));">
                                            <i class="fas fa-phone me-1"></i> {{ $store->phone }}
                                        </span>
                                    </div>
                                @endif
                                @if($store->email)
                                    <div class="col-auto">
                                        <span class="modern-badge" style="background: linear-gradient(135deg, var(--blue-light), var(--blue));">
                                            <i class="fas fa-envelope me-1"></i> {{ $store->email }}
                                        </span>
                                    </div>
                                @endif
                                @if($store->address)
                                    <div class="col-auto">
                                        <span class="modern-badge" style="background: linear-gradient(135deg, var(--red-light), var(--red)); color: white;">
                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $store->address }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('producer.store.edit') }}" class="btn btn-primary mb-2 w-100" style="background: linear-gradient(135deg, var(--yellow), var(--yellow-dark)); border: none; box-shadow: 0 4px 10px rgba(255,193,7,0.3);">
                                <i class="fas fa-edit me-2"></i> Editar Tienda
                            </a>
                            <a href="{{ url('/stores/' . $store->slug) }}" target="_blank" class="btn btn-outline-secondary w-100" style="border: 2px solid var(--blue); color: var(--blue); box-shadow: 0 4px 10px rgba(13,71,161,0.1);">
                                <i class="fas fa-eye me-2"></i> Ver Tienda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas con efecto 3D -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="stat-card fade-in-up" style="animation-delay: 0.1s;">
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $totalProducts }}</h3>
                    <p class="stat-label">Productos</p>
                    <div class="stat-trend">
                        <i class="fas fa-chart-line"></i> Activos en tu tienda
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="stat-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="stat-icon stat-icon-secondary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $totalOrders }}</h3>
                    <p class="stat-label">Pedidos Totales</p>
                    <div class="stat-trend">
                        <i class="fas fa-history"></i> Histórico acumulado
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="stat-card fade-in-up" style="animation-delay: 0.3s;">
                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $recentOrders->where('status', 'pending')->count() }}</h3>
                    <p class="stat-label">Pedidos Pendientes</p>
                    <div class="stat-trend trend-positive">
                        <i class="fas fa-clock"></i> Requieren atención
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card fade-in-up" style="animation-delay: 0.4s;">
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $recentOrders->filter(function($order) { return $order->user_id || $order->is_guest_order; })->count() }}</h3>
                    <p class="stat-label">Clientes Recientes</p>
                    <div class="stat-trend">
                        <i class="fas fa-user-check"></i> Últimos pedidos
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficas 3D -->
    <div class="row mb-4">
        <div class="col-md-8 mb-4">
            <div class="modern-card fade-in-up" style="animation-delay: 0.5s;">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-chart-line" style="color: var(--yellow);"></i> Resumen de Ventas
                    </h5>
                    <div class="btn-group period-selector">
                        <button type="button" class="btn btn-sm btn-outline-secondary active" data-period="monthly">Mensual</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-period="quarterly">Trimestral</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-period="yearly">Anual</button>
                    </div>
                </div>
                <div class="modern-card-body">
                    <div style="height: 300px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="modern-card fade-in-up" style="animation-delay: 0.6s;">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-chart-pie" style="color: var(--blue);"></i> Estado de Pedidos
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div style="height: 300px;">
                        <canvas id="ordersStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pedidos Recientes y Productos por Categoría -->
    <div class="row">
        <!-- Pedidos Recientes -->
        <div class="col-lg-8 mb-4">
            <div class="modern-card fade-in-up" style="animation-delay: 0.7s;">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-cart" style="color: var(--red);"></i> Pedidos Recientes
                    </h5>
                    <a href="{{ route('producer.orders.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--blue-light), var(--blue)); color: white; box-shadow: 0 4px 6px rgba(13,71,161,0.2);">
                        Ver Todos <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="modern-card-body p-0">
                    @if($recentOrders->count() > 0)
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
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-user" style="color: var(--blue);"></i>
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
                                                @elseif($order->status == 'declined' || $order->status == 'cancelled')
                                                    <span class="modern-badge badge-danger">Cancelado</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('producer.orders.show', $order) }}" class="action-icon action-icon-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-orders.svg') }}" alt="No hay pedidos" class="img-fluid mb-3" style="max-width: 150px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));">
                            <h5>No hay pedidos recientes</h5>
                            <p class="text-muted">Cuando recibas pedidos, aparecerán aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Productos por Categoría y Acciones Rápidas -->
        <div class="col-lg-4">
            <div class="modern-card fade-in-up mb-4" style="animation-delay: 0.8s;">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-boxes" style="color: var(--yellow);"></i> Productos por Categoría
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div style="height: 200px;">
                        <canvas id="productsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="modern-card fade-in-up" style="animation-delay: 0.9s;">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-bolt" style="color: var(--red);"></i> Acciones Rápidas
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('producer.products.create') }}" class="btn btn-modern" style="background: linear-gradient(135deg, var(--yellow), var(--yellow-dark)); color: #333; box-shadow: 0 4px 10px rgba(255,193,7,0.3);">
                            <i class="fas fa-plus-circle me-2"></i> Añadir Nuevo Producto
                        </a>
                        <a href="{{ route('producer.products.index') }}" class="btn btn-modern" style="background: linear-gradient(135deg, var(--blue-light), var(--blue)); color: white; box-shadow: 0 4px 10px rgba(13,71,161,0.3);">
                            <i class="fas fa-box me-2"></i> Administrar Productos
                        </a>
                        <a href="{{ route('producer.orders.index') }}" class="btn btn-modern" style="background: linear-gradient(135deg, var(--red-light), var(--red)); color: white; box-shadow: 0 4px 10px rgba(211,47,47,0.3);">
                            <i class="fas fa-shopping-cart me-2"></i> Ver Todos los Pedidos
                        </a>
                    </div>

                    <div class="mt-4 p-3 rounded" style="background: linear-gradient(135deg, rgba(255,193,7,0.1), rgba(13,71,161,0.1), rgba(211,47,47,0.1)); border: 1px dashed rgba(0,0,0,0.1);">
                        <h6 class="mb-3" style="color: var(--blue); text-shadow: 0 1px 2px rgba(0,0,0,0.05);"><i class="fas fa-lightbulb me-2" style="color: var(--yellow);"></i> Consejos para Productores</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex align-items-center">
                                <span class="me-2" style="color: var(--yellow);"><i class="fas fa-check-circle"></i></span>
                                <span>Mantén actualizadas las fotos de tus productos</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <span class="me-2" style="color: var(--blue);"><i class="fas fa-check-circle"></i></span>
                                <span>Responde rápidamente a los pedidos</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="me-2" style="color: var(--red);"><i class="fas fa-check-circle"></i></span>
                                <span>Añade una descripción detallada a tu tienda</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar las gráficas
        initializeCharts();
    });
</script>
@endsection
