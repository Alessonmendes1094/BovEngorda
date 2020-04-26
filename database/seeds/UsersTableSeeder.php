<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Administrador",
            'email' => "administrador@boiengorda.com.br",
            'password' => bcrypt('admin1234'),
        ]);

        DB::table('lotes')->insert([
            'nome' => "Bezero",
            'racao' => "Bezero",
            'consumodia' => 1,
            'valorkg' => 5]);

        DB::table('lotes')->insert([
            'nome' => "Ano",
            'racao' => "Bezero",
            'consumodia' => 2,
            'valorkg' => 8]);

        DB::table('tipobaixas')->insert([
            'nome' => "Venda"]);

        DB::table('tipobaixas')->insert([
            'nome' => "Morte"]);

        DB::table('fornecedores')->insert([
            'nome' => "Maurici"]);

        DB::table('clientes')->insert([
            'nome' => "Cliente"]);
    }
}
