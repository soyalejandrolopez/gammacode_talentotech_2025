@extends('layouts.admin')

@section('title', 'Reportes')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card chart-card fade-in-up">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-file-pdf text-danger me-2"></i>
                    <span class="fw-bold">Generación de Reportes</span>
                </div>
                <span class="badge bg-primary rounded-pill">Exportar a PDF</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Reporte Semanal -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-primary-light text-primary me-3">
                                        <i class="fas fa-calendar-week"></i>
                                    </div>
                                    <h5 class="card-title mb-0">Reporte Semanal</h5>
                                </div>
                                <p class="card-text text-muted">Genera un reporte detallado de las actividades y ventas de la última semana o un período personalizado.</p>

                                <form action="{{ route('admin.reports.weekly') }}" method="GET" target="_blank">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Fecha de inicio</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ now()->subDays(6)->format('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Fecha de fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ now()->format('Y-m-d') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-download me-2"></i> Generar Reporte
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte Mensual -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-success-light text-success me-3">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <h5 class="card-title mb-0">Reporte Mensual</h5>
                                </div>
                                <p class="card-text text-muted">Genera un reporte completo de las actividades y ventas del mes actual o un mes específico.</p>

                                <form action="{{ route('admin.reports.monthly') }}" method="GET" target="_blank">
                                    <div class="mb-3">
                                        <label for="month" class="form-label">Mes</label>
                                        <select class="form-select" id="month" name="month">
                                            @php
                                                $meses = [
                                                    1 => 'Enero',
                                                    2 => 'Febrero',
                                                    3 => 'Marzo',
                                                    4 => 'Abril',
                                                    5 => 'Mayo',
                                                    6 => 'Junio',
                                                    7 => 'Julio',
                                                    8 => 'Agosto',
                                                    9 => 'Septiembre',
                                                    10 => 'Octubre',
                                                    11 => 'Noviembre',
                                                    12 => 'Diciembre'
                                                ];
                                            @endphp
                                            @foreach ($meses as $num => $nombre)
                                                <option value="{{ $num }}" {{ now()->month == $num ? 'selected' : '' }}>
                                                    {{ $nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Año</label>
                                        <select class="form-select" id="year" name="year">
                                            @for ($i = now()->year; $i >= now()->year - 5; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-download me-2"></i> Generar Reporte
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte Anual -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-warning-light text-warning me-3">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h5 class="card-title mb-0">Reporte Anual</h5>
                                </div>
                                <p class="card-text text-muted">Genera un reporte consolidado de las actividades y ventas del año actual o un año específico.</p>

                                <form action="{{ route('admin.reports.annual') }}" method="GET" target="_blank">
                                    <div class="mb-3">
                                        <label for="annual_year" class="form-label">Año</label>
                                        <select class="form-select" id="annual_year" name="year">
                                            @for ($i = now()->year; $i >= now()->year - 5; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-warning w-100">
                                        <i class="fas fa-download me-2"></i> Generar Reporte
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card chart-card fade-in-up">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle text-info me-2"></i>
                    <span class="fw-bold">Información sobre los Reportes</span>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="fas fa-lightbulb me-2"></i>¿Qué incluyen los reportes?</h5>
                    <p>Los reportes generados en PDF incluyen la siguiente información:</p>
                    <ul>
                        <li><strong>Resumen de ventas:</strong> Total de pedidos y ingresos en el período seleccionado.</li>
                        <li><strong>Estadísticas de pedidos:</strong> Distribución de pedidos por estado (pendiente, procesando, completado, cancelado).</li>
                        <li><strong>Productos más vendidos:</strong> Lista de los productos con mayor número de ventas.</li>
                        <li><strong>Tiendas más activas:</strong> Tiendas con mayor volumen de ventas.</li>
                        <li><strong>Nuevos usuarios:</strong> Cantidad de usuarios registrados en el período.</li>
                        <li><strong>Gráficos y tendencias:</strong> Visualización de datos para análisis rápido.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-primary-light {
        background-color: rgba(var(--bs-primary-rgb), 0.15);
    }

    .bg-success-light {
        background-color: rgba(var(--bs-success-rgb), 0.15);
    }

    .bg-warning-light {
        background-color: rgba(var(--bs-warning-rgb), 0.15);
    }

    .bg-info-light {
        background-color: rgba(var(--bs-info-rgb), 0.15);
    }
</style>
@endsection
