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
        Schema::table('destinations', function (Blueprint $table) {
            //
            $table->string('cityEng')->nullable(false)->after('city');
            $table->string('stateEng')->nullable(false)->after('state');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            //
            $table->dropColumn('cityEng');
            $table->dropColumn('stateEng');
        });
    }
};
