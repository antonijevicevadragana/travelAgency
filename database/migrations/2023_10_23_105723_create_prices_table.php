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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id')->nullable(true);
            $table->foreign('hotel_id', 'hotel_price_fk')->references('id')->on('hotels')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('price')->nullable(false);
            $table->integer('firstMin')->nullable(true);
            $table->integer('lasteMin')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
