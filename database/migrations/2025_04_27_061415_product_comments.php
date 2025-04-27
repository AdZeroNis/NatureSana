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
        Schema::create('product_comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->text('content');
            $table->foreignId('user_id')->constrained('users'); // کاربری که نظر داده
            $table->foreignId('product_id')->constrained('products'); // نظر درباره محصول
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_comments');
    }
};
