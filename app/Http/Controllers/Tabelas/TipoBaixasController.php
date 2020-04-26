<?php

namespace App\Http\Controllers\Tabelas;

use App\Http\Controllers\Controller;
use App\Repository\TipoBaixasRepository;
use Illuminate\Http\Request;

class TipoBaixasController extends Controller
{
    private $tipoBaixaRepository;

    public function __construct()
    {
        $this->tipoBaixaRepository = new TipoBaixasRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tipoBaixas = $this->tipoBaixaRepository->findAll($request);
        return view('tabelas.tipobaixa.index', compact('tipoBaixas'));
    }

    public function showformTipoBaixa(){
        return view('tabelas.tipobaixa.tipobaixa');
    }

    public function save(Request $request){
        $this->tipoBaixaRepository->save($request);
        session()->flash('status', 'Tipo Baixa Salvo');
        return redirect()->route('tipobaixa.index');
    }

    public function showFormTipoBaixaForEdit($id){
        $tipoBaixa = $this->tipoBaixaRepository->findById($id);
        return view('tabelas.tipobaixa.tipobaixa', compact('tipoBaixa'));
    }

    public function delete($id){
        $this->tipoBaixaRepository->deleteById($id);
        session()->flash('status', 'Tipo Baixa Apagado');
        return redirect()->route('tipobaixa.index');
    }
}
