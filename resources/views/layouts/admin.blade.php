<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4CAF50">
    <meta name="description" content="Panel de administración de AgroGastro - Conectando productores rurales con consumidores">

    <title>{{ config('app.name', 'AgroGastro') }} - Panel de Administración</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        :root {
            /* Paleta de colores más orgánica y natural */
            --primary: #4CAF50;
            --primary-light: #81C784;
            --primary-dark: #388E3C;
            --secondary: #FFC107;
            --secondary-light: #FFD54F;
            --secondary-dark: #FFA000;
            --accent: #8D6E63;
            --accent-light: #A1887F;
            --accent-dark: #6D4C41;
            --success: #66BB6A;
            --warning: #FFA726;
            --danger: #EF5350;
            --info: #29B6F6;
            --light-bg: #F7F9F4;
            --dark-bg: #1E2A23;

            /* Variables de diseño */
            --sidebar-width: 280px;
            --topbar-height: 70px;
            --card-border-radius: 16px;
            --transition-speed: 0.3s;
            --box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            --box-shadow-hover: 0 12px 30px rgba(0, 0, 0, 0.08);
            --box-shadow-strong: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            overflow-x: hidden;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar con estilo más orgánico */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(165deg, var(--primary-dark), var(--primary));
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            box-shadow: 3px 0 20px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed);
            border-radius: 0 20px 20px 0;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='rgba(255,255,255,0.05)' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.5;
            z-index: -1;
        }

        .sidebar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-brand span {
            color: var(--secondary);
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.2));
        }

        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
            position: relative;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all var(--transition-speed);
            border-left: 3px solid transparent;
            margin: 5px 0;
            border-radius: 0 10px 10px 0;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 100%);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: -1;
        }

        .sidebar-menu a:hover {
            color: white;
            border-left-color: var(--secondary);
            transform: translateX(5px);
        }

        .sidebar-menu a:hover::before {
            transform: translateX(0);
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: var(--secondary);
            font-weight: 600;
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .menu-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 15px 20px;
        }

        .sidebar-heading {
            padding: 0 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .sidebar-footer-content {
            display: flex;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .bg-secondary-light {
            background-color: var(--secondary-light);
        }

        .text-secondary {
            color: var(--secondary-dark);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
        }

        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Estilos para el content-wrapper */
        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all var(--transition-speed);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Estilos para la topbar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 25px;
            background-color: white;
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            position: sticky;
            top: 20px;
            z-index: 99;
        }

        .topbar.glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .topbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .topbar-toggler {
            display: none;
            background: none;
            border: none;
            color: #555;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 5px;
            margin-right: 15px;
            transition: all 0.3s;
        }

        .topbar-toggler:hover {
            color: var(--primary);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .btn-icon:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            padding: 5px 10px;
            border-radius: 30px;
            transition: all 0.3s;
        }

        .user-dropdown:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .dropdown-user-details {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
        }

        .notifications-dropdown {
            width: 320px;
            padding: 0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--box-shadow-strong);
            border: none;
        }

        .dropdown-header {
            padding: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: rgba(0, 0, 0, 0.02);
        }

        .notifications-list {
            max-height: 320px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .notification-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .notification-item.unread {
            background-color: rgba(76, 175, 80, 0.05);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .notification-content {
            flex: 1;
        }

        .dropdown-footer {
            padding: 10px;
            text-align: center;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Estilos para el contenido principal */
        .content {
            flex: 1;
            padding-bottom: 30px;
        }

        /* Estilos para las tarjetas de estadísticas */
        .stats-card {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: var(--card-border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            transition: all 0.3s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            box-shadow: var(--box-shadow-hover);
            transform: translateY(-5px);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 20px;
        }

        .stats-info {
            flex: 1;
        }

        .stats-info h3 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: #555;
        }

        .stats-info p {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }

        .stats-badge {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .bg-primary-light {
            background-color: rgba(76, 175, 80, 0.15);
        }

        .bg-success-light {
            background-color: rgba(102, 187, 106, 0.15);
        }

        .bg-warning-light {
            background-color: rgba(255, 167, 38, 0.15);
        }

        .bg-info-light {
            background-color: rgba(41, 182, 246, 0.15);
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-success {
            color: var(--success) !important;
        }

        .text-warning {
            color: var(--warning) !important;
        }

        .text-info {
            color: var(--info) !important;
        }

        /* Clase para SweetAlert2 */
        .swal-border-radius {
            border-radius: 15px !important;
        }

        /* Animaciones */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
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

        /* Estilos para las tarjetas de gráficos */
        .chart-card {
            background-color: white;
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            transition: all 0.3s;
            height: 100%;
        }

        .chart-card:hover {
            box-shadow: var(--box-shadow-hover);
        }

        .chart-card .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: transparent;
        }

        .chart-card .card-body {
            padding: 20px;
        }

        .chart-card .card-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .content-wrapper {
                margin-left: 0;
            }

            .content-wrapper.active {
                margin-left: var(--sidebar-width);
            }

            .topbar-toggler {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 15px;
            }

            .topbar {
                padding: 10px 15px;
                margin-bottom: 15px;
            }

            .stats-card {
                padding: 15px;
            }

            .stats-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
                margin-right: 15px;
            }

            .stats-info h3 {
                font-size: 0.9rem;
            }

            .stats-info p {
                font-size: 1.5rem;
            }
        }

        /* Estilos para las tablas */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: #555;
            border-top: none;
            border-bottom-width: 1px;
        }

        .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }

        .order-row {
            transition: all 0.3s;
        }

        .order-row:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Estilos para los gráficos 3D */
        .three-dimensional {
            filter: drop-shadow(0px 10px 10px rgba(0, 0, 0, 0.1));
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    Agro<span>Gastro</span>
                </a>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-seedling"></i> Panel de Control
                    </a>
                </li>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Gestión</div>

                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Usuarios
                        <span class="menu-badge">{{ \App\Models\User::count() }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stores.index') }}" class="{{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                        <i class="fas fa-store"></i> Tiendas
                        <span class="menu-badge">{{ \App\Models\Store::count() }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-carrot"></i> Productos
                        <span class="menu-badge">{{ \App\Models\Product::count() }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-basket"></i> Pedidos
                        <span class="menu-badge">{{ \App\Models\Order::count() }}</span>
                    </a>
                </li>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Informes y Configuración</div>

                <li>
                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fas fa-file-pdf"></i> Reportes
                        <span class="menu-badge bg-danger">PDF</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Ajustes
                    </a>
                </li>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Acceso Rápido</div>

                <li>
                    <a href="{{ route('home') }}" target="_blank" class="external-link">
                        <i class="fas fa-home"></i> Ver Sitio
                        <i class="fas fa-external-link-alt ms-auto small"></i>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="sidebar-footer-content">
                    <div class="user-info">
                        <div class="avatar-circle bg-secondary-light text-secondary">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">Administrador</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper" id="content-wrapper">
            <!-- Topbar -->
            <header class="topbar glass">
                <button class="topbar-toggler" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <h1 class="topbar-title">@yield('title', 'Panel de Administración')</h1>

                <div class="topbar-actions">
                    <!-- Notificaciones -->
                    <div class="dropdown me-3">
                        <button class="btn btn-icon btn-light position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                                <span class="visually-hidden">notificaciones no leídas</span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropdown">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Notificaciones</span>
                                <a href="#" class="text-muted small">Marcar todas como leídas</a>
                            </div>
                            <div class="notifications-list">
                                <a href="#" class="dropdown-item notification-item unread">
                                    <div class="notification-icon bg-primary-light text-primary">
                                        <i class="fas fa-shopping-basket"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="mb-1">Nuevo pedido recibido</p>
                                        <span class="text-muted small">Hace 5 minutos</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item notification-item unread">
                                    <div class="notification-icon bg-success-light text-success">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="mb-1">Nuevo usuario registrado</p>
                                        <span class="text-muted small">Hace 2 horas</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item notification-item unread">
                                    <div class="notification-icon bg-warning-light text-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="mb-1">Alerta de sistema</p>
                                        <span class="text-muted small">Hace 1 día</span>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer">
                                <a href="#" class="text-center d-block">Ver todas las notificaciones</a>
                            </div>
                        </div>
                    </div>

                    <!-- Perfil de usuario -->
                    <div class="dropdown">
                        <button class="dropdown-toggle user-dropdown" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle me-2 bg-primary-light text-primary">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="d-none d-md-inline me-2">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <div class="dropdown-user-details">
                                    <div class="avatar-circle bg-primary-light text-primary">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                        <span class="text-muted small">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fas fa-home me-2"></i> Inicio</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.8/countUp.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('content-wrapper');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    contentWrapper.classList.toggle('active');
                });
            }

            // Cerrar sidebar al hacer clic fuera en móviles
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickInsideToggler = sidebarToggle.contains(event.target);

                if (window.innerWidth <= 992 && !isClickInsideSidebar && !isClickInsideToggler && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    contentWrapper.classList.remove('active');
                }
            });

            // SweetAlert para confirmaciones de eliminación
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4CAF50',
                        cancelButtonColor: '#EF5350',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            popup: 'swal-border-radius'
                        },
                        // Eliminamos las animaciones que pueden causar problemas
                        showClass: {
                            popup: ''
                        },
                        hideClass: {
                            popup: ''
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Enviar el formulario directamente sin mostrar indicador de carga
                            form.submit();
                        }
                    });
                });
            });

            // Animaciones de entrada
            gsap.from('.sidebar', {
                x: -50,
                opacity: 0,
                duration: 0.8,
                ease: 'power3.out'
            });

            gsap.from('.topbar', {
                y: -20,
                opacity: 0,
                duration: 0.5,
                ease: 'power3.out',
                delay: 0.2
            });

            gsap.from('.content > *', {
                y: 30,
                opacity: 0,
                duration: 0.6,
                stagger: 0.1,
                ease: 'power3.out',
                delay: 0.3
            });

            // Efecto hover en cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    gsap.to(this, {
                        y: -5,
                        boxShadow: '0 15px 35px rgba(0, 0, 0, 0.1)',
                        duration: 0.3
                    });
                });

                card.addEventListener('mouseleave', function() {
                    gsap.to(this, {
                        y: 0,
                        boxShadow: '0 8px 25px rgba(0, 0, 0, 0.05)',
                        duration: 0.3
                    });
                });
            });

            // Inicializar contadores si existen
            const counters = document.querySelectorAll('.counter');
            if (counters.length > 0) {
                counters.forEach(counter => {
                    const value = parseInt(counter.getAttribute('data-value'));
                    const countUp = new CountUp(counter, 0, value, 0, 2.5, {
                        useEasing: true,
                        useGrouping: true,
                        separator: ',',
                        decimal: '.'
                    });

                    if (!countUp.error) {
                        countUp.start();
                    }
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
