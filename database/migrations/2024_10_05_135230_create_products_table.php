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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreignId('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('en')->unique();
            $table->string('slug');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('canonical')->nullable();
            $table->unsignedBigInteger('viewed')->default(1);
            $table->unsignedBigInteger('comment')->default(1);
            $table->boolean('status')->default(1);
            $table->boolean('offer')->default(0);
            $table->boolean('best')->default(0);
            $table->unsignedInteger('delivery')->default(0);
            $table->unsignedInteger('delivery_per_product')->nullable();
            $table->string('sku');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
