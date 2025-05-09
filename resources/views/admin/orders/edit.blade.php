@extends('layouts.admin')

@section('title', 'Editar Pedido')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Editar Pedido #{{ $order->order_number }}</h2>
        <div>
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary me-2">
                <i class="fas fa-eye me-1"></i> Ver Detalles
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver a Pedidos
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Estado del Pedido</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Procesando</option>
                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completado</option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="payment_status" class="form-label">Estado de Pago</label>
                                <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Pagado</option>
                                    <option value="failed" {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>Fallido</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Actualizar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Cliente</h6>
                        <p class="mb-0">
                            <a href="{{ route('admin.users.show', $order->user) }}">
                                {{ $order->user->name }}
                            </a>
                        </p>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Fecha del Pedido</h6>
                        <p class="mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Método de Pago</h6>
                        <p class="mb-0">
                            @if($order->payment_method == 'cash')
                                <span class="badge bg-secondary">Efectivo</span>
                            @elseif($order->payment_method == 'credit_card')
                                <span class="badge bg-info">Tarjeta de Crédito</span>
                            @elseif($order->payment_method == 'bank_transfer')
                                <span class="badge bg-primary">Transferencia Bancaria</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Monto Total</h6>
                        <p class="mb-0 fw-bold">${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Dirección de Envío</h6>
                        <p class="mb-0">{{ $order->shipping_address }}</p>
                        <p class="mb-0">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}</p>
                        <p class="mb-0">Tel: {{ $order->shipping_phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
