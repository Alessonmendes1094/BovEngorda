<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoBaixasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipobaixas')->insert(['nome' => "Venda"]);
        DB::table('tipobaixas')->insert(['nome' => "Doença"]);
    }
}
