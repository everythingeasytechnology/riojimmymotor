<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Blog;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main admin dashboard screen.
     */
    public function index()
    {
        // 1. Fetch real database statistics
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_blogs' => Blog::count(),
            'total_users' => User::count(),
            'total_leads' => Lead::count(),
            'unread_leads' => Lead::where('is_read', false)->count()
        ];

        // 2. Fetch recent tables activity
        $recent_orders = Order::latest()->take(5)->get();
        $recent_products = Product::latest()->take(5)->get();

        // 3. Fallbacks if database is empty (for demo/mockup visualization)
        if ($stats['total_products'] === 0) {
            $stats = [
                'total_products' => 1420,
                'total_categories' => 12,
                'total_orders' => 384,
                'total_revenue' => 124500.00,
                'total_blogs' => 18,
                'total_users' => 92,
                'total_leads' => 45,
                'unread_leads' => 8
            ];
        }

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_products'));
    }
}
