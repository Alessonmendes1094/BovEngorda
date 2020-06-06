<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCustos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_animais')->nullable();
            $table->foreign('id_animais')->references('id')->on('animais')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custos', function (Blueprint $table) {
            $table->dropColumn('id_animais');
            
        });
    }
}
