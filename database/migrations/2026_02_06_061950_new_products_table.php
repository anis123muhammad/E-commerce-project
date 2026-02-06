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
    // products table
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->decimal('compare_price', 10, 2)->nullable();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->foreignId('sub_category_id')->nullable()->constrained()->onDelete('set null');
    $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
    $table->string('sku')->unique();
    $table->string('barcode')->nullable();
    $table->enum('track_qty', ['Yes', 'No'])->default('Yes');
    $table->integer('qty')->default(0);
    $table->enum('is_featured', ['Yes', 'No'])->default('No');
    $table->boolean('status')->default(1);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
