<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index()
    {
        // User Data
        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        // ========== ORDER STATISTICS ==========
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $inProduction = Order::where('status', 'production')->count();
        $qualityCheck = Order::where('status', 'quality_check')->count();
        $readyOrders = Order::where('status', 'ready')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // ========== FINANCIAL REPORTS ==========
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $totalDeposits = Payment::where('type', 'deposit')->where('status', 'completed')->sum('amount');
        $totalBalancePayments = Payment::where('type', 'balance')->where('status', 'completed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->sum('amount');

        // Outstanding balance from orders
        $outstandingBalance = Order::sum('balance_amount');

        // ========== MONTHLY REVENUE CHART ==========
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyRevenue = [];
        $monthlyOrdersCount = [];

        for ($i = 1; $i <= 12; $i++) {
            $revenue = Payment::where('status', 'completed')
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', $i)
                ->sum('amount');
            $monthlyRevenue[] = round($revenue / 1000, 1);

            $ordersCount = Order::whereYear('order_date', now()->year)
                ->whereMonth('order_date', $i)
                ->count();
            $monthlyOrdersCount[] = $ordersCount;
        }

        // ========== PAYMENT METHODS BREAKDOWN ==========
        $mpesaPayments = Payment::where('method', 'mpesa')->where('status', 'completed')->sum('amount');
        $bankTransfers = Payment::where('method', 'bank_transfer')->where('status', 'completed')->sum('amount');
        $cashPayments = Payment::where('method', 'cash')->where('status', 'completed')->sum('amount');
        $cardPayments = Payment::where('method', 'card')->where('status', 'completed')->sum('amount');

        // ========== TOP PRODUCTS (Most Ordered) ==========
        $topProducts = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select('products.name', 'products.sku', DB::raw('SUM(order_product.quantity) as total_quantity'), DB::raw('SUM(order_product.price_at_time * order_product.quantity) as total_revenue'))
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // ========== TOP CUSTOMERS ==========
        $topCustomers = Order::select('customer_id', 'customer_name', DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total_amount) as total_spent'))
            ->groupBy('customer_id', 'customer_name')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();

        // ========== CARPENTER PERFORMANCE ==========
        $carpenterPerformance = User::where('role', 'carpenter')
            ->withCount(['assignedTasks as total_tasks'])
            ->withCount([
                'assignedTasks as completed_tasks' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->get()
            ->map(function ($carpenter) {
                $carpenter->completion_rate = $carpenter->total_tasks > 0
                    ? round(($carpenter->completed_tasks / $carpenter->total_tasks) * 100, 1)
                    : 0;
                return $carpenter;
            })
            ->sortByDesc('completion_rate')
            ->take(5);

        // ========== DELIVERY PERFORMANCE ==========
        $totalDeliveries = DB::table('deliveries')->count();
        $completedDeliveries = DB::table('deliveries')->where('status', 'delivered')->count();
        $pendingDeliveries = DB::table('deliveries')->where('status', 'pending')->count();
        $deliveryCompletionRate = $totalDeliveries > 0 ? round(($completedDeliveries / $totalDeliveries) * 100, 1) : 0;

        // ========== RECENT ACTIVITY ==========
        $recentOrders = Order::with('customer')->latest()->take(10)->get();
        $recentPayments = Payment::with('order')->latest()->take(10)->get();

        return view('admin.reports.index', compact(
            'userInitials',
            'userRole',
            'currentDate',
            'totalOrders',
            'pendingOrders',
            'inProduction',
            'qualityCheck',
            'readyOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalRevenue',
            'totalDeposits',
            'totalBalancePayments',
            'pendingPayments',
            'outstandingBalance',
            'months',
            'monthlyRevenue',
            'monthlyOrdersCount',
            'mpesaPayments',
            'bankTransfers',
            'cashPayments',
            'cardPayments',
            'topProducts',
            'topCustomers',
            'carpenterPerformance',
            'totalDeliveries',
            'completedDeliveries',
            'pendingDeliveries',
            'deliveryCompletionRate',
            'recentOrders',
            'recentPayments'
        ));
    }

    public function export()
    {
        // This will handle CSV/Excel export
        return back()->with('success', 'Export feature coming soon!');
    }
}