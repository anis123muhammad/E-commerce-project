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

        // user relation
        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        // totals
        $table->decimal('subtotal',10,2);
        $table->decimal('shipping',10,2);

        $table->string('coupon_code')->nullable();
        $table->decimal('discount',10,2)->nullable();

        $table->decimal('grand_total',10,2);

        // address snapshot
        $table->string('first_name');
        $table->string('last_name');

        $table->foreignId('country_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('address'); // fixed typo
        $table->string('apartment')->nullable();

        $table->string('city');
        $table->string('state');
        $table->string('zip');

        $table->text('notes')->nullable(); // fixed

$table->string('payment_method')->default('cod'); // cod, stripe
$table->string('status')->default('pending');      // pending, processing, completed, cancelled

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
