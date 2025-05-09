<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AgroGastro - Panel de Productor. Gestiona tus productos y pedidos de forma eficiente.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgroGastro') }} - Panel de Productor</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard-modern.css') }}" rel="stylesheet">
    <link href="{{ asset('css/producer-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/producer-3d-dashboard.css') }}" rel="stylesheet">

    @yield('styles')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.27/dist/lenis.min.js"></script>
</head>
<body>
    <div class="producer-dashboard-container">
        <!-- Sidebar -->
        <aside class="producer-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('producer.dashboard') }}" class="sidebar-brand">
                    <span style="color: #FFC107;">Agro</span><span style="color: #2196F3;">Gas</span><span style="color: #F44336;">tro</span>
                </a>
                <button class="sidebar-toggle d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="sidebar-user">
                @if(Auth::user()->store && Auth::user()->store->logo)
                    <img src="{{ asset('storage/' . Auth::user()->store->logo) }}" alt="{{ Auth::user()->store->name }}" class="sidebar-user-img">
                @else
                    <div class="sidebar-user-icon">
                        <i class="fas fa-store"></i>
                    </div>
                @endif
                <div class="sidebar-user-info">
                    <h6 class="sidebar-user-name">{{ Auth::user()->name }}</h6>
                    <p class="sidebar-user-role">Productor</p>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-menu-header">PRINCIPAL</li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('producer.dashboard') }}" class="{{ request()->routeIs('producer.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Panel Principal
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('producer.store.edit') }}" class="{{ request()->routeIs('producer.store.edit') ? 'active' : '' }}">
                        <i class="fas fa-store"></i> Mi Tienda
                    </a>
                </li>

                <li class="sidebar-menu-header">PRODUCTOS</li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('producer.products.index') }}" class="{{ request()->routeIs('producer.products.index') ? 'active' : '' }}">
                        <i class="fas fa-box"></i> Mis Productos
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('producer.products.create') }}" class="{{ request()->routeIs('producer.products.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> Nuevo Producto
                    </a>
                </li>

                <li class="sidebar-menu-header">PEDIDOS</li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('producer.orders.index') }}" class="{{ request()->routeIs('producer.orders.index') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Pedidos
                    </a>
                </li>

                <li class="sidebar-menu-header">CUENTA</li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-home"></i> Ver Tienda
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>

            <div class="sidebar-footer">
                <p>© {{ date('Y') }} AgroGastro</p>
                <p>Conectando productores con clientes</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="producer-main">
            <!-- Top Navbar -->
            <nav class="producer-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle d-none d-md-block" id="sidebarToggleLg">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="navbar-title">@yield('title', 'Panel de Productor')</h1>
                </div>
                <div class="navbar-right">
                    <div class="navbar-search">
                        <form action="{{ route('producer.products.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar productos...">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="navbar-user dropdown">
                        <a href="#" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('producer.store.edit') }}"><i class="fas fa-store me-2"></i> Mi Tienda</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                </a>
                                <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content Area -->
            <div class="producer-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="producer-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p>&copy; {{ date('Y') }} AgroGastro. Todos los derechos reservados.</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p>
                                Hecho con
                                <i class="fas fa-heart" style="color: #FFC107;"></i>
                                <i class="fas fa-heart" style="color: #2196F3;"></i>
                                <i class="fas fa-heart" style="color: #F44336;"></i>
                                para productores rurales
                            </p>
                        </div>
                    </div>
                    <div class="tricolor-bar mt-2" style="height: 3px; background: linear-gradient(to right, #FFC107 33.33%, #2196F3 33.33%, 66.66%, #F44336 66.66%);"></div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Incluir el script del dashboard 3D -->
    <script src="{{ asset('js/producer-3d-dashboard.js') }}"></script>

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar Lenis para scroll suave
            const lenis = new Lenis({
                duration: 1.2,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                direction: 'vertical',
                gestureDirection: 'vertical',
                smooth: true,
                mouseMultiplier: 1,
                smoothTouch: false,
                touchMultiplier: 2,
                infinite: false,
            });

            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }

            requestAnimationFrame(raf);

            // Inicializar AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });

            // Toggle sidebar en móvil
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleLg = document.getElementById('sidebarToggleLg');
            const sidebar = document.getElementById('sidebar');
            const container = document.querySelector('.producer-dashboard-container');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    container.classList.toggle('sidebar-open');
                });
            }

            if (sidebarToggleLg) {
                sidebarToggleLg.addEventListener('click', function() {
                    container.classList.toggle('sidebar-collapsed');
                });
            }

            // Efecto de profundidad en scroll
            window.addEventListener('scroll', function() {
                const scrollY = window.scrollY;
                const cards = document.querySelectorAll('.modern-card, .stat-card');

                cards.forEach((card, index) => {
                    const translateZ = Math.max(0, 50 - scrollY / 10);
                    const rotateX = Math.max(0, scrollY / 1000);
                    card.style.transform = `perspective(1000px) translateZ(${translateZ}px) rotateX(${rotateX}deg)`;
                });
            });
        });
    </script>
</body>
</html>
