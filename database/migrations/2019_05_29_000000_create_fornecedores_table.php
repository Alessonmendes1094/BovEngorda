<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedoresTable extends Migration
{

    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('endereco')->nullable();
            $table->string('cnpj')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
