<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// នៅក្នុង File ...create_order_items_table.php
public function up(): void
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        // ត្រូវតែមាន lines នេះដើម្បីភ្ជាប់ទៅកាន់ orders table
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->integer('product_id');
        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
