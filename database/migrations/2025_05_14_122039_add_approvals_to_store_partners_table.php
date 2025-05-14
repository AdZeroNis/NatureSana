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
        Schema::table('store_partners', function (Blueprint $table) {
            $table->unsignedTinyInteger('store_approval')->nullable();  // 1=تایید، 2=رد، null=منتظر
            $table->unsignedTinyInteger('partner_approval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_partners', function (Blueprint $table) {
            //
        });
    }
};
