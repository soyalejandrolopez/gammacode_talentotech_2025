@extends('layouts.admin')

@section('title', 'Panel de Control')

@section('styles')
<link href="{{ asset('css/dashboard-modern.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Resumen de estadísticas -->
    <div class="card mb-4 fade-in-up">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-chart-line text-primary me-2"></i>
                <span class="fw-bold">Resumen de Rendimiento</span>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Últimos 30 días
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="periodDropdown">
                    <li><a class="dropdown-item active" href="#">Últimos 30 días</a></li>
                    <li><a class="dropdown-item" href="#">Este mes</a></li>
                    <li><a class="dropdown-item" href="#">Último trimestre</a></li>
                    <li><a class="dropdown-item" href="#">Este año</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="d-flex flex-column align-items-center">
                        <div class="display-4 fw-bold text-primary mb-2">{{ number_format($totalOrders) }}</div>
                        <div class="text-muted">Pedidos Totales</div>
                        <div class="badge bg-success mt-2">
                            <i class="fas fa-arrow-up me-1"></i>12.5%
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="d-flex flex-column align-items-center">
                        <div class="display-4 fw-bold text-success mb-2">${{ number_format($totalRevenue ?? 15750, 0) }}</div>
                        <div class="text-muted">Ingresos Totales</div>
                        <div class="badge bg-success mt-2">
                            <i class="fas fa-arrow-up me-1"></i>8.3%
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="d-flex flex-column align-items-center">
                        <div class="display-4 fw-bold text-info mb-2">{{ number_format($totalUsers) }}</div>
                        <div class="text-muted">Usuarios Registrados</div>
                        <div class="badge bg-success mt-2">
                            <i class="fas fa-arrow-up me-1"></i>5.2%
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="d-flex flex-column align-items-center">
                        <div class="display-4 fw-bold text-warning mb-2">{{ number_format($totalProducts) }}</div>
                        <div class="text-muted">Productos Activos</div>
                        <div class="badge bg-success mt-2">
                            <i class="fas fa-arrow-up me-1"></i>15.7%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card primary fade-in-up">
                <div class="stats-icon bg-primary-light text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-info">
                    <h3>Usuarios Activos</h3>
                    <p class="counter">{{ $totalUsers }}</p>
                    <small class="text-muted">+{{ $newUsers }} nuevos esta semana</small>
                </div>
                <div class="stats-badge">
                    <span class="badge bg-primary rounded-pill">
                        <i class="fas fa-arrow-up me-1"></i>{{ ($totalUsers - $newUsers) > 0 ? round(($newUsers / ($totalUsers - $newUsers)) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card success fade-in-up" style="animation-delay: 0.1s">
                <div class="stats-icon bg-success-light text-success">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stats-info">
                    <h3>Tiendas Verificadas</h3>
                    <p class="counter">{{ $activeStores }}</p>
                    <small class="text-muted">+{{ $newStores }} nuevas esta semana</small>
                </div>
                <div class="stats-badge">
                    <span class="badge bg-success rounded-pill">
                        <i class="fas fa-arrow-up me-1"></i>{{ $totalStores > 0 ? round(($activeStores / $totalStores) * 100) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card warning fade-in-up" style="animation-delay: 0.2s">
                <div class="stats-icon bg-warning-light text-warning">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stats-info">
                    <h3>Productos Activos</h3>
                    <p class="counter">{{ $activeProducts }}</p>
                    <small class="text-muted">+{{ $newProducts }} nuevos esta semana</small>
                </div>
                <div class="stats-badge">
                    <span class="badge bg-warning rounded-pill">
                        <i class="fas fa-arrow-up me-1"></i>{{ $totalProducts > 0 ? round(($activeProducts / $totalProducts) * 100) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card info fade-in-up" style="animation-delay: 0.3s">
                <div class="stats-icon bg-info-light text-info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stats-info">
                    <h3>Pedidos Totales</h3>
                    <p class="counter">{{ $totalOrders }}</p>
                    <small class="text-muted">+{{ $newOrders }} en las últimas 24h</small>
                </div>
                <div class="stats-badge">
                    <span class="badge bg-info rounded-pill">
                        <i class="fas fa-arrow-up me-1"></i>{{ ($totalOrders > 0 && $newOrders > 0) ? round(($newOrders / $totalOrders) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue and Activity Cards -->
    <div class="row mb-4">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card h-100 chart-card fade-in-up" style="animation-delay: 0.4s">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-dollar-sign text-success me-2"></i>
                        <span class="fw-bold">Ingresos Totales</span>
                    </div>
                    <span class="badge bg-success rounded-pill">Últimos 6 meses</span>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center">
                        <div class="display-3 fw-bold text-success mb-2">${{ number_format($totalRevenue, 0) }}</div>
                        <div class="text-muted">Ingresos acumulados</div>
                        <div class="progress mt-3 w-75">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="row mt-4 text-center">
                        <div class="col-12">
                            <div class="d-flex flex-column">
                                <span class="text-muted small">Total de Pedidos</span>
                                <span class="fw-bold">{{ $totalOrders }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card h-100 chart-card fade-in-up" style="animation-delay: 0.5s">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        <span class="fw-bold">Actividad de la Plataforma</span>
                    </div>
                    <span class="badge bg-primary rounded-pill">Tiempo real</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Tiendas Activas</h6>
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalStores > 0 ? ($activeStores / $totalStores) * 100 : 0 }}%;" aria-valuenow="{{ $totalStores > 0 ? ($activeStores / $totalStores) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">{{ $activeStores }} de {{ $totalStores }}</small>
                                        <small class="text-success">{{ $totalStores > 0 ? round(($activeStores / $totalStores) * 100) : 0 }}%</small>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Productos Activos</h6>
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalProducts > 0 ? ($activeProducts / $totalProducts) * 100 : 0 }}%;" aria-valuenow="{{ $totalProducts > 0 ? ($activeProducts / $totalProducts) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">{{ $activeProducts }} de {{ $totalProducts }}</small>
                                        <small class="text-warning">{{ $totalProducts > 0 ? round(($activeProducts / $totalProducts) * 100) : 0 }}%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <div class="status-indicator bg-info"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Pedidos Totales</h6>
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">{{ $totalOrders }} pedidos</small>
                                        <small class="text-info">{{ $newOrders }} nuevos</small>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="status-indicator bg-primary"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Usuarios Activos</h6>
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">{{ $totalUsers }} usuarios</small>
                                        <small class="text-primary">{{ $newUsers }} nuevos</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reportes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card chart-card fade-in-up">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-pdf text-danger me-2"></i>
                        <span class="fw-bold">Reportes y Análisis</span>
                    </div>
                    <span class="badge bg-danger rounded-pill">Nuevo</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex align-items-center p-3 rounded bg-light">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-primary-light">
                                        <i class="fas fa-calendar-week fa-lg text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Reporte Semanal</h6>
                                    <p class="mb-2 small text-muted">Resumen de actividad de los últimos 7 días</p>
                                    <a href="{{ route('admin.reports.weekly') }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-1"></i> Generar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex align-items-center p-3 rounded bg-light">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-success-light">
                                        <i class="fas fa-calendar-alt fa-lg text-success"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Reporte Mensual</h6>
                                    <p class="mb-2 small text-muted">Análisis completo del mes actual</p>
                                    <a href="{{ route('admin.reports.monthly') }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fas fa-download me-1"></i> Generar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 rounded bg-light">
                                <div class="flex-shrink-0 me-3">
                                    <div class="icon-circle bg-warning-light">
                                        <i class="fas fa-chart-line fa-lg text-warning"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Reporte Anual</h6>
                                    <p class="mb-2 small text-muted">Estadísticas consolidadas del año</p>
                                    <a href="{{ route('admin.reports.annual') }}" target="_blank" class="btn btn-sm btn-warning">
                                        <i class="fas fa-download me-1"></i> Generar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-cog me-1"></i> Configurar reportes personalizados
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick Links -->
    <div class="card fade-in-up" style="animation-delay: 0.5s">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-link text-primary me-2"></i>
                <span class="fw-bold">Accesos Rápidos</span>
            </div>
            <button class="btn btn-sm btn-light" id="customizeLinks" data-bs-toggle="tooltip" title="Personalizar accesos">
                <i class="fas fa-cog"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.users.index') }}" class="quick-link d-flex align-items-center p-4 rounded bg-white shadow-sm text-decoration-none">
                        <div class="flex-shrink-0 me-3">
                            <div class="icon-circle bg-primary-light">
                                <i class="fas fa-users fa-lg text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Gestionar Usuarios</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary rounded-pill me-2">{{ $totalUsers }}</span>
                                <small class="text-muted">usuarios</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.stores.index') }}" class="quick-link d-flex align-items-center p-4 rounded bg-white shadow-sm text-decoration-none">
                        <div class="flex-shrink-0 me-3">
                            <div class="icon-circle bg-success-light">
                                <i class="fas fa-store fa-lg text-success"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Gestionar Tiendas</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success rounded-pill me-2">{{ $totalStores }}</span>
                                <small class="text-muted">tiendas</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.products.index') }}" class="quick-link d-flex align-items-center p-4 rounded bg-white shadow-sm text-decoration-none">
                        <div class="flex-shrink-0 me-3">
                            <div class="icon-circle bg-warning-light">
                                <i class="fas fa-box fa-lg text-warning"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Gestionar Productos</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning rounded-pill me-2">{{ $totalProducts }}</span>
                                <small class="text-muted">productos</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.orders.index') }}" class="quick-link d-flex align-items-center p-4 rounded bg-white shadow-sm text-decoration-none">
                        <div class="flex-shrink-0 me-3">
                            <div class="icon-circle bg-info-light">
                                <i class="fas fa-shopping-cart fa-lg text-info"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Gestionar Pedidos</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info rounded-pill me-2">{{ $totalOrders }}</span>
                                <small class="text-muted">pedidos</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <span class="text-muted small">Puedes personalizar estos accesos rápidos según tus necesidades.</span>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> Añadir acceso
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- System Status -->
    <div class="card mt-4 fade-in-up" style="animation-delay: 0.6s">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-server text-primary me-2"></i>
                <span class="fw-bold">Estado del Sistema</span>
            </div>
            <span class="badge bg-success rounded-pill">Todos los sistemas operativos</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">Base de datos</h6>
                            <div class="progress mt-1" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">25% de uso</small>
                                <small class="text-muted">Última actualización: hace 5 min</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">Servidor web</h6>
                            <div class="progress mt-1" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">40% de uso</small>
                                <small class="text-muted">Última actualización: hace 5 min</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">Almacenamiento</h6>
                            <div class="progress mt-1" style="height: 5px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">65% de uso</small>
                                <small class="text-muted">Última actualización: hace 5 min</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">Memoria</h6>
                            <div class="progress mt-1" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">30% de uso</small>
                                <small class="text-muted">Última actualización: hace 5 min</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Última verificación: {{ now()->format('d/m/Y H:i') }}</span>
                <a href="#" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-sync-alt me-1"></i> Actualizar estado
                </a>
            </div>
        </div>
    </div>
@endsection
@section('styles')
<style>
    .bg-primary-light {
        background-color: rgba(46, 125, 50, 0.15);
    }
    .text-primary {
        color: #2E7D32 !important;
    }
    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.15);
    }
    .text-success {
        color: #28a745 !important;
    }
    .bg-warning-light {
        background-color: rgba(255, 160, 0, 0.15);
    }
    .text-warning {
        color: #FFA000 !important;
    }
    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.15);
    }
    .text-info {
        color: #17a2b8 !important;
    }

    /* Estilos 3D */
    .three-dimensional {
        transform-style: preserve-3d;
        perspective: 1000px;
    }

    .stats-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 2;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .order-row {
        transition: all 0.3s;
    }

    .order-row:hover {
        background-color: rgba(0, 0, 0, 0.02);
        transform: translateX(5px);
    }

    .empty-state {
        padding: 30px;
        background-color: rgba(0, 0, 0, 0.02);
        border-radius: 10px;
    }

    .quick-link {
        transition: all 0.3s;
        border-radius: 16px !important;
        overflow: hidden;
        transform-style: preserve-3d;
    }

    .quick-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection
@section('scripts')
<!-- Scripts para el dashboard -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.8/countUp.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar contadores animados
        const counterElements = document.querySelectorAll('.counter');
        counterElements.forEach(function(element) {
            const target = parseFloat(element.getAttribute('data-target'));
            const prefix = element.getAttribute('data-prefix') || '';
            const suffix = element.getAttribute('data-suffix') || '';
            const duration = parseInt(element.getAttribute('data-duration')) || 2000;
            const decimals = parseInt(element.getAttribute('data-decimals')) || 0;

            const countUp = new CountUp(element, target, {
                startVal: 0,
                duration: duration / 1000,
                decimalPlaces: decimals,
                prefix: prefix,
                suffix: suffix
            });
            countUp.start();
        });

        // Inicializar tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection