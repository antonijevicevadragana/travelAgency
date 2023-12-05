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
        //
        Schema::table('roles', function (Blueprint $table) {

           
            $table->foreign('user_id', 'user_role_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {Schema::table('roles', function (Blueprint $table) {
        // Otkaži strani ključ
        $table->dropForeign('user_role_fk');
       
    });
    }
};
