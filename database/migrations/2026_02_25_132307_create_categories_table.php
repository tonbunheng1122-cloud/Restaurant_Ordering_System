<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable(); // For the '0001' style code in your table
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // For category thumbnails
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
