<?php


namespace App\Repository;

use App\HistoricoLotes;
use App\Lote;
use Illuminate\Http\Request;

class LoteRepository
{
    public function save(Request $request)
    {
        $lote = Lote::find($request->input('id'));
        if (!isset($lote)) {
            $lote = new Lote();
        }
        $nome = strtolower($request->input('nome'));
        $lote->nome = ucfirst($nome);
        $lote->peso_inicial = $request->input('peso_inicial');
        $lote->peso_final = $request->input('peso_final');
        $lote->racao = $request->input('racao');
        $lote->consumodia = $request->input('consumodia');
        $lote->valorkg = $request->input('valorkg');
        $lote->save();
    }

    public function validaPeso(Request $request){
        $pesoinicial = Lote::where('peso_final', '>=', $request->input('peso_inicial'))
            ->where('peso_inicial' , '<',$request->input('peso_final'))
            ->where('id' , '<>',$request->input('id'))
            ->first();
        $pesofinal = Lote::where('peso_inicial', '<=', $request->input('peso_final'))
            ->where('peso_final' , '>',$request->input('peso_inicial'))
            ->where('id' , '<>',$request->input('id'))
            ->first();
        if ($pesoinicial <> null) {
            $erro = 'Cadastro/Alteração não Efetuado! Peso Inicial Conflitante com o Peso Final do Lote "'.$pesoinicial->nome.'"';
            return $erro;
        }
        if ($pesofinal <> null) {
            $erro = 'Cadastro/Alteração não Efetuado! Peso Final Conflitante com o Peso Inicial do Lote "'.$pesofinal->nome.'"';
            return $erro;
        }



    }

    public function findAll($request)
    {
        if (isset($request)) {
            $search = $request->input("search");
            if (isset($search)) {
                return Lote::where('nome', 'like', '%' . $search . '%')->paginate(15);
            }
        }
        return Lote::all();
    }

    public function All()
    {
        return Lote::all();
    }

    public function findById($id)
    {
        return Lote::find($id);
    }

    public function deleteById($id)
    {
        Lote::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return Lote::select('id', 'nome')->get();
    }

    public function findHistoricoByAnimal($animal)
    {
        return HistoricoLotes::
        join('lotes', 'id_lote', '=', 'lotes.id')
            ->where('id_animal', '=', $animal->id)->get();
    }
}
