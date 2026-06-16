<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number', 20)->unique();
            $table->string('status', 30)->default('pending');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->unsignedInteger('total_item_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
