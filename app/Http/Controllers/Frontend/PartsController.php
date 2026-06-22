<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PartsController extends Controller
{
    /**
     * Display the parts catalog with search and filter support.
     */
    public function index(Request $request)
    {
        // Start with active products query
        $query = Product::where('is_active', true)->with('category');

        // Filter by category slug if provided
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by brand/make if provided
        if ($request->filled('make')) {
            $query->where('brand', $request->make);
        }

        // Filter by keyword (part name or SKU)
        if ($request->filled('part_name')) {
            $search = $request->part_name;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by condition (used, refurbished, oem-genuine)
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort order
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            default      => $query->orderByDesc('created_at'),
        };

        // Paginate results — 12 per page
        $products = $query->paginate(12)->withQueryString();

        // Sidebar filter data
        $allCategories = Category::whereNull('parent_id')->withCount('products')->get();

        // Unique brand list from active products for the make filter
        $brands = Product::where('is_active', true)
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand')
            ->sort()
            ->values();

        // Total count for display
        $totalResults = $products->total();

        return view('frontend.parts', compact('products', 'allCategories', 'brands', 'totalResults'));
    }

    /**
     * Show a single product detail page.
     */
    public function show(string $slug)
    {
        // Load the product by its slug or fail with a 404
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        // Related products from the same category
        $relatedProducts = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.part-details', compact('product', 'relatedProducts'));
    }
}
