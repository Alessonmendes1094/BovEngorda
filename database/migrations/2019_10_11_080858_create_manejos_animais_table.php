<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManejosAnimaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manejos_animais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('animal_id')->unsigned();
            $table->bigInteger('pesagem_id')->unsigned()->nullable();
            $table->bigInteger('manejo_id')->unsigned();
            $table->double('valor');

            $table->foreign('animal_id')->references('id')->on('animais')->onDelete('cascade');
            $table->foreign('pesagem_id')->references('id')->on('pesagens')->onDelete('set null');
            $table->foreign('manejo_id')->references('id')->on('manejos')->onDelete('cascade');
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
        Schema::dropIfExists('manejos_animais');
    }
}
