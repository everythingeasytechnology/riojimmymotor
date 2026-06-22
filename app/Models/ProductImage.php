<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['product_id', 'image_path', 'is_primary'])]
class ProductImage extends Model
{
    /**
     * Relationship with product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
