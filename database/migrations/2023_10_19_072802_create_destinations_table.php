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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('state')->nullable(false);
            $table->string('city')->nullable(false);
            $table->string('coverImage')->nullable(false);
            $table->date('startDate')->nullable(false);
            $table->date('endDate')->nullable(false);
            $table->string('startCity')->nullable(false);
            $table->integer('number')->nullable(false);
            $table->text('descriptionSrb')->nullable(false);
            $table->text('descriptionEng')->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
