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
        Schema::table('prices', function (Blueprint $table) {
            //
            $table->Integer('firstNumb')->nullable(true)->after('lasteMin');
            $table->Integer('firstOnly')->nullable(true)->after('firstNumb');
            $table->Integer('lastOnly')->nullable(true)->after('firstOnly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            //
            $table->dropColumn('firstNumb');
            $table->dropColumn('firstOnly');
            $table->dropColumn('lastOnly');
        });
    }
};
