<?php


namespace App\Repository;

use App\Animal;
use App\Custo;
use App\HistoricoLotes;
use App\ManejoAnimais;
use App\Pesagem;
use App\TipoBaixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustosBaixasRepository
{

    public function findAll($request)
    {
        return Custo::
        where('tipo','=','diversos')    
        ->orderBy('data', 'desc')
            ->paginate(25);
    }

    public function save(Request $request)
    {
        dd('salvar');
    }
    
    public function delete($id)
    {
        Manejo::destroy($id);
    }


    public function findManejoByAnimal($animal, $tipo)
    {
        return Manejo::join('manejos_animais', 'manejos.id', '=', 'manejos_animais.manejo_id')
            ->where('animal_id', '=', $animal->id)
            ->where('tipo', '=', $tipo)->first();
    }

    public function findVendaByAnimal($animal)
    {
    }
}
