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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            
            $table->string('brand')->nullable();
            $table->string('condition')->default('Used'); // e.g. Used, OEM Takeoff, Salvage, New
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->default(1);
            
            $table->text('description')->nullable();
            $table->json('specifications')->nullable(); // Key-value specs
            $table->json('compatibility')->nullable(); // Compatible years/makes/models
            $table->string('warranty')->nullable();
            $table->json('images')->nullable(); // Gallery image filepaths list
            
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            // Product specific SEO columns
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->text('schema_markup')->nullable(); // For Custom Schema Injection

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
