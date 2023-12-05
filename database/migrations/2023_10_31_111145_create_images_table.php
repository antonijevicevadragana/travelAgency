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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
           $table->string('path');
           $table->unsignedBigInteger('blog_id')->nullable(true);
           $table->foreign('blog_id', 'blog_img_fk')->references('id')->on('blogs')->onUpdate('cascade')->onDelete('cascade');
           $table->unsignedBigInteger('hotel_id')->nullable(true);
           $table->foreign('hotel_id', 'hotel_img_fk')->references('id')->on('hotels')->onUpdate('cascade')->onDelete('cascade');
           $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
