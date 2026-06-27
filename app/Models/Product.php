<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'vendor_id', 'category_id', 'name', 'slug', 'description',
        'price', 'compare_price', 'images', 'status', 'featured',
        'stock_quantity', 'unit', 'is_approved',
        'weight', 'length', 'width', 'height', 'items_in_pack',
    ];

    protected function casts(): array
    {
        return [
            'price'         => 'decimal:2',
            'compare_price' => 'decimal:2',
            'images'        => 'array',
            'featured'      => 'boolean',
            'stock_quantity'=> 'integer',
            'is_approved'   => 'boolean',
            'weight'        => 'decimal:2',
            'length'        => 'decimal:2',
            'width'         => 'decimal:2',
            'height'        => 'decimal:2',
            'items_in_pack' => 'integer',
        ];
    }

    // ── Scopes ───────────────────────────────────────────────────
    public function scopeActive($q)   { return $q->where('status', 'active'); }
    public function scopeFeatured($q) { return $q->where('featured', true); }
    public function scopeInStock($q)  { return $q->where('stock_quantity', '>', 0); }
    public function scopeApproved($q) { return $q->where('is_approved', true); }
    public function scopePendingApproval($q) { return $q->where('is_approved', false); }

    // ── Relationships ────────────────────────────────────────────
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_product')
            ->withPivot('value')
            ->withTimestamps();
    }

    // ── Accessors ────────────────────────────────────────────────
    public function getThumbnailAttribute(): ?string
    {
        $images = $this->images;
        return is_array($images) && count($images) > 0 ? $images[0] : null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->price, 2);
    }

    public function getFormattedComparePriceAttribute(): ?string
    {
        return $this->compare_price ? 'Rs. ' . number_format($this->compare_price, 2) : null;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (! $this->hasDiscount) return null;
        return (int) round((1 - $this->price / $this->compare_price) * 100);
    }
}
