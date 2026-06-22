<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display the homepage with dynamic data from the database.
     */
    public function index()
    {
        // Fetch 4 featured active products for the "Popular Parts" section
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        // If there are not enough featured products, pad with latest active products
        if ($featuredProducts->count() < 4) {
            $featuredIds = $featuredProducts->pluck('id')->toArray();
            $extra = Product::where('is_active', true)
                ->whereNotIn('id', $featuredIds)
                ->with('category')
                ->orderByDesc('created_at')
                ->take(4 - $featuredProducts->count())
                ->get();
            $featuredProducts = $featuredProducts->merge($extra);
        }

        // Fetch 3 latest published blog posts for the homepage blog section
        $latestBlogs = Blog::where('status', 'published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        // Fetch top-level categories (no parent) for the categories section
        $categories = Category::whereNull('parent_id')
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();

        return view('frontend.home', compact('featuredProducts', 'latestBlogs', 'categories'));
    }
}
