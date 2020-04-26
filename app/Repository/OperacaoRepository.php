<?php


namespace App\Repository;

use App\OperacaoFinanceira;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperacaoRepository
{
    public function save(Request $request)
    {
        $operacao = OperacaoFinanceira::find($request->input('id'));
        if (!isset($operacao)) {
            $operacao = new OperacaoFinanceira();
        }
        $operacao->conta_corrente = $request->input('conta_corrente');
        $operacao->data_pagamento = $request->input('data_pagamento');
        $operacao->data_vencimento = $request->input('data_vencimento');
        $operacao->numero_documento = $request->input('numero_documento');
        $operacao->fornecedor = $request->input('fornecedor');
        $operacao->categoria = $request->input('categoria');
        $operacao->valor = $request->input('valor');
        $operacao->tipo_dc = $request->input('dc');;
        $operacao->save();
    }

    public function findAll(Request $request)
    {
        return OperacaoFinanceira::where($this->builderCondition($request))->paginate(15);
    }

    private function builderCondition(Request $request)
    {
        $filtro = array();

        $dataInit = $request->input("dataInit");
        if (isset($dataInit)) {
            array_push($filtro, ['data_vencimento', '>=', $dataInit]);
        }

        $tipoDc = $request->input("tipo_dc");
        if (isset($tipoDc)) {
            array_push($filtro, ['tipo_dc', '=', $tipoDc]);
        }
        $dataFim = $request->input("dataFim");
        if (isset($dataFim)) {
            array_push($filtro, ['data_vencimento', '<=', $dataFim]);
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
        return OperacaoFinanceira::find($id);
    }

    public function delete($id){
        OperacaoFinanceira::destroy($id);
    }

    public function getTotalAReceber(){
        return DB::table('operacoes_financeiras')
            ->select(DB::raw('sum(valor) as valor'))
            ->where('tipo_dc', '=', 'credito')
            ->whereNull('data_pagamento')->first();
    }

    public function getTotalAPagar(){
        return DB::table('operacoes_financeiras')
            ->select(DB::raw('sum(valor) as valor'))
            ->where('tipo_dc', '=', 'debito')
            ->whereNull('data_pagamento')->first();
    }

    public function getTotalVencido(){
        return DB::table('operacoes_financeiras')
            ->select(DB::raw('sum(valor) as valor'))
            ->where('tipo_dc', '=', 'debito')
            ->where('data_vencimento', '<', DB::raw('now()'))
            ->whereNull('data_pagamento')->first();
    }
}
