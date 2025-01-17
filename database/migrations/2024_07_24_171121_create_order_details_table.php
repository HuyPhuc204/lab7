<?php

use App\Models\Order;
use App\Models\Product;
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
        Schema::create('order_details', function (Blueprint $table) {
           $table->foreignIdFor(Order::class)->constrained();
           $table->foreignIdFor(Product::class)->constrained();
           $table->primary(['order_id', 'product_id']);
           $table->unsignedBigInteger('quantity');
           $table->unsignedBigInteger('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
