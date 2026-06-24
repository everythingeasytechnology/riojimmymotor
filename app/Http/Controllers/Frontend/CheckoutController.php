<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show checkout form for cart items.
     */
    public function index(Request $request)
    {
        $productSlug = $request->query('product');
        if ($productSlug) {
            $product = Product::where('slug', $productSlug)->where('is_active', true)->first();
            if ($product) {
                // Automatically add to session cart
                $cart = session()->get('cart', []);
                if (!isset($cart[$product->id])) {
                    $cart[$product->id] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'slug' => $product->slug,
                        'price' => $product->price,
                        'image' => !empty($product->images) && is_array($product->images) ? $product->images[0] : 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=800&auto=format&fit=crop',
                        'quantity' => 1,
                        'stock' => $product->stock
                    ];
                    session()->put('cart', $cart);
                }
            }
            return redirect()->route('checkout');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items to proceed.');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        $shipping = 0.00;
        $tax = 0.00;
        $total = $subtotal + $shipping + $tax;

        return view('frontend.checkout', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Process checkout form and place order.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'payment_method' => 'required|in:stripe,razorpay',
            'order_notes' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Verify stock for all items
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('cart')->with('error', "Only {$product->stock} units of '{$item['name']}' are available. Please update your cart.");
            }
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $shipping = 0.00;
        $tax = 0.00;
        $total = $subtotal + $shipping + $tax;

        $billingAddress = $request->street_address;
        if ($request->street_address_2) {
            $billingAddress .= ', ' . $request->street_address_2;
        }
        $billingAddress .= ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip_code . ', US';

        // Generate unique order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . rand(1000, 9999);

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => null,
            'customer_name' => $request->first_name . ' ' . $request->last_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'billing_address' => $billingAddress,
            'shipping_address' => $billingAddress,
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'status' => 'processing',
            'payment_method' => $request->payment_method === 'razorpay' ? 'Razorpay' : 'Stripe',
            'payment_status' => 'paid',
            'refund_reason' => $request->order_notes
        ]);

        // Create OrderItems & Decrement Stock
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'price' => $product->price,
                'quantity' => $item['quantity']
            ]);

            // Decrement stock
            if ($product->stock > 0) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Clear session cart
        session()->forget('cart');

        return redirect()->route('checkout.success', ['order' => $order->order_number]);
    }

    /**
     * Display order success page.
     */
    public function success(Request $request)
    {
        $orderNumber = $request->query('order');
        if (!$orderNumber) {
            return redirect('/');
        }

        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();

        return view('frontend.order-success', compact('order'));
    }
}
