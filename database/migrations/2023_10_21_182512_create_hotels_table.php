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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destination_id')->nullable(true);
            $table->foreign('destination_id', 'destination_hotel_fk')->references('id')->on('destinations')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->nullable(false);
            $table->string('location')->nullable(false);
            $table->text('descript')->nullable(false);
            $table->string('link')->nullable(true);
            $table->string('img')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
