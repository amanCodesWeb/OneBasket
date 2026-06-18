<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status', 'order_status',
        'subtotal', 'total_item_count', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'         => 'decimal:2',
            'total_item_count' => 'integer',
        ];
    }

    // ── Vendor fulfillment status constants ────────────────────
    const STATUS_PENDING          = 'pending';
    const STATUS_CONFIRMED        = 'confirmed';
    const STATUS_PROCESSING       = 'processing';
    const STATUS_READY_FOR_PICKUP = 'ready_for_pickup';
    const STATUS_COLLECTED        = 'collected';
    const STATUS_PACKING          = 'packing';
    const STATUS_PACKED           = 'packed';
    const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';
    const STATUS_DELIVERED        = 'delivered';
    const STATUS_CANCELLED        = 'cancelled';

    public static array $statuses = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_PROCESSING,
        self::STATUS_READY_FOR_PICKUP,
        self::STATUS_COLLECTED,
        self::STATUS_PACKING,
        self::STATUS_PACKED,
        self::STATUS_OUT_FOR_DELIVERY,
        self::STATUS_DELIVERED,
        self::STATUS_CANCELLED,
    ];

    public static array $customerStatuses = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_PROCESSING,
        self::STATUS_READY_FOR_PICKUP,
        self::STATUS_COLLECTED,
        self::STATUS_PACKING,
        self::STATUS_PACKED,
        self::STATUS_OUT_FOR_DELIVERY,
        self::STATUS_DELIVERED,
        self::STATUS_CANCELLED,
    ];

    // ── Platform / Customer-facing order status constants ──────
    const ORDER_STATUS_OPEN      = 'open';
    const ORDER_STATUS_SHIPPED   = 'shipped';
    const ORDER_STATUS_DELIVERED = 'delivered';
    const ORDER_STATUS_CANCELLED = 'cancelled';

    public static array $orderStatuses = [
        self::ORDER_STATUS_OPEN,
        self::ORDER_STATUS_SHIPPED,
        self::ORDER_STATUS_DELIVERED,
        self::ORDER_STATUS_CANCELLED,
    ];

    // ── Boot ──────────────────────────────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Order $order) {
            if (! $order->order_number) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'OB-';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));

        return $prefix . $date . '-' . $random;
    }

    // ── Scopes ────────────────────────────────────────────────────
    public function scopeForUser($q, $userId)
    {
        return $q->where('user_id', $userId);
    }

    // ── Relationships ─────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Vendor fulfillment status accessors ──────────────────────
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rs. ' . number_format($this->subtotal, 2);
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            self::STATUS_PENDING          => 'Pending',
            self::STATUS_CONFIRMED        => 'Confirmed',
            self::STATUS_PROCESSING       => 'Processing',
            self::STATUS_READY_FOR_PICKUP => 'Ready for Pickup',
            self::STATUS_COLLECTED        => 'Collected',
            self::STATUS_PACKING          => 'Packing',
            self::STATUS_PACKED           => 'Packed',
            self::STATUS_OUT_FOR_DELIVERY => 'Out for Delivery',
            self::STATUS_DELIVERED        => 'Delivered',
            self::STATUS_CANCELLED        => 'Cancelled',
        ];

        return $labels[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            self::STATUS_PENDING          => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
            self::STATUS_CONFIRMED        => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            self::STATUS_PROCESSING       => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
            self::STATUS_READY_FOR_PICKUP => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            self::STATUS_COLLECTED        => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300',
            self::STATUS_PACKING          => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
            self::STATUS_PACKED           => 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-300',
            self::STATUS_OUT_FOR_DELIVERY => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
            self::STATUS_DELIVERED        => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            self::STATUS_CANCELLED        => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';

        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$color}\">{$this->status_label}</span>";
    }

    // ── Order status accessors (customer-facing) ───────────────
    public function getOrderStatusLabelAttribute(): string
    {
        $labels = [
            self::ORDER_STATUS_OPEN      => 'Open',
            self::ORDER_STATUS_SHIPPED   => 'Shipped',
            self::ORDER_STATUS_DELIVERED => 'Delivered',
            self::ORDER_STATUS_CANCELLED => 'Cancelled',
        ];

        return $labels[$this->order_status] ?? ucfirst($this->order_status);
    }

    public function getOrderStatusBadgeAttribute(): string
    {
        $colors = [
            self::ORDER_STATUS_OPEN      => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
            self::ORDER_STATUS_SHIPPED   => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
            self::ORDER_STATUS_DELIVERED => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            self::ORDER_STATUS_CANCELLED => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
        ];

        $color = $colors[$this->order_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';

        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$color}\">{$this->order_status_label}</span>";
    }
}
