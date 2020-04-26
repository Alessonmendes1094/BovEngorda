<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brinco')->unique();
            $table->string('nome')->nullable();
            $table->char('sexo', 1)->nullable();

            $table->unsignedBigInteger('id_lote')->nullable();
            $table->unsignedBigInteger('id_raca')->nullable();
            $table->unsignedBigInteger('id_tipobaixa')->nullable();
            $table->unsignedBigInteger('id_fornecedor')->nullable();
            $table->unsignedBigInteger('id_manejo_compra')->nullable();

            $table->timestamps();

            $table->foreign('id_lote')->references('id')->on('lotes')->onDelete('set null');
            $table->foreign('id_raca')->references('id')->on('racas')->onDelete('set null');
            $table->foreign('id_tipobaixa')->references('id')->on('tipobaixas')->onDelete('set null');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedores')->onDelete('set null');
            $table->foreign('id_manejo_compra')->references('id')->on('manejos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animais');
    }
}
