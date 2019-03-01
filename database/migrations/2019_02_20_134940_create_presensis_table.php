<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('nrp');
            $table->string('photo_url')->nullable();
            $table->unsignedInteger('event_id');
            $table->timestamps();

            $table->primary(['event_id','nrp']);

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
        Schema::dropIfExists('presensis');
    }
}
