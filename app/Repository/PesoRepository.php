<?php


namespace App\Repository;


use App\Bovino;
use App\Pesagem;
use Illuminate\Http\Request;

class PesoRepository
{

    public function findLastCreated()
    {
        return Pesagem::join('bovinos', 'bovinos.id', '=', 'pesagens.bovino_id')
            ->orderBy('pesagens.created_at', 'desc')
            ->paginate(15);
    }

    public function save(Request $request)
    {
        $pessagem = Pesagem::find($request->input('id'));
        if (!isset($pessagem)) {
            $pessagem = new Pesagem();
        }
        $pessagem->data = $request->input('data');
        $pessagem->bovino_id = $request->input('bovino');
        $pessagem->peso = $request->input('peso');
        $pessagem->save();
    }

    public function findAll(Request $request, $tipoOrdenacao)
    {
        return Pesagem::
        join('bovinos', 'bovinos.id', '=', 'bovino_id')
            ->where('bovinos.status', '=', 'ativo')
            ->where($this->builderCondition($request))
            ->orderBy('data', $tipoOrdenacao)
            ->paginate(15);
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
        $bovino = $request->input("bovino");
        if (isset($bovino)) {
            array_push($filtro, ['bovino_id', '=', $bovino]);
        }

        return $filtro;
    }

    public function delete($id)
    {
        Pesagem::destroy($id);
    }

    public function findById($id)
    {
        return Pesagem::find($id);
    }

    public function findAllWithOutPaginate(Request $request)
    {
        return Pesagem::
        join('bovinos', 'bovinos.id', '=', 'bovino_id')
            ->where('bovinos.status', '=', 'ativo')
            ->where($this->builderCondition($request))
            ->orderBy('brinco', 'asc')
            ->orderBy('data', 'asc')->get();
    }
}