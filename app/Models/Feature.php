<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Feature extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'options', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'options' => 'array',
        ];
    }

    // ── Scopes ───────────────────────────────────────────────────
    public function scopeActive($q)  { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order')->orderBy('name'); }

    // ── Helpers ──────────────────────────────────────────────────
    public function isText(): bool       { return $this->type === 'text'; }
    public function isBoolean(): bool    { return $this->type === 'boolean'; }
    public function isSelect(): bool     { return $this->type === 'select'; }
    public function isMultiSelect(): bool { return $this->type === 'multi_select'; }

    public static array $types = ['text', 'boolean', 'select', 'multi_select'];

    // ── Boot ────────────────────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Feature $feature) {
            if (empty($feature->slug)) {
                $feature->slug = Str::slug($feature->name) . '-' . Str::random(4);
            }
        });
    }

    // ── Relationships ───────────────────────────────────────────
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('value')
            ->withTimestamps();
    }
}
