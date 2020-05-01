<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteCustosAnimaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custos_animais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('valor', 8,2)->nullable();
            $table->integer('sequencia')->nullable();
            
            $table->unsignedBigInteger('id_animais')->nullable();
            $table->unsignedBigInteger('id_custos');
            $table->unsignedBigInteger('id_vacinas')->nullable();
            $table->decimal('dosagem',3,3)->nullable();
            
            $table->timestamps();

            $table->foreign('id_animais')->references('id')->on('animais')->onDelete('set null');
            $table->foreign('id_custos')->references('id')->on('custos')->onDelete('cascade');
            $table->foreign('id_vacinas')->references('id')->on('vacinas')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custos_animais');
    }
}
