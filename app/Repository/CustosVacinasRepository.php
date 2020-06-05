<?php

namespace App\Repository;

use App\Animal;
use App\Custo;
use App\Custo_Animal;
use App\loteVacina;
use App\Vacina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustosVacinasRepository
{

    public function findAll($request)
    {
        return Custo::
            where('tipo', '=', 'Vacinas')
            ->orderBy('data', 'desc')
            ->paginate(25);
    }

    public function findById($request)
    {
        return Custo::find($request);
    }

    public function qtdAnimais($id)
    {
        return Custo_Animal::where('id_custos', '=', $id)->count();
    }

    public function save(Request $request)
    {
        $custoreq = $request->all();

        $valor = $this->calculacusto($request);

        $vacina = Vacina::find($custoreq['vacina']);
        
        $animal_concatenar = $this->animal($request->animal); #identifica o animal
        
        $lotevacina        = loteVacina::where('lote_id', '=', $animal_concatenar->id_lote)->where('vacina_id', '=', $vacina->id)->first();

        if (isset($valor)) {
            $custo = Custo::find($custoreq['id']);
            if (!isset($custo)) {
                $custo = new Custo();
            }
            $custo->tipo        = 'Vacinas';
            $custo->titulo      = $vacina->nome . '-' .$custoreq['animal'];
            $custo->valor_total = $valor;
            $custo->data        = $custoreq['data'];
            $custo->save();
            
            $custoanimal = new Custo_Animal;
            $custoanimal->valor = $valor;
            $custoanimal->sequencia = 1;
            $custoanimal->id_animais = $animal_concatenar->id;
            $custoanimal->id_custos = $custo->id;
            $custoanimal->id_vacinas = $vacina->id;
            $custoanimal->dosagem = $lotevacina->dosagem;
            $custoanimal->save();
            
        }


    }

    public function calculacusto($request)
    {
        $vacina            = Vacina::find($request->vacina); #identifica a vacina
        $animal_concatenar = $this->animal($request->animal); #identifica o animal
        $lotevacina        = loteVacina::where('lote_id', '=', $animal_concatenar->id_lote)->where('vacina_id', '=', $vacina->id)->first();
        
       $valor = ($lotevacina->dosagem * 1000) * $vacina->valor_ml;

       return $valor;
    }

    public function delete($id)
    {
        Custo::destroy($id);
    }

    public function animal($req)
    {
        $animais = DB::select("select * , concat('Brinco: ',brinco,' - ',nome) as concatenar from animais ");

        foreach ($animais as $ani) {
            if ($ani->concatenar == $req) {
                $animal_concatenar = $ani;
                break;
            }
        }

        return $animal_concatenar;
    }
}
