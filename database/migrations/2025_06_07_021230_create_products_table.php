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
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained();
        $table->foreignId('user_id')->constrained();
        $table->string('name', 100);
        $table->text('description')->nullable();
        $table->decimal('price', 15, 2);
        $table->unsignedInteger('stock');
        $table->softDeletes();
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
