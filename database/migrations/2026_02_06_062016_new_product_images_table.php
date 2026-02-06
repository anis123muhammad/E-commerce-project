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
  // product_images table
Schema::create('product_images', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->string('image');
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.z
     */
    public function down(): void
    {
        //
    }
};
