<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateloteVacinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loteVacina', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vacina_id')->unsigned();
            $table->unsignedBigInteger('lote_id')->unsigned();
            $table->double('dosagem');
            $table->timestamps();
            $table->foreign('vacina_id')->references('id')->on('vacinas')->onDelete('cascade');
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loteVacina');
    }
}
