<?php


namespace App\Repository;

use App\Animal;
use App\Custo;
use App\Custo_Animal;
use App\Custo_Detalhamento;
use App\HistoricoLotes;
use App\Pesagem;
use App\TipoBaixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustosDiversosRepository
{

    public function findAll($request)
    {
        return Custo::
        where('tipo','=','Diversos')    
        ->orderBy('data', 'desc')
            ->paginate(25);
    }

public function qtdAnimais($id)){
    return Custo_Animal::where('id_custos','=',$id)->count();    
}

    public function save(Request $request)
    {
        $custoreq = $request->all();
        
        $custo = new Custo();
        $custo->tipo = 'Diversos';
        $custo->titulo = $custoreq['titulo'];
        $custo->descricao = $custoreq['descricao'];
        $custo->valor_total = $custoreq['valor'];
        $custo->data = $custoreq['data'];
        $custo->save();

        $this->dividecusto($custo);
        
    }

    public function dividecusto($custo){
        $countanimais = Animal::where('id_tipobaixa','=',null)->count();
        $valoranimal = $custo->valor_total / $countanimais;

        $animais =  Animal::where('id_tipobaixa','=',null)->get();
        $seq = 0;

        foreach ($animais as $animal){
            $seq = $seq +1;

            $custoanimal = new Custo_Animal();
            $custoanimal->valor = $valoranimal;
            $custoanimal->sequencia = $seq;
            $custoanimal->id_animais = $animal->id;
            $custoanimal->id_custos = $custo->id;
            $custoanimal->save();
        }
    }
    
    public function delete($id)
    {
        Custo::destroy($id);
    }

}
