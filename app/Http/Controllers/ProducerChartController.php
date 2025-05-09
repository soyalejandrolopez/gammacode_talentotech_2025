<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;

class ProducerChartController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:producer']);
    }

    /**
     * Obtener datos para la gráfica de ventas
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function salesChart(Request $request)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return response()->json(['error' => 'No store found'], 404);
        }

        $period = $request->input('period', 'monthly');
        $currentYear = Carbon::now()->year;

        switch ($period) {
            case 'monthly':
                // Datos mensuales (últimos 12 meses)
                $salesData = $this->getMonthlySalesData($store->id);
                break;

            case 'quarterly':
                // Datos trimestrales (últimos 4 trimestres)
                $salesData = $this->getQuarterlySalesData($store->id);
                break;

            case 'yearly':
                // Datos anuales (últimos 5 años)
                $salesData = $this->getYearlySalesData($store->id);
                break;

            default:
                $salesData = $this->getMonthlySalesData($store->id);
        }

        return response()->json($salesData);
    }

    /**
     * Obtener datos para la gráfica de estado de pedidos
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderStatusChart()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return response()->json(['error' => 'No store found'], 404);
        }

        // Obtener IDs de pedidos que contienen productos de esta tienda
        $orderIds = OrderItem::where('store_id', $store->id)
            ->distinct('order_id')
            ->pluck('order_id');

        // Contar pedidos por estado
        $statusCounts = Order::whereIn('id', $orderIds)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->total];
            });

        // Preparar datos para la gráfica con etiquetas en español
        $labels = [
            'pending' => 'Pendientes',
            'processing' => 'Procesando',
            'completed' => 'Completados',
            'declined' => 'Cancelados',
            'cancelled' => 'Cancelados'
        ];

        $data = [];
        $colors = [
            'pending' => '#FFC107',    // Amarillo
            'processing' => '#0D47A1', // Azul
            'completed' => '#66BB6A',  // Verde
            'declined' => '#D32F2F',   // Rojo
            'cancelled' => '#D32F2F'   // Rojo
        ];

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => '#FFF',
                    'borderWidth' => 2,
                    'hoverOffset' => 10
                ]
            ]
        ];

        foreach ($labels as $status => $label) {
            $chartData['labels'][] = $label;
            $chartData['datasets'][0]['data'][] = $statusCounts[$status] ?? 0;
            $chartData['datasets'][0]['backgroundColor'][] = $colors[$status];
        }

        return response()->json($chartData);
    }

    /**
     * Obtener datos para la gráfica de productos por categoría
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function productsByCategoryChart()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return response()->json(['error' => 'No store found'], 404);
        }

        // Contar productos por categoría
        $productsByCategory = Product::where('store_id', $store->id)
            ->select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->get();

        // Obtener nombres de categorías
        $categoryIds = $productsByCategory->pluck('category_id');
        $categories = Category::whereIn('id', $categoryIds)->get()->keyBy('id');

        // Preparar datos para la gráfica
        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Productos por Categoría',
                    'data' => [],
                    'backgroundColor' => [
                        '#FFC107', // Amarillo
                        '#0D47A1', // Azul
                        '#D32F2F', // Rojo
                        '#66BB6A', // Verde
                        '#FF9800', // Naranja
                        '#9C27B0', // Púrpura
                        '#00BCD4', // Cian
                        '#795548', // Marrón
                        '#607D8B', // Gris azulado
                        '#E91E63'  // Rosa
                    ],
                    'borderColor' => '#FFF',
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'hoverOffset' => 4
                ]
            ]
        ];

        foreach ($productsByCategory as $item) {
            $categoryName = isset($categories[$item->category_id])
                ? $categories[$item->category_id]->name
                : 'Sin categoría';

            $chartData['labels'][] = $categoryName;
            $chartData['datasets'][0]['data'][] = $item->total;
        }

        // Si no hay datos, proporcionar algunos datos de ejemplo
        if (empty($chartData['labels'])) {
            $chartData['labels'] = ['Sin categorías'];
            $chartData['datasets'][0]['data'] = [0];
        }

        return response()->json($chartData);
    }

    /**
     * Obtener datos de ventas mensuales
     *
     * @param int $storeId
     * @return array
     */
    private function getMonthlySalesData($storeId)
    {
        // Nombres de meses en español
        $spanishMonths = [
            '01' => 'Ene',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dic'
        ];

        // Obtener los últimos 12 meses
        $months = [];
        $monthlyData = [];
        $currentYear = Carbon::now()->year;

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('m');
            $months[] = $spanishMonths[$monthKey] . ($date->year != $currentYear ? ' ' . $date->year : '');
            $monthlyData[$date->format('Y-m')] = 0;
        }

        // Obtener ventas mensuales
        $sales = OrderItem::where('store_id', $storeId)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', Carbon::now()->subMonths(12))
            ->where('orders.status', '!=', 'declined')
            ->select(
                DB::raw('DATE_FORMAT(orders.created_at, "%Y-%m") as month'),
                DB::raw('SUM(order_items.total) as total_sales')
            )
            ->groupBy('month')
            ->get();

        foreach ($sales as $sale) {
            if (isset($monthlyData[$sale->month])) {
                $monthlyData[$sale->month] = (float) $sale->total_sales;
            }
        }

        $currentYear = Carbon::now()->year;

        // Determinar el año para la etiqueta del dataset
        // Si todos los meses son del mismo año, mostrar solo ese año
        // Si hay meses de diferentes años, mostrar rango (ej: "Ventas 2024-2025")
        $years = [];
        foreach ($months as $month) {
            if (strpos($month, ' ') !== false) {
                $yearPart = explode(' ', $month)[1];
                if (!in_array($yearPart, $years)) {
                    $years[] = $yearPart;
                }
            } else {
                if (!in_array($currentYear, $years)) {
                    $years[] = $currentYear;
                }
            }
        }

        $yearLabel = count($years) > 1
            ? 'Ventas ' . min($years) . '-' . max($years)
            : 'Ventas ' . $currentYear;

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => $yearLabel,
                    'data' => array_values($monthlyData),
                    'borderColor' => '#FFC107',
                    'backgroundColor' => 'rgba(255, 193, 7, 0.2)',
                    'borderWidth' => 3,
                    'pointBackgroundColor' => '#FFC107',
                    'pointBorderColor' => '#FFF',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 6,
                    'pointHoverRadius' => 8,
                    'tension' => 0.4,
                    'fill' => true
                ]
            ]
        ];
    }

    /**
     * Obtener datos de ventas trimestrales
     *
     * @param int $storeId
     * @return array
     */
    private function getQuarterlySalesData($storeId)
    {
        // Nombres de trimestres en español
        $spanishQuarters = [
            1 => 'T1',
            2 => 'T2',
            3 => 'T3',
            4 => 'T4'
        ];

        // Obtener los últimos 4 trimestres
        $quarters = [];
        $quarterlyData = [];

        for ($i = 3; $i >= 0; $i--) {
            $date = Carbon::now()->subQuarters($i);
            $quarterNumber = ceil($date->month / 3);
            $quarterLabel = $spanishQuarters[$quarterNumber] . ' ' . $date->year;
            $quarters[] = $quarterLabel;

            $startDate = Carbon::create($date->year, ($date->quarter - 1) * 3 + 1, 1)->startOfMonth();
            $endDate = Carbon::create($date->year, $date->quarter * 3, 1)->endOfMonth();

            $quarterlyData[$quarterLabel] = [
                'start' => $startDate,
                'end' => $endDate,
                'total' => 0
            ];
        }

        // Obtener ventas trimestrales
        foreach ($quarterlyData as $quarter => $dates) {
            $sales = OrderItem::where('store_id', $storeId)
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.created_at', '>=', $dates['start'])
                ->where('orders.created_at', '<=', $dates['end'])
                ->where('orders.status', '!=', 'declined')
                ->sum('order_items.total');

            $quarterlyData[$quarter]['total'] = (float) $sales;
        }

        $data = array_map(function ($quarter) use ($quarterlyData) {
            return $quarterlyData[$quarter]['total'];
        }, $quarters);

        // Determinar el rango de años para la etiqueta
        $years = [];
        foreach ($quarters as $quarter) {
            $yearPart = explode(' ', $quarter)[1];
            if (!in_array($yearPart, $years)) {
                $years[] = $yearPart;
            }
        }

        $yearRangeLabel = count($years) > 1
            ? "Ventas Trimestrales " . min($years) . "-" . max($years)
            : "Ventas Trimestrales " . reset($years);

        return [
            'labels' => $quarters,
            'datasets' => [
                [
                    'label' => $yearRangeLabel,
                    'data' => $data,
                    'borderColor' => '#0D47A1',
                    'backgroundColor' => 'rgba(13, 71, 161, 0.2)',
                    'borderWidth' => 3,
                    'pointBackgroundColor' => '#0D47A1',
                    'pointBorderColor' => '#FFF',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 6,
                    'pointHoverRadius' => 8,
                    'tension' => 0.4,
                    'fill' => true
                ]
            ]
        ];
    }

    /**
     * Obtener datos de ventas anuales
     *
     * @param int $storeId
     * @return array
     */
    private function getYearlySalesData($storeId)
    {
        // Obtener los últimos 5 años
        $years = [];
        $yearlyData = [];
        $currentYear = Carbon::now()->year;

        // Determinar el rango de años a mostrar (últimos 5 años)
        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $years[] = (string) $year;
            $yearlyData[$year] = 0;
        }

        // Obtener ventas anuales desde la base de datos
        $sales = OrderItem::where('store_id', $storeId)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', Carbon::now()->subYears(5)->startOfYear())
            ->whereIn(DB::raw('YEAR(orders.created_at)'), array_map('intval', $years)) // Filtrar solo por los años que nos interesan
            ->where('orders.status', '!=', 'declined')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('SUM(order_items.total) as total_sales')
            )
            ->groupBy('year')
            ->get();

        // Asignar los valores de ventas a cada año
        foreach ($sales as $sale) {
            if (isset($yearlyData[$sale->year])) {
                $yearlyData[$sale->year] = (float) $sale->total_sales;
            }
        }

        // Determinar el rango de años para la etiqueta
        $minYear = min($years);
        $maxYear = max($years);
        $yearRangeLabel = $minYear === $maxYear ? "Ventas $minYear" : "Ventas $minYear-$maxYear";

        return [
            'labels' => $years,
            'datasets' => [
                [
                    'label' => $yearRangeLabel,
                    'data' => array_values($yearlyData),
                    'borderColor' => '#D32F2F',
                    'backgroundColor' => 'rgba(211, 47, 47, 0.2)',
                    'borderWidth' => 3,
                    'pointBackgroundColor' => '#D32F2F',
                    'pointBorderColor' => '#FFF',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 6,
                    'pointHoverRadius' => 8,
                    'tension' => 0.4,
                    'fill' => true
                ]
            ]
        ];
    }
}
