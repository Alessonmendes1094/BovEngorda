<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHistoricosLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historicos_lotes', function (Blueprint $table) {
            $table->char('lote_alterado', 1)->nullable();
            $table->char('origem', 50);
            $table->unsignedBigInteger('id_pesagem')->nullable();

            $table->foreign('id_pesagem')->references('id')->on('pesagens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
