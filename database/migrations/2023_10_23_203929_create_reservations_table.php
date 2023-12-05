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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id')->nullable(true);
            $table->foreign('hotel_id', 'reservation_hotel_fk')->references('id')->on('hotels')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->foreign('user_id', 'reservation_user_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('confirmationCode')->nullable(false);
            $table->date('dateReservation')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('surname')->nullable(false);
            $table->string('phoneNumber')->nullable(false);
            $table->integer('passingerNumbers')->nullable(false);
            $table->integer('reservationPrice')->nullable(false);

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
