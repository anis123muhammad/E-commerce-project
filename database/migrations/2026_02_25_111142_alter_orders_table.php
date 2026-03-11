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
        Schema::table('orders', function (Blueprint $table) {
            // Only add payment_status if it does not exist
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['paid', 'not_paid'])
                      ->after('grand_total')
                      ->default('not_paid');
            }

            // Only add status if it does not exist
            if (!Schema::hasColumn('orders', 'status')) {
                $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled'])
                      ->after('payment_status')
                      ->default('pending');
            }

            // Only add shipped_date if it does not exist
            if (!Schema::hasColumn('orders', 'shipped_date')) {
                $table->timestamp('shipped_date')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('orders', 'shipped_date')) {
                $table->dropColumn('shipped_date');
            }
        });
    }
};
