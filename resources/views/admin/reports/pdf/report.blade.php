<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            color: #2c3e50;
            font-size: 24px;
            margin: 0 0 5px;
        }
        h2 {
            color: #3498db;
            font-size: 18px;
            margin: 20px 0 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        h3 {
            color: #2c3e50;
            font-size: 16px;
            margin: 15px 0 5px;
        }
        .date-range {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .summary-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-item {
            display: inline-block;
            width: 24%;
            text-align: center;
            vertical-align: top;
        }
        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin: 5px 0;
        }
        .summary-label {
            font-size: 12px;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }
        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .status-chart {
            width: 100%;
            height: 20px;
            background-color: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .status-bar {
            height: 100%;
            float: left;
        }
        .status-pending {
            background-color: #f39c12;
        }
        .status-processing {
            background-color: #3498db;
        }
        .status-completed {
            background-color: #2ecc71;
        }
        .status-cancelled {
            background-color: #e74c3c;
        }
        .status-legend {
            margin-bottom: 20px;
        }
        .status-legend-item {
            display: inline-block;
            margin-right: 15px;
        }
        .status-color {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
        .chart-container {
            width: 100%;
            margin: 20px 0;
        }
        .bar-chart {
            width: 100%;
            height: 200px;
            position: relative;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        .bar {
            position: absolute;
            bottom: 0;
            width: 30px;
            background-color: #3498db;
            margin-right: 10px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        .bar-label {
            position: absolute;
            bottom: -20px;
            font-size: 10px;
            text-align: center;
            transform: rotate(-45deg);
            transform-origin: left top;
            width: 60px;
        }
        .bar-value {
            position: absolute;
            top: -20px;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 10px;
            margin-top: 20px;
            border-left: 4px solid #3498db;
        }
        .info-box {
            background-color: #e8f4f8;
            border-left: 4px solid #3498db;
            padding: 10px;
            margin-bottom: 15px;
        }

        .monthly-badge {
            display: inline-block;
            background-color: #3498db;
            color: white;
            font-weight: bold;
            padding: 5px 15px;
            border-radius: 20px;
            margin-top: 10px;
            font-size: 14px;
        }

        .monthly-highlight {
            background-color: #f8f4e8;
            border-left: 4px solid #f39c12;
            padding: 10px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>AgroGastro</h1>
        <div class="date-range">{{ $title }}</div>
        <div>Período: {{ $start_date }} - {{ $end_date }}</div>
        @if(isset($period) && $period == 'mensual' && isset($month_name) && isset($year))
            <div class="monthly-badge">Reporte Mensual de {{ $month_name }} {{ $year }}</div>
        @endif
    </div>

    <!-- SECCIÓN 1: RESUMEN DE VENTAS -->
    <div class="section-title">
        <h2>Resumen de Ventas</h2>
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <div class="summary-value">{{ $totalOrders }}</div>
            <div class="summary-label">Pedidos Totales</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">${{ number_format($totalRevenue, 2) }}</div>
            <div class="summary-label">Ingresos Totales</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $newUsers }}</div>
            <div class="summary-label">Nuevos Usuarios</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $topProducts->count() }}</div>
            <div class="summary-label">Productos Vendidos</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Métrica</th>
                <th>Valor</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total de Pedidos</td>
                <td>{{ $totalOrders }}</td>
                <td>Pedidos realizados entre {{ $start_date }} y {{ $end_date }}</td>
            </tr>
            <tr>
                <td>Ingresos Totales</td>
                <td>${{ number_format($totalRevenue, 2) }}</td>
                <td>Suma de todos los pedidos en el período</td>
            </tr>
            <tr>
                <td>Promedio por Pedido</td>
                <td>${{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}</td>
                <td>Valor promedio de cada pedido</td>
            </tr>
        </tbody>
    </table>

    <!-- SECCIÓN 2: ESTADÍSTICAS DE PEDIDOS -->
    <div class="section-title">
        <h2>Estadísticas de Pedidos</h2>
    </div>

    <div class="info-box">
        Distribución de pedidos por estado durante el período seleccionado.
    </div>

    <table>
        <thead>
            <tr>
                <th>Estado</th>
                <th>Cantidad</th>
                <th>Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = array_sum($orderStatusCounts);
                $pendingPercent = $total > 0 ? ($orderStatusCounts['pending'] / $total) * 100 : 0;
                $processingPercent = $total > 0 ? ($orderStatusCounts['processing'] / $total) * 100 : 0;
                $completedPercent = $total > 0 ? ($orderStatusCounts['completed'] / $total) * 100 : 0;
                $cancelledPercent = $total > 0 ? ($orderStatusCounts['cancelled'] / $total) * 100 : 0;
            @endphp
            <tr>
                <td>Pendiente</td>
                <td>{{ $orderStatusCounts['pending'] }}</td>
                <td>{{ number_format($pendingPercent, 1) }}%</td>
            </tr>
            <tr>
                <td>Procesando</td>
                <td>{{ $orderStatusCounts['processing'] }}</td>
                <td>{{ number_format($processingPercent, 1) }}%</td>
            </tr>
            <tr>
                <td>Completado</td>
                <td>{{ $orderStatusCounts['completed'] }}</td>
                <td>{{ number_format($completedPercent, 1) }}%</td>
            </tr>
            <tr>
                <td>Cancelado</td>
                <td>{{ $orderStatusCounts['cancelled'] }}</td>
                <td>{{ number_format($cancelledPercent, 1) }}%</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ $total }}</strong></td>
                <td><strong>100%</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="status-chart">
        <div class="status-bar status-pending" style="width: {{ $pendingPercent }}%"></div>
        <div class="status-bar status-processing" style="width: {{ $processingPercent }}%"></div>
        <div class="status-bar status-completed" style="width: {{ $completedPercent }}%"></div>
        <div class="status-bar status-cancelled" style="width: {{ $cancelledPercent }}%"></div>
    </div>

    <div class="status-legend">
        <div class="status-legend-item">
            <span class="status-color status-pending"></span> Pendiente
        </div>
        <div class="status-legend-item">
            <span class="status-color status-processing"></span> Procesando
        </div>
        <div class="status-legend-item">
            <span class="status-color status-completed"></span> Completado
        </div>
        <div class="status-legend-item">
            <span class="status-color status-cancelled"></span> Cancelado
        </div>
    </div>

    <div class="page-break"></div>

    <!-- SECCIÓN 3: PRODUCTOS MÁS VENDIDOS -->
    <div class="section-title">
        <h2>Productos Más Vendidos</h2>
    </div>

    <div class="info-box">
        Lista de los productos con mayor número de ventas durante el período.
    </div>

    @if($topProducts->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Tienda</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Ventas</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->store->name ?? 'N/A' }}</td>
                        <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->sales_count }}</td>
                        <td>${{ number_format($product->revenue ?? ($product->price * $product->sales_count), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos de productos vendidos en este período.</p>
    @endif

    <!-- SECCIÓN 4: TIENDAS MÁS ACTIVAS -->
    <div class="section-title">
        <h2>Tiendas Más Activas</h2>
    </div>

    <div class="info-box">
        Tiendas con mayor volumen de ventas durante el período seleccionado.
    </div>

    @if($topStores->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tienda</th>
                    <th>Propietario</th>
                    <th>Ventas</th>
                    <th>Ingresos</th>
                    <th>% del Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topStores as $store)
                    @php
                        $percentage = $totalRevenue > 0 ? (($store->revenue ?? 0) / $totalRevenue) * 100 : 0;
                    @endphp
                    <tr>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->user->name ?? 'N/A' }}</td>
                        <td>{{ $store->sales_count }}</td>
                        <td>${{ number_format($store->revenue ?? 0, 2) }}</td>
                        <td>{{ number_format($percentage, 1) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos de tiendas activas en este período.</p>
    @endif

    <div class="page-break"></div>

    <!-- SECCIÓN 5: NUEVOS USUARIOS -->
    <div class="section-title">
        <h2>Nuevos Usuarios</h2>
    </div>

    <div class="info-box">
        Cantidad de usuarios registrados en el período: <strong>{{ $newUsers }}</strong>
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <div class="summary-value">{{ $userRoles['admin'] }}</div>
            <div class="summary-label">Administradores</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $userRoles['producer'] }}</div>
            <div class="summary-label">Productores</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $userRoles['customer'] }}</div>
            <div class="summary-label">Clientes</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $newUsers }}</div>
            <div class="summary-label">Total</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tipo de Usuario</th>
                <th>Cantidad</th>
                <th>Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @php
                $adminPercent = $newUsers > 0 ? ($userRoles['admin'] / $newUsers) * 100 : 0;
                $producerPercent = $newUsers > 0 ? ($userRoles['producer'] / $newUsers) * 100 : 0;
                $customerPercent = $newUsers > 0 ? ($userRoles['customer'] / $newUsers) * 100 : 0;
            @endphp
            <tr>
                <td>Administradores</td>
                <td>{{ $userRoles['admin'] }}</td>
                <td>{{ number_format($adminPercent, 1) }}%</td>
            </tr>
            <tr>
                <td>Productores</td>
                <td>{{ $userRoles['producer'] }}</td>
                <td>{{ number_format($producerPercent, 1) }}%</td>
            </tr>
            <tr>
                <td>Clientes</td>
                <td>{{ $userRoles['customer'] }}</td>
                <td>{{ number_format($customerPercent, 1) }}%</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ $newUsers }}</strong></td>
                <td><strong>100%</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- SECCIÓN 6: RESUMEN MENSUAL (Solo para reportes mensuales) -->
    @if(isset($period) && $period == 'mensual' && isset($month_name) && isset($year))
    <div class="section-title">
        <h2>Resumen Mensual: {{ $month_name }} {{ $year }}</h2>
    </div>

    <div class="monthly-highlight">
        Este es un reporte detallado de las actividades y ventas durante el mes de <strong>{{ $month_name }}</strong> de <strong>{{ $year }}</strong>.
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <div class="summary-value">{{ $totalOrders }}</div>
            <div class="summary-label">Pedidos en {{ $month_name }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">${{ number_format($totalRevenue, 2) }}</div>
            <div class="summary-label">Ingresos del Mes</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $totalOrders > 0 ? number_format($totalOrders / cal_days_in_month(CAL_GREGORIAN, $startDate->month, $startDate->year), 1) : '0' }}</div>
            <div class="summary-label">Pedidos/Día</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $newUsers }}</div>
            <div class="summary-label">Nuevos Usuarios</div>
        </div>
    </div>

    <h3>Comparación con Meses Anteriores</h3>
    @if(count($monthlyData) > 1)
        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Pedidos</th>
                    <th>Ingresos</th>
                    <th>Comparación</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $currentMonthKey = $startDate->format('Y-m');
                    $currentMonthData = $monthlyData[$currentMonthKey] ?? null;
                    $previousMonths = array_filter($monthlyData, function($key) use ($currentMonthKey) {
                        return $key != $currentMonthKey;
                    }, ARRAY_FILTER_USE_KEY);
                @endphp

                @if($currentMonthData)
                    <tr>
                        <td><strong>{{ $currentMonthData['label'] }} (Actual)</strong></td>
                        <td><strong>{{ $currentMonthData['orders'] }}</strong></td>
                        <td><strong>${{ number_format($currentMonthData['revenue'], 2) }}</strong></td>
                        <td>-</td>
                    </tr>
                @endif

                @foreach($previousMonths as $month => $data)
                    @php
                        $ordersDiff = $currentMonthData ? $currentMonthData['orders'] - $data['orders'] : 0;
                        $revenueDiff = $currentMonthData ? $currentMonthData['revenue'] - $data['revenue'] : 0;
                        $ordersPercent = $data['orders'] > 0 ? ($ordersDiff / $data['orders']) * 100 : 0;
                        $revenuePercent = $data['revenue'] > 0 ? ($revenueDiff / $data['revenue']) * 100 : 0;
                    @endphp
                    <tr>
                        <td>{{ $data['label'] }}</td>
                        <td>{{ $data['orders'] }}</td>
                        <td>${{ number_format($data['revenue'], 2) }}</td>
                        <td>
                            @if($currentMonthData)
                                @if($revenuePercent > 0)
                                    <span style="color: green;">+{{ number_format($revenuePercent, 1) }}%</span>
                                @elseif($revenuePercent < 0)
                                    <span style="color: red;">{{ number_format($revenuePercent, 1) }}%</span>
                                @else
                                    0%
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos de meses anteriores para comparar.</p>
    @endif
    @endif

    <!-- SECCIÓN 7: GRÁFICOS Y TENDENCIAS -->
    <div class="section-title">
        <h2>Gráficos y Tendencias</h2>
    </div>

    <div class="info-box">
        Visualización de datos para análisis rápido del período seleccionado.
    </div>

    <h3>Tendencia de Ingresos por Mes</h3>

    @if(count($monthlyData) > 0)
        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Pedidos</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyData as $month => $data)
                    <tr>
                        <td>{{ $data['label'] }}</td>
                        <td>{{ $data['orders'] }}</td>
                        <td>${{ number_format($data['revenue'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay suficientes datos para mostrar tendencias en este período.</p>
    @endif

    <div class="footer">
        <p>Reporte generado el {{ now()->locale('es')->isoFormat('DD [de] MMMM [de] YYYY, HH:mm:ss') }} | AgroGastro</p>
        <p>Este reporte es confidencial y para uso interno de la empresa.</p>
        @if(isset($period) && $period == 'mensual' && isset($month_name) && isset($year))
            <p>Reporte Mensual de {{ $month_name }} {{ $year }}</p>
        @endif
    </div>
</body>
</html>
