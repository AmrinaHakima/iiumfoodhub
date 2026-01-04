<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // e.g., F0000243251
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cafe_id')->constrained();
            $table->decimal('total_amount', 8, 2);
            $table->string('delivery_method'); // 'Self pickup' or 'Delivery'
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
