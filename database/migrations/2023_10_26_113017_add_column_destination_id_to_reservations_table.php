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
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('destination_id')->nullable(true)->after('user_id');

            // Dodavanje stranog ključ na kolonu 'destination_id' koji referencira 'id' kolonu u tabeli 'destinations'
            $table->foreign('destination_id')->references('id')->on('destinations');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['destination_id']); // Ovako se brise strani ključ
            $table->dropColumn('destination_id'); //nakon brisanja stranog kljuca se birse kolona
        });
    }
};
