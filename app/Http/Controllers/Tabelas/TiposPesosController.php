<?php

namespace App\Http\Controllers\Tabelas;

use App\Repository\TipoPesosRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiposPesosController extends Controller
{
    private $tipoPesosRepository;
    public function __construct()
    {
        $this->tipoPesosRepository = new TipoPesosRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tipoPesos = $this->tipoPesosRepository->findAll($request);
        return view('tabelas.tipopeso.index', compact('tipoPesos'));
    }

    public function showFormTipoPeso(){
        return view('tabelas.tipopeso.tipopeso');
    }

    public function save(Request $request){
        $this->tipoPesosRepository->save($request);
        session()->flash('status', 'Tipo Peso Salvo');
        return redirect()->route('tipopeso.index');
    }

    public function showFormTipoPesosForEdit($id){
        $tipopeso = $this->tipoPesosRepository->findById($id);
        return view('tabelas.tipopeso.tipopeso', compact('tipopeso'));
    }

    public function delete($id){
        $this->tipoPesosRepository->deleteById($id);
        session()->flash('status', 'Tipo Peso Apagado');
        return redirect()->route('tipopeso.index');
    }
}
