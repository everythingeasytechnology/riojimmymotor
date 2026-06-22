<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the blog listing page with optional category filter and search.
     */
    public function index(Request $request)
    {
        $query = Blog::where('status', 'published');

        // Filter by category name if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Keyword search across title and summary
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('title', 'like', "%{$q}%")
                   ->orWhere('summary', 'like', "%{$q}%");
            });
        }

        // Order by published date descending
        $query->orderByDesc('published_at');

        // Paginate — 9 posts per page
        $blogs = $query->paginate(9)->withQueryString();

        // Unique categories for the filter sidebar
        $blogCategories = Blog::where('status', 'published')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        // 3 recent posts for the sidebar widget
        $recentPosts = Blog::where('status', 'published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('frontend.blog', compact('blogs', 'blogCategories', 'recentPosts'));
    }

    /**
     * Show a single blog post by slug.
     */
    public function show(string $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // 3 related posts from the same category (excluding current)
        $related = Blog::where('status', 'published')
            ->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        // 3 recent posts for sidebar
        $recentPosts = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('frontend.blog-details', compact('blog', 'related', 'recentPosts'));
    }
}
