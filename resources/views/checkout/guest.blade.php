@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('styles')
<style>
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .checkout-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        border: none;
    }
    
    .checkout-card-header {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .checkout-card-title {
        margin-bottom: 0;
        font-weight: 700;
        color: #333;
    }
    
    .checkout-card-body {
        padding: 1.5rem;
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
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
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
    
    .order-summary {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 15px;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .summary-total {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2E7D32;
    }
    
    .btn-checkout {
        background-color: #2E7D32;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 1rem;
    }
    
    .btn-checkout:hover {
        background-color: #1B5E20;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        color: white;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
    }
    
    .form-control:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
    }
    
    .create-account-section {
        background-color: #f0f8ff;
        padding: 1.5rem;
        border-radius: 15px;
        margin-top: 2rem;
    }
    
    .payment-method-option {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-method-option:hover {
        border-color: #2E7D32;
        background-color: #f8f9fa;
    }
    
    .payment-method-option.selected {
        border-color: #2E7D32;
        background-color: #f1f8e9;
    }
    
    .payment-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
        color: #2E7D32;
    }
</style>
@endsection

@section('content')
<div class="container py-5 checkout-container">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="h3 mb-3">Finalizar Compra</h1>
            <p class="text-muted">Complete sus datos para finalizar su pedido.</p>
        </div>
    </div>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Información de contacto -->
                <div class="card checkout-card">
                    <div class="checkout-card-header">
                        <h5 class="checkout-card-title">Información de Contacto</h5>
                    </div>
                    <div class="checkout-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dirección de envío -->
                <div class="card checkout-card mt-4">
                    <div class="checkout-card-header">
                        <h5 class="checkout-card-title">Dirección de Envío</h5>
                    </div>
                    <div class="checkout-card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Dirección <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Ciudad <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">Departamento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zipcode" class="form-label">Código Postal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('zipcode') is-invalid @enderror" id="zipcode" name="zipcode" value="{{ old('zipcode') }}" required>
                                @error('zipcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Método de pago -->
                <div class="card checkout-card mt-4">
                    <div class="checkout-card-header">
                        <h5 class="checkout-card-title">Método de Pago</h5>
                    </div>
                    <div class="checkout-card-body">
                        <div class="payment-method-option @if(old('payment_method') == 'cash' || !old('payment_method')) selected @endif" onclick="selectPaymentMethod('cash')">
                            <input type="radio" name="payment_method" id="payment_cash" value="cash" @if(old('payment_method') == 'cash' || !old('payment_method')) checked @endif class="d-none">
                            <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                            <div>
                                <h6 class="mb-1">Efectivo</h6>
                                <p class="mb-0 text-muted small">Pago contra entrega</p>
                            </div>
                        </div>
                        
                        <div class="payment-method-option @if(old('payment_method') == 'bank_transfer') selected @endif" onclick="selectPaymentMethod('bank_transfer')">
                            <input type="radio" name="payment_method" id="payment_bank_transfer" value="bank_transfer" @if(old('payment_method') == 'bank_transfer') checked @endif class="d-none">
                            <div class="payment-icon"><i class="fas fa-university"></i></div>
                            <div>
                                <h6 class="mb-1">Transferencia Bancaria</h6>
                                <p class="mb-0 text-muted small">Recibirás los datos bancarios por correo electrónico</p>
                            </div>
                        </div>
                        
                        <div class="payment-method-option @if(old('payment_method') == 'credit_card') selected @endif" onclick="selectPaymentMethod('credit_card')">
                            <input type="radio" name="payment_method" id="payment_credit_card" value="credit_card" @if(old('payment_method') == 'credit_card') checked @endif class="d-none">
                            <div class="payment-icon"><i class="fas fa-credit-card"></i></div>
                            <div>
                                <h6 class="mb-1">Tarjeta de Crédito/Débito</h6>
                                <p class="mb-0 text-muted small">Pago seguro con tarjeta</p>
                            </div>
                        </div>
                        
                        @error('payment_method')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Notas del pedido -->
                <div class="card checkout-card mt-4">
                    <div class="checkout-card-header">
                        <h5 class="checkout-card-title">Notas del Pedido</h5>
                    </div>
                    <div class="checkout-card-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Instrucciones especiales para la entrega (opcional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Crear cuenta -->
                <div class="create-account-section mt-4">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="create_account" name="create_account" value="1" @if(old('create_account')) checked @endif onchange="togglePasswordFields()">
                        <label class="form-check-label" for="create_account">
                            <strong>Crear una cuenta para futuras compras</strong>
                        </label>
                    </div>
                    
                    <div id="password_fields" class="@if(!old('create_account')) d-none @endif">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                        <p class="text-muted small">Al crear una cuenta, podrás acceder a tu historial de pedidos y guardar tus datos para futuras compras.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Resumen del pedido -->
                <div class="card checkout-card">
                    <div class="checkout-card-header">
                        <h5 class="checkout-card-title">Resumen del Pedido</h5>
                    </div>
                    <div class="checkout-card-body">
                        @foreach($items as $item)
                            <div class="product-item">
                                <img src="{{ $item['product']->first_image ? asset('storage/' . $item['product']->first_image) : 'https://via.placeholder.com/80' }}" alt="{{ $item['product']->name }}" class="product-image">
                                <div class="product-details">
                                    <h6 class="product-name">{{ $item['product']->name }}</h6>
                                    <p class="product-store">{{ $item['product']->store->name }}</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="product-price">${{ number_format($item['product']->price, 0, ',', '.') }}</span>
                                        <span class="product-quantity">x {{ $item['quantity'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="order-summary mt-4">
                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span>${{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Envío</span>
                                <span>Gratis</span>
                            </div>
                            <hr>
                            <div class="summary-item summary-total">
                                <span>Total</span>
                                <span>${{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <button type="submit" class="btn btn-checkout">
                                <i class="fas fa-lock me-2"></i> Finalizar Compra
                            </button>
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('cart.index') }}" class="text-decoration-none">
                                    <i class="fas fa-arrow-left me-1"></i> Volver al carrito
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function selectPaymentMethod(method) {
        // Remove selected class from all options
        document.querySelectorAll('.payment-method-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Add selected class to clicked option
        document.querySelector(`.payment-method-option input[value="${method}"]`).closest('.payment-method-option').classList.add('selected');
        
        // Check the radio button
        document.querySelector(`#payment_${method}`).checked = true;
    }
    
    function togglePasswordFields() {
        const createAccount = document.getElementById('create_account');
        const passwordFields = document.getElementById('password_fields');
        
        if (createAccount.checked) {
            passwordFields.classList.remove('d-none');
        } else {
            passwordFields.classList.add('d-none');
        }
    }
</script>
@endsection
