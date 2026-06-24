<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Lead;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Store a new search lead inquiry.
     */
    public function submitInquiry(Request $request)
    {
        $request->validate([
            'vehicle' => 'required|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $vehicle = $request->input('vehicle');
        
        // Parse Year, Make, Model from input string
        $parts = explode(' ', trim($vehicle), 3);
        $year = null;
        $make = null;
        $model = null;

        if (count($parts) > 0 && is_numeric($parts[0])) {
            $year = $parts[0];
            if (count($parts) > 1) {
                $make = $parts[1];
            }
            if (count($parts) > 2) {
                $model = $parts[2];
            }
        } else {
            $make = $parts[0] ?? null;
            $model = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : null;
        }

        Lead::create([
            'name' => 'Search Form Quote Request',
            'email' => 'phone-lead@example.com',
            'phone' => $request->input('phone'),
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'part_requested' => 'Engine / Transmission',
            'notes' => 'Engine Size: ' . ($request->input('engine_size') ?: 'N/A'),
            'status' => 'new',
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quote request submitted successfully! A parts specialist will contact you shortly.'
        ]);
    }

    /**
     * Store a new contact lead inquiry from the contact page.
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'vin' => 'nullable|string|max:17',
            'year' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'part_requested' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Lead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'vin' => $request->input('vin'),
            'year' => $request->input('year'),
            'make' => $request->input('make'),
            'model' => $request->input('model'),
            'part_requested' => $request->input('part_requested'),
            'notes' => $request->input('notes'),
            'status' => 'new',
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your parts inquiry has been submitted successfully! An auto parts specialist will contact you shortly.'
        ]);
    }

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
