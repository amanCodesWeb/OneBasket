<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'slug',
        'description',
        'address',
        'phone',
        'whatsapp',
        'logo',
        'cover_image',
        'status',
        'verified_at',
        'delivery_radius_km',
        'commission_rate',
    ];

    protected function casts(): array
    {
        return [
            'verified_at'       => 'datetime',
            'delivery_radius_km' => 'decimal:2',
            'commission_rate'   => 'decimal:2',
        ];
    }

    // ── Status constants ────────────────────────────────────────
    const STATUS_PENDING   = 'pending';
    const STATUS_ACTIVE    = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_REJECTED  = 'rejected';

    public static array $statuses = [
        self::STATUS_PENDING,
        self::STATUS_ACTIVE,
        self::STATUS_SUSPENDED,
        self::STATUS_REJECTED,
    ];

    // ── Relationships ───────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ──────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    // ── Helpers ─────────────────────────────────────────────────
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    // ── Boot ────────────────────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Vendor $vendor) {
            if (empty($vendor->slug)) {
                $vendor->slug = Str::slug($vendor->business_name) . '-' . Str::random(4);
            }
        });
    }
}
