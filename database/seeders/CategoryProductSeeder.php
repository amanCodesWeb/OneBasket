<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ───────────────────────────────────────────
        $groceries = Category::create(['name' => 'Groceries',  'slug' => 'groceries',  'description' => 'Fresh fruits, vegetables, and daily essentials', 'sort_order' => 1, 'is_active' => true]);
        $bakery    = Category::create(['name' => 'Bakery',     'slug' => 'bakery',     'description' => 'Bread, pastries, cakes, and baked goods',       'sort_order' => 2, 'is_active' => true]);
        $dairy     = Category::create(['name' => 'Dairy',      'slug' => 'dairy',      'description' => 'Milk, cheese, yogurt, and dairy products',      'sort_order' => 3, 'is_active' => true]);
        $beverages = Category::create(['name' => 'Beverages',  'slug' => 'beverages',  'description' => 'Juices, soft drinks, and refreshments',         'sort_order' => 4, 'is_active' => true]);
        $snacks    = Category::create(['name' => 'Snacks',     'slug' => 'snacks',     'description' => 'Chips, nuts, and quick bites',                 'sort_order' => 5, 'is_active' => true]);
        $pharmacy  = Category::create(['name' => 'Pharmacy',   'slug' => 'pharmacy',   'description' => 'Medicines, supplements, and health care',       'sort_order' => 6, 'is_active' => true]);
        $personal  = Category::create(['name' => 'Personal Care', 'slug' => 'personal-care', 'description' => 'Beauty, hygiene, and grooming products', 'sort_order' => 7, 'is_active' => true]);

        // Sub-categories
        Category::create(['name' => 'Fruits',       'slug' => 'fruits',        'parent_id' => $groceries->id, 'sort_order' => 1, 'is_active' => true]);
        Category::create(['name' => 'Vegetables',   'slug' => 'vegetables',    'parent_id' => $groceries->id, 'sort_order' => 2, 'is_active' => true]);
        Category::create(['name' => 'Bread & Rolls','slug' => 'bread-rolls',   'parent_id' => $bakery->id,    'sort_order' => 1, 'is_active' => true]);
        Category::create(['name' => 'Cakes',        'slug' => 'cakes',         'parent_id' => $bakery->id,    'sort_order' => 2, 'is_active' => true]);
        Category::create(['name' => 'Cold Drinks',  'slug' => 'cold-drinks',   'parent_id' => $beverages->id, 'sort_order' => 1, 'is_active' => true]);

        $this->command->info('Categories seeded: ' . Category::count());

        // ── Products ─────────────────────────────────────────────
        $vendors = Vendor::active()->get();
        if ($vendors->count() < 2) {
            $this->command->warn('Need at least 2 active vendors. Run VendorSeeder first.');
            return;
        }

        [$v1, $v2] = [$vendors[0], $vendors[1]];

        $products = [
            // Green Grocer Co. products
            ['vendor_id' => $v1->id, 'category_id' => 1, 'name' => 'Organic Bananas',         'slug' => 'organic-bananas',      'price' => 49, 'compare_price' => 59, 'status' => 'active', 'featured' => true,  'stock_quantity' => 50, 'unit' => 'dozen', 'images' => ['https://picsum.photos/seed/banana/400/400']],
            ['vendor_id' => $v1->id, 'category_id' => 1, 'name' => 'Fresh Apples (1kg)',      'slug' => 'fresh-apples-1kg',     'price' => 89, 'compare_price' => 99, 'status' => 'active', 'featured' => true,  'stock_quantity' => 30, 'unit' => 'kg', 'images' => ['https://picsum.photos/seed/apple/400/400']],
            ['vendor_id' => $v1->id, 'category_id' => 1, 'name' => 'Mixed Vegetables Box',    'slug' => 'mixed-vegetables-box', 'price' => 149, 'compare_price' => null, 'status' => 'active', 'featured' => false, 'stock_quantity' => 20, 'unit' => 'box', 'images' => ['https://picsum.photos/seed/veggie/400/400']],
            ['vendor_id' => $v1->id, 'category_id' => 1, 'name' => 'Fresh Tomatoes (500g)',   'slug' => 'fresh-tomatoes-500g',   'price' => 39, 'compare_price' => 45, 'status' => 'active', 'featured' => false, 'stock_quantity' => 40, 'unit' => 'pack', 'images' => ['https://picsum.photos/seed/tomato/400/400']],
            ['vendor_id' => $v1->id, 'category_id' => 3, 'name' => 'Farm Fresh Eggs (6 pcs)', 'slug' => 'farm-fresh-eggs-6',    'price' => 45, 'compare_price' => null, 'status' => 'active', 'featured' => true,  'stock_quantity' => 60, 'unit' => 'pack', 'images' => ['https://picsum.photos/seed/eggs/400/400']],
            ['vendor_id' => $v1->id, 'category_id' => 2, 'name' => 'Whole Wheat Bread',       'slug' => 'whole-wheat-bread',    'price' => 35, 'compare_price' => 40, 'status' => 'active', 'featured' => false, 'stock_quantity' => 25, 'unit' => 'loaf', 'images' => ['https://picsum.photos/seed/bread/400/400']],

            // Bella's Bakery products
            ['vendor_id' => $v2->id, 'category_id' => 2, 'name' => 'Sourdough Loaf',          'slug' => 'sourdough-loaf',       'price' => 75, 'compare_price' => 85, 'status' => 'active', 'featured' => true,  'stock_quantity' => 15, 'unit' => 'loaf', 'images' => ['https://picsum.photos/seed/sourdough/400/400']],
            ['vendor_id' => $v2->id, 'category_id' => 2, 'name' => 'Chocolate Croissant',     'slug' => 'chocolate-croissant',  'price' => 55, 'compare_price' => null, 'status' => 'active', 'featured' => true,  'stock_quantity' => 20, 'unit' => 'piece', 'images' => ['https://picsum.photos/seed/croissant/400/400']],
            ['vendor_id' => $v2->id, 'category_id' => 5, 'name' => 'Butter Cookies (200g)',   'slug' => 'butter-cookies-200g',  'price' => 65, 'compare_price' => 80, 'status' => 'active', 'featured' => false, 'stock_quantity' => 35, 'unit' => 'pack', 'images' => ['https://picsum.photos/seed/cookies/400/400']],
            ['vendor_id' => $v2->id, 'category_id' => 5, 'name' => 'Blueberry Muffin',        'slug' => 'blueberry-muffin',     'price' => 45, 'compare_price' => null, 'status' => 'active', 'featured' => false, 'stock_quantity' => 18, 'unit' => 'piece', 'images' => ['https://picsum.photos/seed/muffin/400/400']],
            ['vendor_id' => $v2->id, 'category_id' => 2, 'name' => 'Cinnamon Roll',           'slug' => 'cinnamon-roll',       'price' => 50, 'compare_price' => 60, 'status' => 'active', 'featured' => true,  'stock_quantity' => 12, 'unit' => 'piece', 'images' => ['https://picsum.photos/seed/cinnamon/400/400']],
            ['vendor_id' => $v2->id, 'category_id' => 4, 'name' => 'Fresh Orange Juice',      'slug' => 'fresh-orange-juice',   'price' => 60, 'compare_price' => null, 'status' => 'draft', 'featured' => false, 'stock_quantity' => 0,  'unit' => 'liter', 'images' => ['https://picsum.photos/seed/orange-juice/400/400']],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }

        $this->command->info('Products seeded: ' . Product::count());
    }
}
