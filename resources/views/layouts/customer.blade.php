<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AgroGastro - Panel de Cliente. Gestiona tus pedidos y perfil de forma eficiente.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgroGastro') }} - Panel de Cliente</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard-modern.css') }}" rel="stylesheet">
    <link href="{{ asset('css/customer-dashboard.css') }}" rel="stylesheet">

    <style>
        :root {
            --yellow: #FFC107;
            --yellow-light: #FFECB3;
            --yellow-dark: #FFA000;
            --blue: #2196F3;
            --blue-light: #BBDEFB;
            --blue-dark: #1976D2;
            --red: #F44336;
            --red-light: #FFCDD2;
            --red-dark: #D32F2F;
            --text-dark: #263238;
            --text-light: #FFFFFF;
            --background-light: #F5F7FA;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
        }

        .customer-dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .customer-sidebar {
            width: 280px;
            background: linear-gradient(135deg, #263238, #37474F);
            color: var(--text-light);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: var(--text-light);
        }

        .sidebar-toggle {
            background: transparent;
            border: none;
            color: var(--text-light);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .sidebar-user {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-user-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid var(--yellow);
        }

        .sidebar-user-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        .sidebar-user-info h6 {
            margin-bottom: 5px;
            font-weight: 600;
        }

        .sidebar-user-role {
            font-size: 0.8rem;
            opacity: 0.8;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu-header {
            padding: 15px 20px 5px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        .sidebar-menu-item a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu-item a:hover, .sidebar-menu-item a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            border-left-color: var(--yellow);
        }

        .sidebar-menu-item a i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 20px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        /* Main Content Styles */
        .customer-main {
            flex: 1;
            margin-left: 280px;
            transition: all 0.3s;
        }

        .customer-navbar {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            margin-left: 15px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
        }

        .navbar-user {
            margin-left: 20px;
        }

        .navbar-user a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-dark);
        }

        .navbar-user i {
            font-size: 1.5rem;
            margin-left: 10px;
        }

        .customer-content {
            padding: 30px;
        }

        /* Card Styles */
        .modern-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .modern-card-header {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modern-card-title {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .modern-card-title i {
            margin-right: 10px;
        }

        .modern-card-body {
            padding: 25px;
        }

        /* Animation Classes */
        .fade-in-up {
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .customer-sidebar {
                transform: translateX(-100%);
            }
            .customer-sidebar.active {
                transform: translateX(0);
            }
            .customer-main {
                margin-left: 0;
            }
        }

        /* Tricolor Bar (Colombia Flag Colors) */
        .tricolor-bar {
            height: 5px;
            background: linear-gradient(to right, var(--yellow) 33.33%, var(--blue) 33.33%, 66.66%, var(--red) 66.66%);
        }

        /* Estilos para el icono del carrito */
        .cart-icon {
            position: relative;
            transition: all 0.3s ease;
        }

        .cart-icon:hover {
            transform: translateY(-3px);
            color: var(--yellow);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background-color: var(--red);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>

    @yield('styles')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.27/dist/lenis.min.js"></script>
</head>
<body>
    <div class="customer-dashboard-container">
        <!-- Sidebar -->
        <aside class="customer-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('customer.dashboard') }}" class="sidebar-brand">
                    <span style="color: #FFC107;">Agro</span><span style="color: #2196F3;">Gas</span><span style="color: #F44336;">tro</span>
                </a>
                <button class="sidebar-toggle d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="sidebar-user">
                <div class="sidebar-user-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="sidebar-user-info">
                    <h6 class="sidebar-user-name">{{ Auth::user()->name }}</h6>
                    <p class="sidebar-user-role">Cliente</p>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-menu-header">PRINCIPAL</li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Panel Principal
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-user-edit"></i> Mi Perfil
                    </a>
                </li>

                <li class="sidebar-menu-header">COMPRAS</li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag"></i> Mis Pedidos
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.index') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Mi Carrito
                        @if (session()->has('cart') && count(session()->get('cart')) > 0)
                            <span class="badge bg-danger rounded-pill ms-2">{{ count(session()->get('cart')) }}</span>
                        @endif
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
                <div class="tricolor-bar mt-2"></div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="customer-main">
            <!-- Top Navbar -->
            <nav class="customer-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle d-none d-md-block" id="sidebarToggleLg">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="navbar-title">@yield('title', 'Panel de Cliente')</h1>
                </div>
                <div class="navbar-right">
                    <!-- Cart Icon -->
                    <div class="me-4">
                        <a href="{{ route('cart.index') }}" class="nav-link cart-icon">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            @php
                                $cartCount = 0;
                                $cart = session()->get('cart', []);
                                foreach($cart as $item) {
                                    $cartCount += $item['quantity'];
                                }
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>

                    <div class="navbar-user dropdown">
                        <a href="#" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-shopping-bag me-2"></i> Mis Pedidos</a></li>
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

            <!-- Page Content -->
            <div class="customer-content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="p-4 border-top">
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
                                para clientes
                            </p>
                        </div>
                    </div>
                    <div class="tricolor-bar mt-2"></div>
                </div>
            </footer>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });

            // Inicializar Lenis para smooth scrolling
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

            // Toggle Sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleLg = document.getElementById('sidebarToggleLg');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            if (sidebarToggleLg) {
                sidebarToggleLg.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
