<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVacinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacinas', function (Blueprint $table) {
            $table->double('valor_ml');
            $table->double('valor_pago');
            $table->double('dosagem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacinas', function (Blueprint $table) {
            $table->dropColumn('valor_ml');
            $table->dropColumn('valor_pago');
            $table->dropColumn('dosagem');
        });
    }
}
