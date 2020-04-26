<?php


namespace App\Repository;


use App\TipoPeso;
use Illuminate\Http\Request;

class TipoPesosRepository
{
    public function save(Request $request)
    {
        $tipoPesos = TipoPeso::find($request->input('id'));
        if (!isset($tipoPesos)) {
            $tipoPesos = new TipoPeso();
        }
        $tipoPesos->nome = $request->input('nome');
        $tipoPesos->save();
    }

    public function findAll(Request $request)
    {
        $search = $request->input("search");
        if (isset($search)) {
            $query = TipoPeso::where('nome', 'like', '%' . $search . '%')
                ->paginate(15);
        } else {
            $query = TipoPeso::all();
        }
        return $query;
    }

    public function findById($id)
    {
        return TipoPeso::find($id);
    }

    public function deleteById($id)
    {
        TipoPeso::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return TipoPeso::select('id', 'nome')->get();
    }
}
