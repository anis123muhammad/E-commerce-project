<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_charges', function (Blueprint $table) {

            // First drop old column
            $table->dropColumn('country_id');
        });

        Schema::table('shipping_charges', function (Blueprint $table) {

            // Add correct foreign key column
            $table->foreignId('country_id')
                  ->constrained('countries')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('shipping_charges', function (Blueprint $table) {

            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');

            // Revert back to string if needed
            $table->string('country_id');
        });
    }
};
