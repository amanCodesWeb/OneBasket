<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'parent_id', 'image', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // ── Scopes ───────────────────────────────────────────────────
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeRoot($q)   { return $q->whereNull('parent_id'); }
    public function scopeOrdered($q){ return $q->orderBy('sort_order')->orderBy('name'); }

    // ── Relationships ────────────────────────────────────────────
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->ordered();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // ── Helpers ──────────────────────────────────────────────────
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }
}
