<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\CustosDiversosRepository;
use App\Repository\CustosVacinasRepository;
use App\Repository\CustosBaixasRepository;

class CustoController extends Controller
{
    private $custosDiversosRepository;
    private $custosVacinasRepository;
    private $custosBaixasRepository;
    public function __construct()
    {
        $this->custosDiversosRepository = new CustosDiversosRepository();
        $this->custosVacinasRepository = new CustosVacinasRepository();
        $this->custosBaixasRepository = new CustosBaixasRepository();
        $this->middleware('auth');
    }

    public function indexDiversos(Request $request)
    {
        $custos = $this->custosDiversosRepository->findAll($request);
        return view('custos.diversos.index', compact('custos'));
    }

    public function showFormDiversos(){
        return view('custos.diversos.novocusto');
    }

    public function saveDiversos(Request $request){
        $this->custosDiversosRepository->save($request);
        session()->flash('status', 'Fornecedor Salvo');
        return redirect()->route('custos.diversos.index');
    }

    public function showFormDiversosForEdit($id){
        $fornecedor = $this->custosDiversosRepository->findById($id);
        return view('tabelas.fornecedor.fornecedor', compact('fornecedor'));
    }

    public function deleteDiversos($id){
        $this->custosDiversosRepository->delete($id);
        session()->flash('status', 'Custo Apagado');
        return redirect()->route('custos.diversos.index');
    }

    public function diversosShowAnimais($id){

    }

    public function animaisShowForm(Request $request , $id){

    }
    ############################################################################
    public function indexVacinas(Request $request)
    {
        $custos = $this->custosVacinasRepository->findAll($request);
        return view('custos.vacinas.index', compact('custos'));
    }

    public function showFormVacinas(){
        return view('custos.vacinas.novocusto');
    }
    ##############################################################################
    public function indexBaixas(Request $request)
    {
        $custos = $this->custosBaixasRepository->findAll($request);
        return view('custos.baixas.index', compact('custos'));
    }

    public function showFormBaixas(){
        return view('custos.baixas.novocusto');
    }
}
