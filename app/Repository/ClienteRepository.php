<?php


namespace App\Repository;


use App\Cliente;
use Illuminate\Http\Request;

class ClienteRepository
{
    public function save(Request $request)
    {
        $cliente = Cliente::find($request->input('id'));
        if (!isset($cliente)) {
            $cliente = new Cliente();
        }
        $cliente->nome = $request->input('nome');
        $cliente->save();
    }

    public function All(){
        $query = Cliente::all();
        return $query;
    }

    public function findAll(Request $request)
    {
        $search = $request->input("search");
        if (isset($search)) {
            $query = Cliente::where('nome', 'like', '%' . $search . '%')
                ->paginate(15);
        } else {
            $query = Cliente::all();
        }
        return $query;
    }

    public function findById($id)
    {
        return Cliente::find($id);
    }

    public function deleteById($id)
    {
        Cliente::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return Cliente::select('id', 'nome')->get();
    }
}
