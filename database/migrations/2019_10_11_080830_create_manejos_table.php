<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManejosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manejos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fornecedor_id')->unsigned()->nullable();
            $table->bigInteger('cliente_id')->unsigned()->nullable();
            $table->date('data');
            $table->string('tipo'); //compra ou venda
            $table->double('valorkg');

            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->foreign('cliente_id')->references('id')->on('clientes');
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
        Schema::dropIfExists('manejos');
    }
}
