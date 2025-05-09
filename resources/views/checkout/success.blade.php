@extends('layouts.app')

@section('title', 'Pedido Completado')

@section('styles')
<style>
    .success-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .success-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        border: none;
    }
    
    .success-header {
        background-color: #f1f8e9;
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid #e8f5e9;
    }
    
    .success-icon {
        font-size: 4rem;
        color: #2E7D32;
        margin-bottom: 1rem;
    }
    
    .success-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2E7D32;
        margin-bottom: 0.5rem;
    }
    
    .success-subtitle {
        color: #555;
        margin-bottom: 0;
    }
    
    .success-body {
        padding: 2rem;
    }
    
    .order-info {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
    }
    
    .order-info-item {
        margin-bottom: 0.75rem;
    }
    
    .order-info-label {
        font-weight: 600;
        color: #555;
    }
    
    .order-info-value {
        font-weight: 500;
    }
    
    .product-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .product-item:last-child {
        border-bottom: none;
    }
    
    .product-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1rem;
    }
    
    .product-details {
        flex: 1;
    }
    
    .product-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .product-store {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .product-price {
        font-weight: 600;
        color: #2E7D32;
    }
    
    .product-quantity {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .product-total {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2E7D32;
    }
    
    .order-total {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2E7D32;
        text-align: right;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }
    
    .btn-action {
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary-custom {
        background-color: #2E7D32;
        border-color: #2E7D32;
        color: white;
    }
    
    .btn-primary-custom:hover {
        background-color: #1B5E20;
        border-color: #1B5E20;
        color: white;
    }
    
    .btn-outline-primary-custom {
        border-color: #2E7D32;
        color: #2E7D32;
    }
    
    .btn-outline-primary-custom:hover {
        background-color: #2E7D32;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container py-5 success-container">
    <div class="card success-card">
        <div class="success-header">
            <i class="fas fa-check-circle success-icon"></i>
            <h1 class="success-title">¡Pedido Completado con Éxito!</h1>
            <p class="success-subtitle">Gracias por tu compra. Tu pedido ha sido recibido y está siendo procesado.</p>
        </div>
        
        <div class="success-body">
            <div class="order-info">
                <div class="row">
                    <div class="col-md-3">
                        <div class="order-info-item">
                            <div class="order-info-label">Número de Pedido</div>
                            <div class="order-info-value">{{ $order->order_number }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="order-info-item">
                            <div class="order-info-label">Fecha</div>
                            <div class="order-info-value">{{ $order->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="order-info-item">
                            <div class="order-info-label">Estado</div>
                            <div class="order-info-value">
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="order-info-item">
                            <div class="order-info-label">Método de Pago</div>
                            <div class="order-info-value">
                                @if($order->payment_method == 'cash')
                                    Efectivo
                                @elseif($order->payment_method == 'credit_card')
                                    Tarjeta de Crédito/Débito
                                @elseif($order->payment_method == 'bank_transfer')
                                    Transferencia Bancaria
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h5 class="mb-3">Detalles del Pedido</h5>
            
            <div class="table-responsive mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Tienda</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->first_image ? asset('storage/' . $item->product->first_image) : 'https://via.placeholder.com/70' }}" alt="{{ $item->product->name }}" class="product-image">
                                        <div>
                                            <h6 class="product-name mb-0">{{ $item->product->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->store->name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end">${{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Información de Envío</h5>
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1"><strong>Nombre:</strong> {{ $order->user ? $order->user->name : $order->guest_name }}</p>
                            <p class="mb-1"><strong>Dirección:</strong> {{ $order->shipping_address }}</p>
                            <p class="mb-1"><strong>Ciudad:</strong> {{ $order->shipping_city }}</p>
                            <p class="mb-1"><strong>Departamento:</strong> {{ $order->shipping_state }}</p>
                            <p class="mb-1"><strong>Código Postal:</strong> {{ $order->shipping_zipcode }}</p>
                            <p class="mb-0"><strong>Teléfono:</strong> {{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Resumen del Pedido</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Envío</span>
                                <span>Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold">${{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('products.index') }}" class="btn btn-primary-custom btn-action me-2">
                    <i class="fas fa-shopping-basket me-2"></i> Seguir Comprando
                </a>
                
                @if(auth()->check())
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary-custom btn-action">
                        <i class="fas fa-list me-2"></i> Mis Pedidos
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
