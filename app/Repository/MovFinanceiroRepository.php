<?php


namespace App\Repository;


use App\MovFinanceiro;
use Illuminate\Http\Request;

class MovFinanceiroRepository
{

    public function save(Request $request, string $tipoDc)
    {
        $movfinanceiro = MovFinanceiro::find($request->input('id'));
        if (!isset($movfinanceiro)) {
            $movfinanceiro = new MovFinanceiro();
        }
        $movfinanceiro->conta_corrente = $request->input('conta_corrente');
        $movfinanceiro->data = $request->input('data');
        $movfinanceiro->numero_documento = $request->input('numero_documento');
        $movfinanceiro->fornecedor = $request->input('fornecedor');
        $movfinanceiro->categoria = $request->input('categoria');
        $movfinanceiro->valor = $request->input('valor');
        $movfinanceiro->tipo_dc = $tipoDc;
        $movfinanceiro->save();
    }

    public function findAll(Request $request)
    {
        return MovFinanceiro::where($this->builderCondition($request))->paginate(15);
    }

    private function builderCondition(Request $request)
    {
        $filtro = array();

        $dataInit = $request->input("dataInit");
        if (isset($dataInit)) {
            array_push($filtro, ['data', '>=', $dataInit]);
        }
        $dataFim = $request->input("dataFim");
        if (isset($dataFim)) {
            array_push($filtro, ['data', '<=', $dataFim]);
        }
        $categoria = $request->input("categoria");
        if (isset($categoria)) {
            array_push($filtro, ['categoria', 'like', $categoria]);
        }
        $fornecedor = $request->input("fornecedor");
        if (isset($fornecedor)) {
            array_push($filtro, ['fornecedor', 'like', $fornecedor]);
        }

        return $filtro ;
    }

    public function findById($id){
        return MovFinanceiro::find($id);
    }

    public function delete($id){
        MovFinanceiro::destroy($id);
    }
}