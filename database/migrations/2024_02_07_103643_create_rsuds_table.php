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
        Schema::create('rsuds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('opd_id');
            $table->uuid('user_id');
            $table->date('tanggal');
            $table->string('jam_masuk');
            $table->string('jam_pulang')->nullable();
            $table->string('lat_long_masuk');
            $table->string('lat_long_pulang')->nullable();
            $table->string('photo_masuk');
            $table->string('photo_pulang')->nullable();
            $table->string('status')->nullable();
            $table->string('warning')->nullable();
            $table->string('spt')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rsuds');
    }
};
