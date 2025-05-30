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
        Schema::create('store_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade'); // فروشگاه درخواست‌دهنده
            $table->foreignId('partner_store_id')->constrained('stores')->onDelete('cascade'); // فروشگاه همکار
            $table->boolean('status')->default(true); // فعال یا غیرفعال بودن همکاری
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_partners');
    }
};
