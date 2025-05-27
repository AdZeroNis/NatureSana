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
        Schema::table('order_items', function (Blueprint $table) {
               $table->engine = 'InnoDB';

            $table->foreignId('seller_store_id')->nullable()->constrained('stores');


            $table->foreignId('owner_store_id')->nullable()->constrained('stores');


            $table->decimal('seller_share', 10, 2)->nullable();

            $table->decimal('owner_share', 10, 2)->nullable();




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
};
