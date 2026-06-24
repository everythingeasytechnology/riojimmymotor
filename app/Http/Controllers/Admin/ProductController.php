<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
        })->with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        // Handle json specifications mapping
        if ($request->has('spec_keys') && $request->has('spec_values')) {
            $specs = [];
            foreach ($request->spec_keys as $index => $key) {
                if (!empty($key)) {
                    $specs[$key] = $request->spec_values[$index] ?? '';
                }
            }
            $data['specifications'] = $specs;
        }

        // Handle compatibility array
        if ($request->has('compat_years') && $request->has('compat_makes')) {
            $compats = [];
            foreach ($request->compat_years as $index => $year) {
                if (!empty($year)) {
                    $compats[] = [
                        'year' => $year,
                        'make' => $request->compat_makes[$index] ?? '',
                        'model' => $request->compat_models[$index] ?? ''
                    ];
                }
            }
            $data['compatibility'] = $compats;
        }

        // Upload images gallery
        if ($request->hasFile('gallery_images')) {
            $images = [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $filename);
                $images[] = '/uploads/products/' . $filename;
            }
            $data['images'] = $images;
        } else {
            $data['images'] = ['/frontend/images/part-default.jpg'];
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        // Handle json specs
        if ($request->has('spec_keys') && $request->has('spec_values')) {
            $specs = [];
            foreach ($request->spec_keys as $index => $key) {
                if (!empty($key)) {
                    $specs[$key] = $request->spec_values[$index] ?? '';
                }
            }
            $data['specifications'] = $specs;
        }

        // Handle compatibility array
        if ($request->has('compat_years') && $request->has('compat_makes')) {
            $compats = [];
            foreach ($request->compat_years as $index => $year) {
                if (!empty($year)) {
                    $compats[] = [
                        'year' => $year,
                        'make' => $request->compat_makes[$index] ?? '',
                        'model' => $request->compat_models[$index] ?? ''
                    ];
                }
            }
            $data['compatibility'] = $compats;
        }

        // Gallery images upload
        if ($request->hasFile('gallery_images')) {
            $images = $product->images ?? [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $filename);
                $images[] = '/uploads/products/' . $filename;
            }
            $data['images'] = $images;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids) {
            Product::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Selected products deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No products selected.']);
    }

    /**
     * Import products from CSV.
     */
    public function importCsv(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt']);
        // Mock CSV parsing logic for frontend display
        return redirect()->route('admin.products.index')->with('success', 'Products CSV imported successfully (Mockup).');
    }

    /**
     * Export products to CSV.
     */
    public function exportCsv()
    {
        // Mock CSV download response
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=products_export.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $columns = ['ID', 'Name', 'SKU', 'Brand', 'Price', 'Stock', 'Condition'];
        
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            $products = Product::all();
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id, $product->name, $product->sku, $product->brand,
                    $product->price, $product->stock, $product->condition
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
