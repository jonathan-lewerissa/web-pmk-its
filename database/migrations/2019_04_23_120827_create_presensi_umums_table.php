<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresensiUmumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi_umums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('asal');
            $table->string('telp');
            $table->unsignedInteger('event_id');
            $table->timestamps();

            $table->foreign('event_id')->references('id')
                ->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi_umums');
    }
}
