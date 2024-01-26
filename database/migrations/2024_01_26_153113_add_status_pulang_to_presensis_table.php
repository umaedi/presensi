<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persensis', function (Blueprint $table) {
            $table->string('status_pulang')->default('Tdk/Blm presensi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persensis', function (Blueprint $table) {
            Schema::table('persensis', function ($table) {
                $table->dropColumn('status_pulang');
            });
        });
    }
};
