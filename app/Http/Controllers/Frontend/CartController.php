<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        
        return view('frontend.cart', compact('cart', 'subtotal'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $productId = $request->product_id;
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        if (!$product->is_active) {
            return redirect()->back()->with('error', 'This product is no longer active.');
        }

        $cart = session()->get('cart', []);

        // Calculate target quantity
        $existingQty = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $targetQty = $existingQty + $quantity;

        // Check stock
        if ($product->stock < $targetQty) {
            return redirect()->back()->with('error', "Only {$product->stock} units of {$product->name} are available in stock.");
        }

        // Add or update in cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $targetQty;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => !empty($product->images) && is_array($product->images) ? $product->images[0] : 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=800&auto=format&fit=crop',
                'quantity' => $quantity,
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);

        // Redirect directly to checkout if "Buy Now" was clicked
        if ($request->has('buy_now')) {
            return redirect()->route('checkout');
        }

        return redirect()->back()->with('success', "{$product->name} has been added to your cart!");
    }

    /**
     * Update quantity of an item in the cart.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return redirect()->route('cart')->with('error', 'Product not found in cart.');
        }

        // Check stock
        if ($product->stock < $quantity) {
            return redirect()->route('cart')->with('error', "Only {$product->stock} units of {$product->name} are available.");
        }

        $cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $name = $cart[$productId]['name'];
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->route('cart')->with('success', "{$name} removed from cart.");
        }

        return redirect()->route('cart')->with('error', 'Product not found in cart.');
    }

    /**
     * Clear all items in the cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart')->with('success', 'Cart cleared.');
    }
}
