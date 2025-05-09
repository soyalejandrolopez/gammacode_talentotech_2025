@extends('layouts.customer')

@section('title', $product->name)

@section('styles')
<style>
    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .product-image-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    .product-main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.5s ease;
    }
    
    .product-main-image:hover {
        transform: scale(1.05);
    }
    
    .product-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .product-thumbnail:hover, .product-thumbnail.active {
        transform: translateY(-3px);
        border-color: var(--blue);
    }
    
    .product-info-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .product-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }
    
    .quantity-input {
        width: 70px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 8px;
    }
    
    .quantity-btn {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .quantity-btn:hover {
        background-color: #e9ecef;
    }
    
    .related-product-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .related-product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .related-product-img {
        height: 150px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .related-product-card:hover .related-product-img {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-basket" style="color: var(--blue);"></i> Detalles del Producto
                    </h5>
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        <!-- Imágenes del Producto -->
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="product-image-container mb-3">
                                @if($product->first_image)
                                    <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="product-main-image" id="mainProductImage">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px; border-radius: 15px;">
                                        <i class="fas fa-image fa-5x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            
                            @if(count($product->images) > 1)
                                <div class="d-flex gap-2 justify-content-center">
                                    @foreach($product->images as $index => $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="product-thumbnail {{ $index === 0 ? 'active' : '' }}" onclick="changeMainImage(this, '{{ asset('storage/' . $image) }}')">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <!-- Información del Producto -->
                        <div class="col-lg-6">
                            <div class="product-info-card p-4">
                                <h2 class="mb-2">{{ $product->name }}</h2>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary me-2">{{ $product->category->name ?? 'Sin categoría' }}</span>
                                    <span class="text-muted">Vendido por: <a href="{{ route('stores.show', $product->store->slug) }}" class="text-decoration-none">{{ $product->store->name }}</a></span>
                                </div>
                                
                                <div class="mb-4">
                                    <h3 class="text-primary mb-0">${{ number_format($product->price, 0, ',', '.') }}</h3>
                                    <small class="text-muted">Disponible: {{ $product->stock }} unidades</small>
                                </div>
                                
                                <div class="mb-4">
                                    <h5>Descripción</h5>
                                    <p>{{ $product->description ?? 'No hay descripción disponible para este producto.' }}</p>
                                </div>
                                
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Cantidad</label>
                                        <div class="d-flex align-items-center">
                                            <div class="quantity-btn" onclick="decrementQuantity()">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control mx-2 quantity-input">
                                            <div class="quantity-btn" onclick="incrementQuantity()">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-modern btn-modern-primary">
                                            <i class="fas fa-cart-plus me-2"></i> Añadir al Carrito
                                        </button>
                                        
                                        @if($product->store->whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp) }}?text=Hola, estoy interesado en el producto: {{ $product->name }} que cuesta ${{ number_format($product->price, 0, ',', '.') }}. ¿Podrías darme más información?" class="btn btn-whatsapp" target="_blank">
                                                <i class="fab fa-whatsapp me-2"></i> Consultar por WhatsApp
                                            </a>
                                        @endif
                                    </div>
                                </form>
                                
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="fas fa-truck text-muted me-2"></i> Envío disponible
                                    </div>
                                    <div>
                                        <i class="fas fa-shield-alt text-muted me-2"></i> Compra segura
                                    </div>
                                    <div>
                                        <i class="fas fa-undo text-muted me-2"></i> Devoluciones
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Productos Relacionados -->
                    @if($relatedProducts->count() > 0)
                        <div class="mt-5">
                            <h4 class="mb-4">Productos Relacionados</h4>
                            <div class="row">
                                @foreach($relatedProducts as $relatedProduct)
                                    <div class="col-md-3 mb-4">
                                        <div class="card h-100 border-0 related-product-card">
                                            <div style="height: 150px; overflow: hidden;">
                                                @if($relatedProduct->first_image)
                                                    <img src="{{ asset('storage/' . $relatedProduct->first_image) }}" class="card-img-top related-product-img" alt="{{ $relatedProduct->name }}">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                        <i class="fas fa-image fa-2x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                                <p class="card-text text-primary fw-bold">${{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-cart-plus"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function changeMainImage(thumbnail, imageUrl) {
        // Cambiar la imagen principal
        document.getElementById('mainProductImage').src = imageUrl;
        
        // Actualizar la clase activa en las miniaturas
        document.querySelectorAll('.product-thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        thumbnail.classList.add('active');
    }
    
    function incrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        const maxQuantity = parseInt(quantityInput.getAttribute('max'));
        let currentValue = parseInt(quantityInput.value);
        
        if (currentValue < maxQuantity) {
            quantityInput.value = currentValue + 1;
        }
    }
    
    function decrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        let currentValue = parseInt(quantityInput.value);
        
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto 3D para las tarjetas de productos relacionados
        const productCards = document.querySelectorAll('.related-product-card');
        
        productCards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-10px) rotateY(5deg)';
            });
            
            card.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0) rotateY(0)';
            });
        });
    });
</script>
@endsection
