<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->unsignedBigInteger('coupon_code_id')->nullable()->after('discount');

        $table->foreign('coupon_code_id')
              ->references('id')
              ->on('discount_coupons')
              ->onDelete('set null');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropForeign(['coupon_code_id']);
        $table->dropColumn('coupon_code_id');
    });
}
};
