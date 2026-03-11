<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name'); // new
            $table->text('description')->nullable(); // new
            $table->integer('max_uses')->default(0); // new
            $table->integer('max_uses_per_user')->default(0); // new
            $table->enum('type', ['fixed', 'percent'])->default('fixed');
            $table->decimal('discount_amount', 8, 2)->default(0); // new
            $table->decimal('min_amount', 8, 2)->default(0); // new
            $table->boolean('status')->default(1); // new
            $table->dateTime('starts_at'); // new
            $table->dateTime('expires_at'); // new
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
