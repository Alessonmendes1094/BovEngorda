<?php


namespace App\Repository;


use App\Vacina;
use Illuminate\Http\Request;

class VacinaRepository
{

    public function save(Request $request)
    {
        $vacina = Vacina::find($request->input('id'));
        if (!isset($vacina)) {
            $vacina = new Vacina();
        }
        $vacina->nome = $request->input('nome');
        $vacina->descricao = $request->input('descricao');
        $vacina->save();
    }

    public function findAll(Request $request)
    {
        $search = $request->input("search");
        if (isset($search)) {
            $query = Vacina::where('nome', 'like', '%' . $search . '%')
                ->orWhere('descricao', 'like', '%' . $search . '%')
                ->paginate(15);
        } else {
            $query = Vacina::all();
        }
        return $query;
    }
    public function All()
    {
        $query = Vacina::all();
        return $query;
    }

    public function findById($id)
    {
        return Vacina::find($id);
    }

    public function deleteById($id)
    {
        Vacina::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return Vacina::select('id', 'nome')->get();
    }


}
