<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        // Create a vendor user if not exists
        $vendorUser = User::firstOrCreate(
            ['email' => 'vendor@onebasket.test'],
            [
                'name'     => 'Green Grocer Co.',
                'password' => 'password',
                'role'     => User::ROLE_VENDOR,
            ]
        );

        Vendor::create([
            'user_id'            => $vendorUser->id,
            'business_name'      => 'Green Grocer Co.',
            'slug'               => 'green-grocer-co',
            'description'        => 'Fresh organic produce sourced directly from local farms. We offer fruits, vegetables, herbs, and seasonal specials.',
            'address'            => '123 Market Street, Downtown',
            'phone'              => '+1-555-0101',
            'whatsapp'           => '+1-555-0101',
            'status'             => Vendor::STATUS_ACTIVE,
            'verified_at'        => now(),
            'delivery_radius_km' => 10,
            'commission_rate'    => 5.00,
        ]);

        // Second vendor
        $vendorUser2 = User::firstOrCreate(
            ['email' => 'bakery@onebasket.test'],
            [
                'name'     => 'Bella\'s Bakery',
                'password' => 'password',
                'role'     => User::ROLE_VENDOR,
            ]
        );

        Vendor::create([
            'user_id'            => $vendorUser2->id,
            'business_name'      => "Bella's Bakery",
            'slug'               => 'bellas-bakery',
            'description'        => 'Artisan bread, pastries, cakes, and cookies baked fresh daily using traditional recipes.',
            'address'            => '456 Oak Avenue, Midtown',
            'phone'              => '+1-555-0102',
            'whatsapp'           => '+1-555-0102',
            'status'             => Vendor::STATUS_ACTIVE,
            'verified_at'        => now(),
            'delivery_radius_km' => 8,
            'commission_rate'    => 5.00,
        ]);

        // One pending vendor
        $vendorUser3 = User::firstOrCreate(
            ['email' => 'pharmacy@onebasket.test'],
            [
                'name'     => 'City Pharmacy',
                'password' => 'password',
                'role'     => User::ROLE_VENDOR,
            ]
        );

        Vendor::create([
            'user_id'            => $vendorUser3->id,
            'business_name'      => 'City Pharmacy',
            'slug'               => 'city-pharmacy',
            'description'        => 'Over-the-counter medicines, health supplements, and personal care products.',
            'address'            => '789 Pine Road, Uptown',
            'phone'              => '+1-555-0103',
            'status'             => Vendor::STATUS_PENDING,
            'delivery_radius_km' => 5,
        ]);

        $this->command->info('3 vendors seeded (2 active, 1 pending).');
    }
}
