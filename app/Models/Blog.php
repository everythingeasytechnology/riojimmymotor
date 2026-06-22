<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'title', 'slug', 'summary', 'content', 'image', 'category', 'tags',
    'status', 'published_at', 'author_id', 'meta_title', 'meta_description',
    'meta_keywords', 'canonical_url', 'faq_schema', 'article_schema'
])]
class Blog extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'faq_schema' => 'array',
            'published_at' => 'datetime'
        ];
    }

    /**
     * Relationship with author.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
