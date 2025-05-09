@extends('layouts.customer')

@section('title', 'Finalizar Compra')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-cart" style="color: var(--blue);"></i> Finalizar Compra
                    </h5>
                    <a href="{{ route('cart.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Volver al Carrito
                    </a>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <h4 class="mb-3">Resumen del Pedido</h4>
                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;"></th>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cant.</th>
                                            <th>Total</th>
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
                                                    <div>
                                                        <strong>{{ $item['product']->name }}</strong>
                                                    </div>
                                                    <small class="text-muted">{{ $item['product']->store->name }}</small>
                                                </td>
                                                <td>${{ number_format($item['product']->price, 0, ',', '.') }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>${{ number_format($item['product']->price * $item['quantity'], 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                            <td><strong>${{ number_format($total, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <h4 class="mb-3">Información de Envío y Pago</h4>
                            <form action="{{ route('orders.store') }}" method="POST" class="form-modern">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Dirección</label>
                                    <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address', auth()->user()->address) }}" class="form-control" required>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="shipping_city" class="form-label">Ciudad</label>
                                        <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', auth()->user()->city) }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_state" class="form-label">Departamento</label>
                                        <input type="text" name="shipping_state" id="shipping_state" value="{{ old('shipping_state', auth()->user()->state) }}" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="shipping_zipcode" class="form-label">Código Postal</label>
                                        <input type="text" name="shipping_zipcode" id="shipping_zipcode" value="{{ old('shipping_zipcode', auth()->user()->zipcode) }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_phone" class="form-label">Teléfono</label>
                                        <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Método de Pago</label>
                                    <select name="payment_method" id="payment_method" class="form-select" required>
                                        <option value="cash">Efectivo contra entrega</option>
                                        <option value="credit_card">Tarjeta de Crédito</option>
                                        <option value="bank_transfer">Transferencia Bancaria</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="notes" class="form-label">Notas del Pedido (Opcional)</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Volver al Carrito
                                    </a>
                                    <button type="submit" class="btn btn-modern btn-modern-success">
                                        <i class="fas fa-check me-2"></i> Realizar Pedido
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto 3D para los campos de formulario
        const inputs = document.querySelectorAll('.form-control, .form-select');
        
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                this.style.transition = 'all 0.3s ease';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endsection
