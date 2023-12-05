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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->foreign('user_id', 'profile_user_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nickname')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('surname')->nullable(false);
            $table->string('hightlight')->nullable(true);
            $table->date('dateofBirth')->nullable(false);
            $table->string('gender')->nullable(false)->default('other');
            $table->string('avatar')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
