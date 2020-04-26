<?php


namespace App\Repository;




use App\TipoBaixa;
use Illuminate\Http\Request;

class TipoBaixasRepository
{
    public function save(Request $request)
    {
        $tipoBaixa = TipoBaixa::find($request->input('id'));
        if (!isset($tipoBaixa)) {
            $tipoBaixa = new TipoBaixa();
        }
        $tipoBaixa->nome = $request->input('nome');
        $tipoBaixa->save();
    }

    public function findAll(Request $request)
    {
        $search = $request->input("search");
        if (isset($search)) {
            $query = TipoBaixa::where('nome', 'like', '%' . $search . '%')
                ->paginate(15);
        } else {
            $query = TipoBaixa::all();
        }
        return $query;
    }

    public function findById($id)
    {
        return TipoBaixa::find($id);
    }

    public function deleteById($id)
    {
        TipoBaixa::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return TipoBaixa::select('id', 'nome')->get();
    }
}
