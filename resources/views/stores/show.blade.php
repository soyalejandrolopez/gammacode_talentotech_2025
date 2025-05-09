@extends('layouts.app')

@section('title', $store->name)

@section('styles')
<style>
    :root {
        --primary-color: #2E7D32;
        --secondary-color: #FFA000;
        --accent-color: #FF5722;
        --text-color: #333;
        --light-bg: #f8f9fa;
        --border-radius: 15px;
    }

    body {
        background-color: #f5f7fa;
    }

    .store-header {
        position: relative;
        margin-bottom: 2rem;
    }

    .store-banner {
        height: 300px;
        background-size: cover;
        background-position: center;
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .store-banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.7));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .store-logo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .store-logo:hover {
        transform: scale(1.05);
    }

    .store-title {
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        margin-top: 1rem;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .store-subtitle {
        color: rgba(255, 255, 255, 0.9);
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    .store-info-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .store-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .store-info-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1.5rem;
        position: relative;
    }

    .store-info-header h3 {
        margin: 0;
        font-weight: 600;
    }

    .store-info-body {
        padding: 1.5rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background-color: var(--light-bg);
        border-radius: 10px;
        transition: transform 0.2s ease;
    }

    .contact-item:hover {
        transform: translateX(5px);
        background-color: rgba(46, 125, 50, 0.1);
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .whatsapp-btn {
        background-color: #25D366;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .whatsapp-btn:hover {
        background-color: #128C7E;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .products-section {
        margin-top: 2rem;
    }

    .products-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .products-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-color);
        margin: 0;
    }

    .product-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .product-img {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img img {
        transform: scale(1.1);
    }

    .product-category {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 10;
    }

    .product-body {
        padding: 1.5rem;
    }

    .product-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .product-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .product-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }

    .btn-view {
        background-color: transparent;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        border-radius: 50px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-cart {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-cart:hover {
        background-color: var(--secondary-color);
        transform: translateY(-3px);
    }

    .empty-products {
        text-align: center;
        padding: 3rem 0;
        background-color: var(--light-bg);
        border-radius: var(--border-radius);
    }

    .empty-icon {
        font-size: 4rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        color: var(--text-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        color: var(--primary-color);
        transform: translateX(-5px);
    }

    .back-btn i {
        margin-right: 0.5rem;
    }

    @media (max-width: 768px) {
        .store-banner {
            height: 200px;
        }

        .store-logo {
            width: 100px;
            height: 100px;
        }

        .store-title {
            font-size: 1.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <a href="{{ url()->previous() }}" class="back-btn mb-4">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    <!-- Store Header -->
    <div class="store-header">
        <div class="store-banner" style="background-image: url('{{ $store->banner_url }}')">
            <div class="store-banner-overlay">
                <div class="text-center">
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="store-logo">
                    <h1 class="store-title">{{ $store->name }}</h1>
                    @if($store->products->count() > 0)
                        <p class="store-subtitle">{{ $store->products->count() }} productos disponibles</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Store Info -->
        <div class="col-lg-4 mb-4">
            <div class="store-info-card">
                <div class="store-info-header">
                    <h3><i class="fas fa-store me-2"></i> Información de la Tienda</h3>
                </div>
                <div class="store-info-body">
                    <p class="mb-4">{{ $store->description }}</p>

                    <h4 class="mb-3">Contacto</h4>
                    @if($store->phone)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Teléfono</div>
                                <div>{{ $store->phone }}</div>
                            </div>
                        </div>
                    @endif

                    @if($store->email)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Correo Electrónico</div>
                                <div>{{ $store->email }}</div>
                            </div>
                        </div>
                    @endif

                    @if($store->address)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Dirección</div>
                                <div>{{ $store->address }}</div>
                            </div>
                        </div>
                    @endif

                    @if($store->whatsapp)
                        <div class="mt-4">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->whatsapp) }}" class="whatsapp-btn w-100" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i> Contactar por WhatsApp
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Store Products -->
        <div class="col-lg-8">
            <div class="products-section">
                <div class="products-header">
                    <h2 class="products-title">Productos</h2>
                    @if($store->products->count() > 0)
                        <div class="d-flex align-items-center">
                            <span class="text-muted me-2">Ordenar por:</span>
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option>Más recientes</option>
                                <option>Precio: Menor a Mayor</option>
                                <option>Precio: Mayor a Menor</option>
                                <option>Nombre: A-Z</option>
                            </select>
                        </div>
                    @endif
                </div>

                @if($store->products->count() > 0)
                    <div class="row g-4">
                        @foreach($store->products as $product)
                            <div class="col-md-6 col-lg-4">
                                <div class="product-card">
                                    @if($product->category)
                                        <div class="product-category">{{ $product->category->name }}</div>
                                    @endif
                                    <div class="product-img">
                                        @if($product->first_image)
                                            <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-title">{{ $product->name }}</h3>
                                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                                        <div class="product-price">${{ number_format($product->price, 0, ',', '.') }}</div>
                                        <div class="product-actions">
                                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-view">
                                                Ver detalles
                                            </a>
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-cart" title="Añadir al carrito">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-products">
                        <i class="fas fa-box-open empty-icon"></i>
                        <h3 class="mb-3">No hay productos disponibles</h3>
                        <p class="text-muted mb-4">Esta tienda aún no ha publicado productos.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Explorar otros productos</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
