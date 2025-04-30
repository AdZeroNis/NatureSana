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
        Schema::table('product_comments', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('product_comments'); // برای پاسخ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_comments', function (Blueprint $table) {
            //
        });
    }
};
