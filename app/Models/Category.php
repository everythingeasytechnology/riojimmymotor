<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name', 'slug', 'description', 'parent_id', 'image',
    'meta_title', 'meta_description', 'meta_keywords', 'canonical_url'
])]
class Category extends Model
{
    /**
     * Relationship with parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Relationship with child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Relationship with products.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
