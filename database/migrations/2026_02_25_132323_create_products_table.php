<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_products_table.php
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Relationship to Category
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->string('code')->unique()->nullable(); // បន្ថែម ->nullable() នៅខាងចុង
            $table->integer('qty')->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->integer('count')->default(0); // Matches the 'Count' input in your form
            $table->text('description')->nullable();
            $table->json('images')->nullable(); // To store the multiple image paths
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
