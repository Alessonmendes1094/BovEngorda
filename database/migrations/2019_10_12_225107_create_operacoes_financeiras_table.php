<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperacoesFinanceirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operacoes_financeiras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('conta_corrente');
            $table->date('data_pagamento')->nullable();
            $table->date('data_vencimento');
            $table->string('numero_documento');
            $table->string('fornecedor');
            $table->string('categoria');
            $table->double('valor');
            $table->string('tipo_dc');
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
        Schema::dropIfExists('recursos');
        Schema::dropIfExists('operacoes_financeiras');
    }
}
