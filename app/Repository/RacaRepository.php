<?php


namespace App\Repository;


use App\Raca;
use Illuminate\Http\Request;

class RacaRepository
{
    public function save(Request $request)
    {
        $raca = Raca::find($request->input('id'));
        if (!isset($raca)) {
            $raca = new Raca();
        }
        $nome = strtolower($request->input('nome'));
        $raca->nome = ucfirst($nome);
        $raca->save();
    }

    public function findAll($request)
    {
        //TODO: ver se retorna todos nos formularios de peso e animais
        if(isset($request)){
            $search = $request->input("search");
            if (isset($search)) {
                return Raca::where('nome', 'like', '%' . $search . '%')
                    ->paginate(15);
            }
        }

        return $query = Raca::all();
    }

    public function All(){
        return $query = Raca::all();
    }

    public function findById($id)
    {
        return Raca::find($id);
    }

    public function deleteById($id)
    {
        Raca::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return Raca::select('id', 'nome')->get();
    }
}
