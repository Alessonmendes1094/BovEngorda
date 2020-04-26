<?php

namespace App\Http\Controllers;

use App\Repository\OperacaoRepository;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{

    private $operacaoRepository;

    public function __construct()
    {
        $this->operacaoRepository = new OperacaoRepository();
        $this->middleware('auth');
    }

    public function index(Request $request){
        $operacaoes = $this->operacaoRepository->findAll($request);
        $totalAReceber = $this->operacaoRepository->getTotalAReceber();
        $totalAPagar = $this->operacaoRepository->getTotalAPagar();
        $totalVencido = $this->operacaoRepository->getTotalVencido();
        return view('financeiro.index', compact('operacaoes', 'totalAPagar', 'totalAReceber', 'totalVencido'));
    }

    public function showFormEntrada(){
        $tipo = 'entrada';
        return view('financeiro.operacao', compact('tipo'));
    }

    public function showFormSaida(){
        $tipo = 'saida';
        return view('financeiro.operacao', compact('tipo'));
    }

    public function save(Request $request){
        $this->operacaoRepository->save($request);
        session()->flash('status', 'Operação Finanicera Salva');
        return redirect()->route('financeiro.index');
    }

    public function edit($id, Request $request){
        $operacao = $this->operacaoRepository->findById($id);
        $tipo = $operacao->tipo_dc == 'debito' ? 'saida' : 'entrada';
        return view('financeiro.operacao', compact('tipo', 'operacao'));
    }

    public function delete($id){
        $this->operacaoRepository->delete($id);
        session()->flash('status', 'Operação Apagado');
        return redirect()->route('financeiro.index');
    }
}
