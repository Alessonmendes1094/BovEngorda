<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\FornecedorRepository;

class CustoController extends Controller
{
    private $custosDiversosRepository;
    public function __construct()
    {
        $this->custosDiversosRepository = new FornecedorRepository();
        $this->middleware('auth');
    }

    public function indexDiversos(Request $request)
    {
        $fornecedores = $this->custosDiversosRepository->findAll($request);
        return view('tabelas.fornecedor.index', compact('fornecedores'));
    }

    public function showFormDiversos(){
        return view('tabelas.fornecedor.fornecedor');
    }

    public function saveDiversos(Request $request){
        $this->custosDiversosRepository->save($request);
        session()->flash('status', 'Fornecedor Salvo');
        return redirect()->route('fornecedor.index');
    }

    public function showFormDiversosForEdit($id){
        $fornecedor = $this->custosDiversosRepository->findById($id);
        return view('tabelas.fornecedor.fornecedor', compact('fornecedor'));
    }

    public function deleteDiversos($id){
        $this->custosDiversosRepository->deleteById($id);
        session()->flash('status', 'Fornecedor Apagado');
        return redirect()->route('fornecedor.index');
    }

    public function diversosShowAnimais($id){

    }

    public function animaisShowForm(Request $request , $id){
        
    }
}
