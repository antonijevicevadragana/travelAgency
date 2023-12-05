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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->foreign('user_id', 'blog_user_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->nullable(false);
            $table->text('descriptionSrb')->nullable(false);
            $table->text('descriptionEng')->nullable(true); //eng zbog lokalizacije
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
