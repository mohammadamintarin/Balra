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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('en')->unique();
            $table->string('slug');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('canonical')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('viewed')->default(1);
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
