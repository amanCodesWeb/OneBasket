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

    // ── Fulfillment status constants ───────────────────────────
    const STATUS_PENDING          = 'pending';
    const STATUS_PACKED           = 'packed';
    const STATUS_PICKED_UP        = 'picked_up';
    const STATUS_DELIVERED        = 'delivered';
    const STATUS_CANCELLED        = 'cancelled';

    // ── Vendor-only statuses (3-step flow) ────────────────────
    public static array $vendorStatuses = [
        self::STATUS_PENDING,
        self::STATUS_PACKED,
        self::STATUS_PICKED_UP,
        self::STATUS_CANCELLED,
    ];

    // ── Platform / Customer-facing order status constants ──────
    const ORDER_STATUS_OPEN      = 'open';
    const ORDER_STATUS_PAID      = 'paid';
    const ORDER_STATUS_IN_PROGRESS = 'in_progress';
    const ORDER_STATUS_SHIPPED   = 'shipped';
    const ORDER_STATUS_DELIVERED = 'delivered';
    const ORDER_STATUS_CANCELLED = 'cancelled';
    const ORDER_STATUS_FAILED    = 'failed';

    public static array $orderStatuses = [
        self::ORDER_STATUS_OPEN,
        self::ORDER_STATUS_PAID,
        self::ORDER_STATUS_IN_PROGRESS,
        self::ORDER_STATUS_SHIPPED,
        self::ORDER_STATUS_DELIVERED,
        self::ORDER_STATUS_CANCELLED,
        self::ORDER_STATUS_FAILED,
    ];

    // ── Vendor-facing status labels & colors (3-step flow) ────
    public static array $vendorStatusLabels = [
        'pending'   => 'Open',
        'packed'    => 'Packed',
        'picked_up' => 'Picked Up',
        'cancelled' => 'Cancelled',
    ];

    public static array $vendorStatusColors = [
        'pending'   => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-700/50',
        'packed'    => 'bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300 border-teal-200 dark:border-teal-700/50',
        'picked_up' => 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border-green-200 dark:border-green-700/50',
        'cancelled' => 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border-red-200 dark:border-red-700/50',
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
            self::STATUS_PACKED           => 'Packed',
            self::STATUS_PICKED_UP        => 'Picked Up',
            self::STATUS_DELIVERED        => 'Delivered',
            self::STATUS_CANCELLED        => 'Cancelled',
        ];

        return $labels[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            self::STATUS_PENDING          => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
            self::STATUS_PACKED           => 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-300',
            self::STATUS_PICKED_UP        => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
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
            self::ORDER_STATUS_OPEN       => 'Open',
            self::ORDER_STATUS_PAID       => 'Paid',
            self::ORDER_STATUS_IN_PROGRESS => 'In Progress',
            self::ORDER_STATUS_SHIPPED    => 'Shipped',
            self::ORDER_STATUS_DELIVERED  => 'Delivered',
            self::ORDER_STATUS_CANCELLED  => 'Cancelled',
            self::ORDER_STATUS_FAILED     => 'Failed',
        ];

        return $labels[$this->order_status] ?? ucfirst($this->order_status);
    }

    public function getOrderStatusBadgeAttribute(): string
    {
        $colors = [
            self::ORDER_STATUS_OPEN       => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
            self::ORDER_STATUS_PAID       => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            self::ORDER_STATUS_IN_PROGRESS => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            self::ORDER_STATUS_SHIPPED    => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            self::ORDER_STATUS_DELIVERED  => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            self::ORDER_STATUS_CANCELLED  => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
            self::ORDER_STATUS_FAILED     => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
        ];

        $color = $colors[$this->order_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';

        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$color}\">{$this->order_status_label}</span>";
    }
}
