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
        Schema::table('users', function (Blueprint $table) {
            // اول باید foreign key قبلی رو حذف کنیم
            $table->dropForeign(['store_id']);

            // بعد دوباره بدون cascade تعریفش می‌کنیم
            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }
};
