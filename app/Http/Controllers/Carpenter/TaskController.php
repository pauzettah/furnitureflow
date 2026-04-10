<?php

namespace App\Http\Controllers\Carpenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        // Sample data - replace with database queries
        $tasks = collect([
            [
                'order_id' => 'ORD-2041',
                'title' => 'King Bed Frame',
                'customer' => 'Amina Oduya',
                'deadline' => 'Today, 5:00 PM',
                'urgent' => true,
                'status' => 'in_progress',
                'dimensions' => '6ft × 6ft (183cm × 183cm)',
                'materials' => ['Mahogany planks ×8', 'Wood screws ×40', 'Foam padding ×2', 'Sandpaper (220-grit) ×3'],
                'instructions' => 'Customer prefers a matte finish. Headboard height must be exactly 120cm. No visible screws on outer faces.',
                'images' => ['https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=300&q=70'],
            ],
            [
                'order_id' => 'ORD-2038',
                'title' => '3-Seater Sofa',
                'customer' => 'Brian Kamau',
                'deadline' => 'Tomorrow, 12:00 PM',
                'urgent' => false,
                'status' => 'pending',
                'dimensions' => '220cm × 90cm × 85cm',
                'materials' => ['Hardwood frame pieces ×12', 'Webbing straps ×1 roll', 'High-density foam ×3', 'Fabric upholstery ×5m'],
                'instructions' => 'Fabric colour: Steel Grey (SKU #FBR-447). Legs must be removable for delivery.',
                'images' => ['https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=300&q=70'],
            ],
            [
                'order_id' => 'ORD-2035',
                'title' => 'Study Desk',
                'customer' => 'Cynthia Njeri',
                'deadline' => 'Apr 12, 3:00 PM',
                'urgent' => false,
                'status' => 'pending',
                'dimensions' => '140cm × 60cm × 75cm',
                'materials' => ['MDF board ×4', 'Edge banding ×5m', 'Cabinet hinges ×4', 'Drawer slides ×2 pairs'],
                'instructions' => 'Include one cable management hole (60mm diameter) on the right side. Drawer lock required.',
                'images' => ['https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=300&q=70'],
            ],
            [
                'order_id' => 'ORD-2030',
                'title' => 'Wardrobe (4-door)',
                'customer' => 'David Otieno',
                'deadline' => 'Apr 10, 9:00 AM',
                'urgent' => true,
                'status' => 'ready',
                'dimensions' => '200cm × 55cm × 220cm',
                'materials' => ['Plywood sheets ×10', 'Mirror panel ×2', 'Handles ×8', 'Piano hinges ×4'],
                'instructions' => 'Two of the four doors should have mirrors. Internal shelving: 5 shelves on left, hanging rail on right.',
                'images' => [],
            ],
        ]);

        $completedCount = $tasks->where('status', 'ready')->count();
        $totalCount = $tasks->count();
        $progressPercent = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;

        return view('carpenter.dashboard', compact('tasks', 'completedCount', 'totalCount', 'progressPercent'));
    }
}