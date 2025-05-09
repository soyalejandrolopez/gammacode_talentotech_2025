<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display the reports dashboard.
     */
    public function index(Request $request)
    {
        // Determinar el tipo de reporte y período
        $reportType = $request->input('report_type', 'weekly');
        $endDate = Carbon::now();
        $startDate = null;

        // Configurar fechas según el tipo de reporte
        if ($reportType === 'weekly') {
            $startDate = $request->input('start_date')
                ? Carbon::parse($request->input('start_date'))
                : $endDate->copy()->subDays(6);
            $endDate = $request->input('end_date')
                ? Carbon::parse($request->input('end_date'))
                : Carbon::now();
        } elseif ($reportType === 'monthly') {
            $month = $request->input('month') ? intval($request->input('month')) : Carbon::now()->month;
            $year = $request->input('year') ? intval($request->input('year')) : Carbon::now()->year;
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = $startDate->copy()->endOfMonth()->endOfDay();
        } elseif ($reportType === 'annual') {
            $year = $request->input('year') ? intval($request->input('year')) : Carbon::now()->year;
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();
        }

        // Asegurarse de que la fecha de inicio sea anterior a la fecha de fin
        if ($startDate && $startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // Obtener datos para mostrar en la vista
        $data = [];
        if ($startDate && $endDate) {
            $data = $this->getReportData($startDate, $endDate);
            $data['report_type'] = $reportType;
            $data['start_date'] = $startDate->format('Y-m-d');
            $data['end_date'] = $endDate->format('Y-m-d');

            if ($reportType === 'monthly') {
                $data['month'] = $startDate->month;
                $data['year'] = $startDate->year;
            } elseif ($reportType === 'annual') {
                $data['year'] = $startDate->year;
            }
        }

        return view('admin.reports.index', $data);
    }

    /**
     * Generate a weekly report.
     */
    public function weekly(Request $request)
    {
        // Get the start and end dates for the week
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : $endDate->copy()->subDays(6);

        // Ensure start date is before end date
        if ($startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // Get the data for the report
        $data = $this->getReportData($startDate, $endDate);
        $data['period'] = 'semanal';
        $data['start_date'] = $startDate->format('d/m/Y');
        $data['end_date'] = $endDate->format('d/m/Y');
        $data['title'] = 'Reporte Semanal: ' . $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y');

        // Generate the PDF
        $pdf = PDF::loadView('admin.reports.pdf.report', $data);

        return $pdf->download('reporte-semanal-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf');
    }

    /**
     * Generate a monthly report.
     */
    public function monthly(Request $request)
    {
        // Get the month and year
        $month = $request->input('month') ? intval($request->input('month')) : Carbon::now()->month;
        $year = $request->input('year') ? intval($request->input('year')) : Carbon::now()->year;

        // Create start and end dates
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        // Set locale to Spanish
        $startDate->locale('es');
        $endDate->locale('es');

        // Get month name in Spanish
        $monthName = $startDate->translatedFormat('F');

        // Get the data for the report
        $data = $this->getReportData($startDate, $endDate);
        $data['period'] = 'mensual';
        $data['start_date'] = $startDate->format('d/m/Y');
        $data['end_date'] = $endDate->format('d/m/Y');
        $data['title'] = 'Reporte Mensual: ' . ucfirst($monthName) . ' ' . $year;
        $data['month_name'] = ucfirst($monthName);
        $data['year'] = $year;

        // Generate the PDF
        $pdf = PDF::loadView('admin.reports.pdf.report', $data);

        return $pdf->download('reporte-mensual-' . $startDate->format('Y-m') . '.pdf');
    }

    /**
     * Generate an annual report.
     */
    public function annual(Request $request)
    {
        // Get the year
        $year = $request->input('year') ? intval($request->input('year')) : Carbon::now()->year;

        // Create start and end dates
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();

        // Get the data for the report
        $data = $this->getReportData($startDate, $endDate);
        $data['period'] = 'anual';
        $data['start_date'] = $startDate->format('d/m/Y');
        $data['end_date'] = $endDate->format('d/m/Y');
        $data['title'] = 'Reporte Anual: ' . $year;

        // Generate the PDF
        $pdf = PDF::loadView('admin.reports.pdf.report', $data);

        return $pdf->download('reporte-anual-' . $year . '.pdf');
    }

    /**
     * Get the data for the report.
     */
    private function getReportData($startDate, $endDate)
    {
        // Orders data
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_amount');

        // Order status counts
        $orderStatusCounts = [
            'pending' => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];

        // Daily orders and revenue for trend analysis
        $dailyOrders = [];
        $dailyRevenue = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $date = $currentDate->format('Y-m-d');
            $dailyOrders[$date] = $orders->filter(function ($order) use ($currentDate) {
                return $order->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
            })->count();

            $dailyRevenue[$date] = $orders->filter(function ($order) use ($currentDate) {
                return $order->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
            })->sum('total_amount');

            $currentDate->addDay();
        }

        // Top selling products with more details
        $topProducts = Product::withCount(['orderItems as sales_count' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            }])
            ->with(['store', 'category'])
            ->withSum(['orderItems as revenue' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            }], 'total')
            ->having('sales_count', '>', 0)
            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();

        // Top stores with more details
        $topStores = Store::withCount(['orderItems as sales_count' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            }])
            ->with('user')
            ->withSum(['orderItems as revenue' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            }], 'total')
            ->having('sales_count', '>', 0)
            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();

        // New users
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        // User roles distribution
        $userRoles = [
            'admin' => User::whereHas('roles', function($q) {
                $q->where('slug', 'admin');
            })->whereBetween('created_at', [$startDate, $endDate])->count(),
            'producer' => User::whereHas('roles', function($q) {
                $q->where('slug', 'producer');
            })->whereBetween('created_at', [$startDate, $endDate])->count(),
            'customer' => User::whereHas('roles', function($q) {
                $q->where('slug', 'customer');
            })->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        // Monthly trend data for charts
        $monthlyData = [];
        $startMonth = $startDate->copy()->startOfMonth();
        $endMonth = $endDate->copy()->startOfMonth();

        while ($startMonth->lte($endMonth)) {
            $monthKey = $startMonth->format('Y-m');
            $monthStart = $startMonth->copy()->startOfMonth();
            $monthEnd = $startMonth->copy()->endOfMonth();

            // Adjust if outside the report range
            if ($monthStart->lt($startDate)) {
                $monthStart = $startDate->copy();
            }

            if ($monthEnd->gt($endDate)) {
                $monthEnd = $endDate->copy();
            }

            $monthlyOrders = $orders->filter(function ($order) use ($monthStart, $monthEnd) {
                return $order->created_at->between($monthStart, $monthEnd);
            });

            $monthlyData[$monthKey] = [
                'label' => $startMonth->format('M Y'),
                'orders' => $monthlyOrders->count(),
                'revenue' => $monthlyOrders->sum('total_amount'),
            ];

            $startMonth->addMonth();
        }

        return [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'orderStatusCounts' => $orderStatusCounts,
            'dailyOrders' => $dailyOrders,
            'dailyRevenue' => $dailyRevenue,
            'topProducts' => $topProducts,
            'topStores' => $topStores,
            'newUsers' => $newUsers,
            'userRoles' => $userRoles,
            'monthlyData' => $monthlyData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }
}
