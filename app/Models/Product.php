<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name', 'sku', 'slug', 'category_id', 'brand', 'condition', 'price',
    'sale_price', 'stock', 'description', 'specifications', 'compatibility',
    'warranty', 'images', 'is_featured', 'is_active', 'meta_title',
    'meta_description', 'meta_keywords', 'canonical_url', 'schema_markup'
])]
class Product extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'compatibility' => 'array',
            'images' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2'
        ];
    }

    /**
     * Relationship with category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
