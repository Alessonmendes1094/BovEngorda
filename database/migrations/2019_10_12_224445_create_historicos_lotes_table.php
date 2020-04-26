<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicos_lotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data');
            $table->unsignedBigInteger('id_lote')->nullable();
            $table->unsignedBigInteger('id_animal')->nullable();

            $table->foreign('id_lote')->references('id')->on('lotes')->onDelete('cascade');
            $table->foreign('id_animal')->references('id')->on('animais')->onDelete('cascade');

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
        Schema::dropIfExists('historicos_lotes');
    }
}
