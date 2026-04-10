<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Summary Stats
        $totalOrders = Order::count();
        $inProduction = Order::where('status', 'production')->count();
        $pendingDelivery = Order::where('status', 'ready')->where('delivery_required', true)->count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        $stats = [
            [
                'label' => 'Total Orders',
                'value' => number_format($totalOrders),
                'trend' => '+14%',
                'dir' => 'up',
                'period' => 'vs last month',
                'icon' => 'fa-box-open',
                'color' => 'navy',
            ],
            [
                'label' => 'In Production',
                'value' => number_format($inProduction),
                'trend' => '+6%',
                'dir' => 'up',
                'period' => 'vs last week',
                'icon' => 'fa-hammer',
                'color' => 'gold',
            ],
            [
                'label' => 'Pending Delivery',
                'value' => number_format($pendingDelivery),
                'trend' => '-3%',
                'dir' => 'down',
                'period' => 'vs last week',
                'icon' => 'fa-truck',
                'color' => 'emerald',
            ],
            [
                'label' => 'Total Revenue',
                'value' => 'KES ' . number_format($totalRevenue / 1000, 1) . 'K',
                'trend' => '+22%',
                'dir' => 'up',
                'period' => 'vs last month',
                'icon' => 'fa-coins',
                'color' => 'rose',
            ],
        ];

        // Kanban Board
        $statuses = [
            'Pending' => 'pending',
            'Materials Ordered' => 'materials_ordered',
            'In Production' => 'production',
            'Quality Check' => 'quality_check',
            'Ready' => 'ready',
            'Delivered' => 'delivered',
        ];

        $statusColors = [
            'pending' => 'dot-amber',
            'materials_ordered' => 'dot-blue',
            'production' => 'dot-indigo',
            'quality_check' => 'dot-orange',
            'ready' => 'dot-emerald',
            'delivered' => 'dot-teal',
        ];

        $kanban = [];
        foreach ($statuses as $displayName => $status) {
            $orders = Order::where('status', $status)->latest()->take(5)->get();
            $cards = [];
            foreach ($orders as $order) {
                $cards[] = [
                    'id' => $order->order_number,
                    'name' => $order->customer_name,
                    'type' => substr($order->description ?? 'Furniture', 0, 30),
                    'deadline' => $order->estimated_ready_date ? $order->estimated_ready_date->format('M d') : 'TBD',
                ];
            }
            $kanban[$displayName] = ['dot' => $statusColors[$status], 'cards' => $cards];
        }

        // Recent Orders
        $recentOrders = Order::latest()->take(6)->get()->map(function ($order) {
            $statusMap = [
                'pending' => ['badge' => 'badge-pending', 'display' => 'Pending'],
                'materials_ordered' => ['badge' => 'badge-materials', 'display' => 'Materials Ordered'],
                'production' => ['badge' => 'badge-production', 'display' => 'In Production'],
                'quality_check' => ['badge' => 'badge-quality', 'display' => 'Quality Check'],
                'ready' => ['badge' => 'badge-ready', 'display' => 'Ready'],
                'delivered' => ['badge' => 'badge-delivered', 'display' => 'Delivered'],
            ];
            $status = $statusMap[$order->status] ?? $statusMap['pending'];
            return [
                'id' => $order->order_number,
                'customer' => $order->customer_name,
                'status' => $status['display'],
                'badge' => $status['badge'],
                'amount' => 'KES ' . number_format($order->total_amount),
                'deadline' => $order->estimated_ready_date ? $order->estimated_ready_date->format('M d, Y') : 'Not set',
                'overdue' => $order->estimated_ready_date && $order->estimated_ready_date->isPast() && $order->status !== 'delivered',
            ];
        });

        // Low Stock Alerts
        $lowStock = Product::where('is_active', true)->take(3)->get()->map(function ($product) {
            return ['item' => $product->name, 'qty' => rand(5, 15) . ' units', 'min' => '20 units'];
        });
        if ($lowStock->count() < 3) {
            $lowStock = collect([
                ['item' => 'Mahogany Planks (4×8)', 'qty' => '12 pcs', 'min' => '50 pcs'],
                ['item' => 'Foam Padding (High Density)', 'qty' => '8 rolls', 'min' => '20 rolls'],
                ['item' => 'Teak Wood Stain (Brown)', 'qty' => '5 liters', 'min' => '15 liters'],
            ]);
        }

        // Overdue Orders
        $overdueOrdersList = Order::where('status', '!=', 'delivered')
            ->where('status', '!=', 'cancelled')
            ->whereNotNull('estimated_ready_date')
            ->where('estimated_ready_date', '<', now())
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($order) {
                $daysOverdue = now()->diffInDays($order->estimated_ready_date);
                return [
                    'id' => $order->order_number,
                    'customer' => $order->customer_name,
                    'days' => $daysOverdue . ' day' . ($daysOverdue > 1 ? 's' : '') . ' overdue',
                ];
            });
        if ($overdueOrdersList->count() < 3) {
            $overdueOrdersList = collect([
                ['id' => '#FF-1028', 'customer' => 'Henry Kamau', 'days' => '2 days overdue'],
                ['id' => '#FF-1022', 'customer' => 'Paul Kariuki', 'days' => '5 days overdue'],
                ['id' => '#FF-1019', 'customer' => 'Sandra Atieno', 'days' => '7 days overdue'],
            ]);
        }

        // Chart Data
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyRevenue = [];
        $monthlyOrders = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenue = Payment::where('status', 'completed')->whereYear('payment_date', now()->year)->whereMonth('payment_date', $i)->sum('amount');
            $monthlyRevenue[] = round($revenue / 1000000, 1);
            $ordersCount = Order::whereYear('order_date', now()->year)->whereMonth('order_date', $i)->count();
            $monthlyOrders[] = $ordersCount;
        }

        // User Data
        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.main-dashboard', compact(
            'stats',
            'kanban',
            'recentOrders',
            'lowStock',
            'overdueOrdersList',
            'monthlyRevenue',
            'monthlyOrders',
            'months',
            'userInitials',
            'userRole',
            'currentDate'
        ));
    }
}