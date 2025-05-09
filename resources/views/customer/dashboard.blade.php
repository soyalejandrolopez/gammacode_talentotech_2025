@extends('layouts.customer')

@section('title', 'Panel de Cliente')

@section('content')
    <!-- Bienvenida y resumen con efecto 3D -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            <div class="rounded-circle overflow-hidden mx-auto" style="width: 120px; height: 120px; border: 3px solid var(--yellow); box-shadow: 0 10px 20px rgba(0,0,0,0.1); transform: perspective(800px) rotateY(10deg);">
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-user fa-3x text-secondary"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h2 class="mb-3">¡Bienvenido, {{ Auth::user()->name }}!</h2>
                            <p class="lead mb-0">Desde aquí puedes gestionar tus pedidos, actualizar tu perfil y realizar compras directamente a los productores rurales.</p>
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
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $totalOrders }}</h3>
                    <p class="stat-label">Pedidos</p>
                    <div class="stat-trend">
                        <i class="fas fa-chart-line"></i> Histórico
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="stat-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="stat-icon stat-icon-secondary">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $pendingOrders }}</h3>
                    <p class="stat-label">Pendientes</p>
                    <div class="stat-trend">
                        <i class="fas fa-spinner"></i> En proceso
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="stat-card fade-in-up" style="animation-delay: 0.3s;">
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $completedOrders }}</h3>
                    <p class="stat-label">Completados</p>
                    <div class="stat-trend">
                        <i class="fas fa-thumbs-up"></i> Entregados
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card fade-in-up" style="animation-delay: 0.4s;">
                <div class="stat-icon stat-icon-danger">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ $cartCount }}</h3>
                    <p class="stat-label">En Carrito</p>
                    <div class="stat-trend">
                        <i class="fas fa-cart-plus"></i> Productos
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pedidos Recientes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up" style="animation-delay: 0.5s;">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-bag" style="color: var(--blue);"></i> Pedidos Recientes
                    </h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--blue-light), var(--blue)); color: white; box-shadow: 0 4px 6px rgba(13,71,161,0.2);">
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
                                        <th>Fecha</th>
                                        <th>Total</th>
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
                                                <div class="d-flex">
                                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary me-2" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($order->status == 'pending' && $order->created_at->diffInHours(now()) <= 1)
                                                        <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancelar pedido" onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido?')">
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
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-orders.svg') }}" alt="No hay pedidos" class="img-fluid mb-3" style="max-width: 150px;">
                            <h5>No tienes pedidos recientes</h5>
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

    <!-- Productos Recomendados -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card fade-in-up" style="animation-delay: 0.6s;">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-star" style="color: var(--yellow);"></i> Productos Recomendados
                    </h5>
                    <a href="{{ route('products.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--yellow-light), var(--yellow)); color: white; box-shadow: 0 4px 6px rgba(255,193,7,0.2);">
                        Ver Más <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        @foreach($recommendedProducts as $product)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                                    <div style="height: 180px; overflow: hidden;">
                                        @if($product->first_image)
                                            <img src="{{ asset('storage/' . $product->first_image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title mb-1" style="font-size: 1rem;">{{ $product->name }}</h5>
                                        <p class="text-muted small mb-2">{{ $product->store->name }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-primary">${{ number_format($product->price, 0, ',', '.') }}</span>
                                            <div class="d-flex">
                                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary me-1" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-sm btn-primary" title="Añadir al carrito">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto 3D para las tarjetas de productos
        const productCards = document.querySelectorAll('.card');
        
        productCards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-10px)';
                this.style.boxShadow = '0 15px 30px rgba(0,0,0,0.1)';
                const img = this.querySelector('.card-img-top');
                if (img) img.style.transform = 'scale(1.1)';
            });
            
            card.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
                const img = this.querySelector('.card-img-top');
                if (img) img.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection
