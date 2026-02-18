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
    Schema::create('order_items', function (Blueprint $table) {

        $table->id();

        // Relations
        $table->foreignId('order_id')
              ->constrained()
              ->onDelete('cascade');

        $table->foreignId('product_id')
              ->constrained()
              ->onDelete('cascade');

        // Snapshot data
        $table->string('name');

        // Quantity
        $table->unsignedInteger('qty');

        // Price & Total (use decimal)
        $table->decimal('price',10,2);
        $table->decimal('total',10,2);

        $table->timestamps();

        // Prevent duplicates (optional)
        // $table->unique(['order_id','product_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
