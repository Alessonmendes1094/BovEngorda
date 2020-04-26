<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesagens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data');
            $table->double('peso');
            $table->bigInteger('animal_id')->unsigned();
            $table->timestamps();

            $table->foreign('animal_id')->references('id')->on('animais')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesagens');
    }
}
