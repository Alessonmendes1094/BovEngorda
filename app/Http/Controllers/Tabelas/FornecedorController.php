<?php

namespace App\Http\Controllers\Tabelas;

use App\Http\Controllers\Controller;
use App\Repository\FornecedorRepository;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    private $fornecedorRepository;
    public function __construct()
    {
        $this->fornecedorRepository = new FornecedorRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $fornecedores = $this->fornecedorRepository->findAll($request);
        return view('tabelas.fornecedor.index', compact('fornecedores'));
    }

    public function showFormFornecedor(){
        return view('tabelas.fornecedor.fornecedor');
    }

    public function save(Request $request){
        $this->fornecedorRepository->save($request);
        session()->flash('status', 'Fornecedor Salvo');
        return redirect()->route('fornecedor.index');
    }

    public function showFormFornecedorForEdit($id){
        $fornecedor = $this->fornecedorRepository->findById($id);
        return view('tabelas.fornecedor.fornecedor', compact('fornecedor'));
    }

    public function delete($id){
        $message = $this->fornecedorRepository->deleteById($id);
        session()->flash($message[0], $message[1]);
        return redirect()->route('fornecedor.index');
    }
}
