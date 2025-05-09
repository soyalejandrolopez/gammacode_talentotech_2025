@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<style>
    /* Estilos para la página de producto */
    .product-container {
        background-color: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .product-image-main {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .product-image-main:hover {
        transform: scale(1.02);
    }

    .product-image-main img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-image-main:hover img {
        transform: scale(1.05);
    }

    .product-thumbnails {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .product-thumbnail {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .product-thumbnail:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-thumbnail.active {
        border-color: var(--primary);
    }

    .product-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        padding: 30px;
    }

    .product-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--text-dark);
        position: relative;
        display: inline-block;
    }

    .product-title::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(to right, var(--primary), var(--primary-light));
        border-radius: 3px;
    }

    .product-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .product-badge {
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        margin-left: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-badge.in-stock {
        background-color: rgba(46, 125, 50, 0.1);
        color: var(--primary);
    }

    .product-badge.out-stock {
        background-color: rgba(211, 47, 47, 0.1);
        color: #D32F2F;
    }

    .product-description {
        margin-bottom: 30px;
        padding: 20px;
        background-color: rgba(245, 247, 250, 0.5);
        border-radius: 15px;
        border-left: 4px solid var(--primary-light);
    }

    .product-description p {
        line-height: 1.8;
        color: #546E7A;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--text-dark);
        position: relative;
        display: inline-block;
        padding-left: 15px;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(to bottom, var(--primary), var(--primary-light));
        border-radius: 2px;
    }

    .store-info {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        transition: transform 0.3s ease;
    }

    .store-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .store-logo {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 15px;
        border: 3px solid var(--primary-light);
    }

    .store-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .store-details h6 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .store-link {
        color: var(--primary);
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .store-link:hover {
        color: var(--primary-dark);
        transform: translateX(5px);
    }

    .store-link i {
        margin-left: 5px;
        font-size: 0.8rem;
    }

    .action-button {
        display: block;
        width: 100%;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin-bottom: 12px;
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0));
        z-index: -1;
        transition: all 0.3s ease;
    }

    .action-button:hover::before {
        transform: translateX(100%);
    }

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .whatsapp-button {
        background: linear-gradient(45deg, #25D366, #128C7E);
        color: white;
    }

    .cart-button {
        background: linear-gradient(45deg, var(--secondary), var(--secondary-dark));
        color: white;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        background-color: #f5f7fa;
        border-radius: 25px;
        padding: 3px 12px;
        width: fit-content;
    }

    .quantity-selector label {
        margin-right: 8px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .quantity-selector input {
        width: 50px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    .quantity-selector input:focus {
        outline: none;
    }

    /* Estilos para productos relacionados */
    .related-products-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        position: relative;
        padding-bottom: 15px;
    }

    .related-products-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(to right, var(--primary), var(--primary-light));
        border-radius: 3px;
    }

    .related-product-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
    }

    .related-product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .related-product-img {
        height: 180px;
        overflow: hidden;
    }

    .related-product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .related-product-card:hover .related-product-img img {
        transform: scale(1.1);
    }

    .related-product-body {
        padding: 20px;
    }

    .related-product-title {
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .related-product-price {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.2rem;
    }

    .related-product-button {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        background-color: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .related-product-button:hover {
        background-color: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4 fade-in">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Productos</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="product-container mb-5">
        <div class="row g-0">
            <div class="col-lg-6 p-4 fade-in">
                <div class="product-image-main" id="mainImage">
                    @if($product->first_image)
                        <a href="{{ asset('storage/' . $product->first_image) }}" data-fancybox="gallery">
                            <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="main-img">
                        </a>
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>

                @if(!empty($product->images) && is_array($product->images) && count($product->images) > 1)
                    <div class="product-thumbnails">
                        @foreach($product->images as $index => $image)
                            <div class="product-thumbnail {{ $index === 0 ? 'active' : '' }}" data-image="{{ asset('storage/' . $image) }}">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title fade-in">{{ $product->name }}</h1>

                    <div class="product-price fade-in delay-1">
                        ${{ number_format($product->price, 0, ',', '.') }}
                        <span class="product-badge {{ $product->stock > 0 ? 'in-stock' : 'out-stock' }}">
                            {{ $product->stock > 0 ? 'En Stock' : 'Agotado' }}
                        </span>
                    </div>

                    @if($product->category)
                        <div class="mb-3 fade-in delay-1">
                            <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
                        </div>
                    @endif

                    <div class="product-description fade-in delay-2">
                        <h3 class="section-title">Descripción</h3>
                        <p>{{ $product->description ?: 'No hay descripción disponible para este producto.' }}</p>
                    </div>

                    <div class="store-info fade-in delay-3">
                        <div class="store-logo">
                            @if($product->store->logo)
                                <img src="{{ asset('storage/' . $product->store->logo) }}" alt="{{ $product->store->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-store text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="store-details">
                            <h6>{{ $product->store->name }}</h6>
                            <a href="{{ route('stores.show', $product->store) }}" class="store-link">
                                Visitar Tienda <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="fade-in delay-4">
                        @if($product->store->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp) }}?text=Hola, estoy interesado en el producto: {{ $product->name }}" class="action-button whatsapp-button" target="_blank">
                                <i class="fab fa-whatsapp me-1"></i> Contactar por WhatsApp
                            </a>
                        @endif

                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="quantity-selector">
                                    <label for="quantity">Cantidad:</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                                </div>
                                <button type="submit" class="action-button cart-button">
                                    <i class="fas fa-shopping-cart me-1"></i> Añadir al Carrito
                                </button>
                            </form>
                        @else
                            <button disabled class="action-button" style="background-color: #ccc; color: #666;">
                                <i class="fas fa-times-circle me-1"></i> Producto Agotado
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-5 pt-4 fade-in delay-5">
            <h2 class="related-products-title">Productos Relacionados</h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col">
                        <div class="related-product-card">
                            <div class="related-product-img">
                                @if($relatedProduct->first_image)
                                    <img src="{{ asset('storage/' . $relatedProduct->first_image) }}" alt="{{ $relatedProduct->name }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="related-product-body">
                                <h5 class="related-product-title">{{ $relatedProduct->name }}</h5>
                                <p class="text-muted small mb-3">{{ Str::limit($relatedProduct->description, 60) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="related-product-price">${{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" class="related-product-button">
                                        <i class="fas fa-eye me-1"></i> Ver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Fancybox para la galería
        Fancybox.bind("[data-fancybox]", {
            // Opciones de Fancybox
        });

        // Cambiar imagen principal al hacer clic en miniaturas
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        const mainImg = document.querySelector('.main-img');
        const mainImageLink = document.querySelector('#mainImage a');

        if (thumbnails.length > 0 && mainImg) {
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Actualizar imagen principal
                    const newImageSrc = this.getAttribute('data-image');
                    mainImg.src = newImageSrc;

                    // Actualizar enlace de Fancybox
                    if (mainImageLink) {
                        mainImageLink.setAttribute('href', newImageSrc);
                    }

                    // Actualizar clase activa
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }

        // Efecto 3D en hover para la imagen principal
        const mainImageContainer = document.querySelector('.product-image-main');

        if (mainImageContainer) {
            mainImageContainer.addEventListener('mousemove', function(e) {
                const { left, top, width, height } = this.getBoundingClientRect();
                const x = (e.clientX - left) / width;
                const y = (e.clientY - top) / height;

                const rotateX = 5 * (0.5 - y);
                const rotateY = 5 * (x - 0.5);

                this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });

            mainImageContainer.addEventListener('mouseleave', function() {
                this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
            });
        }
    });
</script>
@endsection
