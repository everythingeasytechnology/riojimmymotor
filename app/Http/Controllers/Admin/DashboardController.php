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



        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_products'));
    }
}
