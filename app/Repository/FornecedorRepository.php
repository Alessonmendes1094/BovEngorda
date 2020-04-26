<?php


namespace App\Repository;


use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorRepository
{

    public function save(Request $request)
    {
        $fornecedor = Fornecedor::find($request->input('id'));
        if (!isset($fornecedor)) {
            $fornecedor = new Fornecedor();
        }
        $fornecedor->nome = $request->input('nome');
        $fornecedor->endereco = $request->input('endereco');
        $fornecedor->cnpj = $request->input('cnpj');
        $fornecedor->save();
    }

    public function findAll(Request $request)
    {
        $search = $request->input("search");
        if (isset($search)) {
            $query = Fornecedor::where('nome', 'like', '%' . $search . '%')
                ->orWhere('endereco', 'like', '%' . $search . '%')
                ->orWhere('cnpj', 'like', '%' . $search . '%')
                ->paginate(15);
        } else {
            $query = Fornecedor::all();
        }
        return $query;
    }
    public function All()
    {
        $query = Fornecedor::all();
        return $query;
    }

    public function findById($id)
    {
        return Fornecedor::find($id);
    }

    public function deleteById($id)
    {
        Fornecedor::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return Fornecedor::select('id', 'nome')->get();
    }


}
