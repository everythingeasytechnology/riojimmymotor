<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,scheduled',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['author_id'] = Auth::id() ?? 1; // Default fallback to user 1

        // Status scheduling mapping
        if ($request->status === 'published') {
            $data['published_at'] = now();
        } elseif ($request->status === 'scheduled') {
            $data['published_at'] = $request->published_at;
        }

        // Tags parsing
        if (!empty($request->tags_input)) {
            $data['tags'] = array_map('trim', explode(',', $request->tags_input));
        }

        // FAQ JSON-LD metadata mapping
        if ($request->has('faq_questions') && $request->has('faq_answers')) {
            $faqs = [];
            foreach ($request->faq_questions as $index => $question) {
                if (!empty($question)) {
                    $faqs[] = [
                        'question' => $question,
                        'answer' => $request->faq_answers[$index] ?? ''
                    ];
                }
            }
            $data['faq_schema'] = $faqs;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blogs'), $filename);
            $data['image'] = '/uploads/blogs/' . $filename;
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,scheduled',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->status === 'published') {
            $data['published_at'] = now();
        } elseif ($request->status === 'scheduled') {
            $data['published_at'] = $request->published_at;
        }

        if (!empty($request->tags_input)) {
            $data['tags'] = array_map('trim', explode(',', $request->tags_input));
        }

        if ($request->has('faq_questions') && $request->has('faq_answers')) {
            $faqs = [];
            foreach ($request->faq_questions as $index => $question) {
                if (!empty($question)) {
                    $faqs[] = [
                        'question' => $question,
                        'answer' => $request->faq_answers[$index] ?? ''
                    ];
                }
            }
            $data['faq_schema'] = $faqs;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blogs'), $filename);
            $data['image'] = '/uploads/blogs/' . $filename;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog article deleted successfully.');
    }
}
