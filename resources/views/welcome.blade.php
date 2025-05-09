<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AgroGastro - Connecting farmers directly with customers. Fresh products from the field to your table.">

    <title>{{ config('app.name', 'AgroGastro') }} - Del Campo a Tu Mesa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://unpkg.com/lenis@1.3.1/dist/lenis.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2E7D32;
            --primary-light: #60ad5e;
            --primary-dark: #005005;
            --secondary: #FFA000;
            --secondary-light: #ffd149;
            --secondary-dark: #c67100;
            --text-dark: #263238;
            --text-light: #FFFFFF;
            --background-light: #F5F7FA;
        }

        html.lenis {
            height: auto;
        }

        .lenis.lenis-smooth {
            scroll-behavior: auto;
        }

        .lenis.lenis-smooth [data-lenis-prevent] {
            overscroll-behavior: contain;
        }

        .lenis.lenis-stopped {
            overflow: hidden;
        }

        .lenis.lenis-scrolling iframe {
            pointer-events: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url('https://images.pexels.com/photos/2255935/pexels-photo-2255935.jpeg') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            overflow: hidden;
        }



        .hero-content {
            text-align: center;
            z-index: 10;
            max-width: 800px;
            padding: 2rem;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .btn-primary-custom {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary-custom {
            background-color: var(--secondary);
            border-color: var(--secondary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-secondary-custom:hover {
            background-color: var(--secondary-dark);
            border-color: var(--secondary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            position: relative;
            margin-bottom: 3rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--secondary);
            border-radius: 2px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            border-bottom: 5px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-bottom: 5px solid var(--primary);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .category-card {
            position: relative;
            height: 250px;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.5s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .category-card:hover img {
            transform: scale(1.1);
        }

        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 20px;
            color: white;
        }

        .product-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            height: 200px;
            overflow: hidden;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .product-card:hover .product-img img {
            transform: scale(1.1);
        }

        .store-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .store-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .store-logo {
            position: absolute;
            left: 20px;
            z-index: 10;
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin: 1rem;
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 5rem;
            color: var(--primary-light);
            opacity: 0.2;
            font-family: 'Playfair Display', serif;
        }

        .connect-section {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-dark));
            color: white;
            padding: 5rem 0;
        }

        .whatsapp-btn {
            background-color: #25D366;
            color: white;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .whatsapp-btn:hover {
            background-color: #128C7E;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .footer {
            background-color: #263238;
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--secondary);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #B0BEC5;
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: white;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background-color: var(--secondary);
            transform: translateY(-3px);
        }

        .navbar-custom {
            transition: all 0.3s ease;
            background-color: transparent;
        }

        .navbar-scrolled {
            background-color: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-scrolled .nav-link {
            color: var(--text-dark) !important;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="text-white fw-bold">Agro<span class="text-warning">Gastro</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#features">Beneficios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#categories">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#stores">Productores</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonios</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Ver Todas las Categorías</a></li>
                    @if (Route::has('login'))
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                            @elseif(auth()->user()->hasRole('producer'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('producer.dashboard') }}">Panel Productor</a></li>
                            @elseif(auth()->user()->hasRole('customer'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('customer.dashboard') }}">Mi Panel</a></li>
                            @endif
                            <li class="nav-item">
                                <a class="btn btn-outline-light ms-3" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Ingresar</a></li>
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="btn btn-secondary-custom ms-3" href="{{ route('register') }}">Registrarse</a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">Del Campo a Tu Mesa</h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">Conectamos productores locales directamente con los consumidores. Productos frescos, naturales y de temporada.</p>
            <div data-aos="fade-up" data-aos-delay="300">
                <a href="#products" class="btn btn-primary-custom me-3">Explorar Productos</a>
                <a href="#stores" class="btn btn-secondary-custom">Ver Productores</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light" id="features">
        <div class="container py-5">
            <h2 class="text-center section-title" data-aos="fade-up">¿Por qué elegir AgroGastro?</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3 class="h4 mb-3">Productos Frescos</h3>
                        <p class="text-muted">Directo del campo a tu mesa. Garantizamos la frescura y calidad de todos nuestros productos.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="h4 mb-3">Apoyo Local</h3>
                        <p class="text-muted">Apoya a los agricultores y productores locales comprando directamente de ellos sin intermediarios.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3 class="h4 mb-3">Entrega Rápida</h3>
                        <p class="text-muted">Recibe tus productos en la puerta de tu casa en el menor tiempo posible.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5" id="categories">
        <div class="container py-5">
            <h2 class="text-center section-title" data-aos="fade-up">Explora Nuestras Categorías</h2>
            <div class="row">
                @php
                    $categories = \App\Models\Category::where('is_active', true)->get();
                    $delay = 100;
                @endphp

                @foreach($categories as $category)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                        <a href="{{ route('category', $category->slug) }}" class="text-decoration-none">
                            <div class="category-card">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                @else
                                    <img src="https://via.placeholder.com/600x400?text={{ urlencode($category->name) }}" alt="{{ $category->name }}">
                                @endif
                                <div class="category-overlay">
                                    <h3>{{ $category->name }}</h3>
                                    <p>{{ $category->description }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @php $delay += 100; @endphp
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5 bg-light" id="products">
        <div class="container py-5">
            <h2 class="text-center section-title" data-aos="fade-up">Productos Destacados</h2>
            <div class="row g-4">
                @php
                    $featuredProducts = \App\Models\Product::where('is_active', true)
                        ->where('is_featured', true)
                        ->with(['store', 'category'])
                        ->take(6)
                        ->get();
                    $delay = 100;
                @endphp

                @foreach($featuredProducts as $product)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                        <div class="product-card h-100">
                            <div class="product-img">
                                @if($product->first_image)
                                    <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/600x400?text={{ urlencode($product->name) }}" alt="{{ $product->name }}">
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h3 class="h5 mb-0">{{ $product->name }}</h3>
                                    @if($product->category)
                                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-2">{{ $product->store->name }}</p>
                                <p class="text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">${{ number_format($product->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Ver Detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $delay += 100; @endphp
                @endforeach
            </div>
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('products.index') }}" class="btn btn-primary-custom me-2">Ver Todos los Productos</a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Ver Todas las Categorías</a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5" id="testimonials">
        <div class="container py-5">
            <h2 class="text-center section-title" data-aos="fade-up">Lo Que Dicen Nuestros Clientes</h2>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <p class="mb-4">"Desde que compro en AgroGastro, la calidad de los alimentos que consumimos en casa ha mejorado notablemente. Puedo sentir la diferencia en sabor y frescura."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg" alt="Cliente" class="rounded-circle me-3" width="60" height="60">
                            <div>
                                <h5 class="mb-0">María González</h5>
                                <small class="text-muted">Cliente Frecuente</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <p class="mb-4">"Como productor, esta plataforma me ha permitido conectar directamente con mis clientes y recibir un precio justo por mi trabajo. Es una relación donde todos ganamos."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://images.pexels.com/photos/2382895/pexels-photo-2382895.jpeg" alt="Productor" class="rounded-circle me-3" width="60" height="60">
                            <div>
                                <h5 class="mb-0">Carlos Mendoza</h5>
                                <small class="text-muted">Productor de Frutas</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <p class="mb-4">"Me encanta saber exactamente de dónde vienen mis alimentos y poder apoyar directamente a los agricultores locales. Los productos son increíbles y el servicio es excelente."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg" alt="Cliente" class="rounded-circle me-3" width="60" height="60">
                            <div>
                                <h5 class="mb-0">Javier Rodríguez</h5>
                                <small class="text-muted">Chef Profesional</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stores Section -->
    <section class="py-5" id="stores">
        <div class="container py-5">
            <h2 class="text-center section-title" data-aos="fade-up">Nuestros Productores</h2>
            <div class="row g-4">
                @php
                    $stores = \App\Models\Store::where('is_active', true)->get();
                    $delay = 100;
                @endphp

                @foreach($stores as $store)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                        <div class="store-card h-100">
                            <div class="store-banner">
                                @if($store->banner)
                                    <img src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->name }}" class="w-100" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <h3>{{ $store->name }}</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="store-logo">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="rounded-circle border border-3 border-white" style="width: 80px; height: 80px; object-fit: cover; margin-top: -40px; background: white;">
                                @else
                                    <div class="rounded-circle border border-3 border-white d-flex align-items-center justify-content-center bg-light" style="width: 80px; height: 80px; margin-top: -40px;">
                                        <i class="fas fa-store fa-2x text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="h5 mb-2">{{ $store->name }}</h3>
                                <p class="text-muted mb-3">{{ Str::limit($store->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('stores.show', $store->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Ver Tienda</a>
                                    @if($store->whatsapp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->whatsapp) }}" class="btn btn-sm btn-success rounded-pill" target="_blank">
                                            <i class="fab fa-whatsapp me-1"></i> Contactar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $delay += 100; @endphp
                @endforeach
            </div>
        </div>
    </section>

    <!-- Copyright Section -->
    <section class="py-4 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} AgroGastro. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Diseñado para agricultores y consumidores</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            disable: 'mobile' // Disable on mobile for better performance
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Simple hover effects for category cards
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-10px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>