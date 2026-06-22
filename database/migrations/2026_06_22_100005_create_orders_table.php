<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Orders Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            
            $table->string('status')->default('pending'); // pending, paid, processing, shipped, delivered, cancelled, refunded
            $table->string('payment_method')->nullable(); // Stripe, PayPal, Razorpay, Authorize.Net, Square, Payoneer, Bank Transfer
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, failed, refunded
            $table->string('transaction_id')->nullable();
            
            $table->string('invoice_path')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('refund_reason')->nullable();
            
            $table->timestamps();
        });

        // 2. Order Items Table
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            
            $table->string('product_name'); // Snapshot at the time of purchase
            $table->string('product_sku');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
