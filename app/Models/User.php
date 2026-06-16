<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // ── Role constants ──────────────────────────────────────────
    const ROLE_SUPER_ADMIN    = 'super_admin';
    const ROLE_OPS_MANAGER    = 'ops_manager';
    const ROLE_VENDOR         = 'vendor';
    const ROLE_CUSTOMER       = 'customer';
    const ROLE_PICKUP_AGENT   = 'pickup_agent';
    const ROLE_PACKING_STAFF  = 'packing_staff';
    const ROLE_DELIVERY_AGENT = 'delivery_agent';

    public static array $roles = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_OPS_MANAGER,
        self::ROLE_VENDOR,
        self::ROLE_CUSTOMER,
        self::ROLE_PICKUP_AGENT,
        self::ROLE_PACKING_STAFF,
        self::ROLE_DELIVERY_AGENT,
    ];

    // ── Helpers ─────────────────────────────────────────────────
    public function isSuperAdmin(): bool   { return $this->role === self::ROLE_SUPER_ADMIN; }
    public function isOpsManager(): bool   { return $this->role === self::ROLE_OPS_MANAGER; }
    public function isVendor(): bool       { return $this->role === self::ROLE_VENDOR; }
    public function isCustomer(): bool     { return $this->role === self::ROLE_CUSTOMER; }
    public function isPickupAgent(): bool  { return $this->role === self::ROLE_PICKUP_AGENT; }
    public function isPackingStaff(): bool { return $this->role === self::ROLE_PACKING_STAFF; }
    public function isDeliveryAgent(): bool { return $this->role === self::ROLE_DELIVERY_AGENT; }

    public function isAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_OPS_MANAGER]);
    }

    // ── Relationships ───────────────────────────────────────────
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
