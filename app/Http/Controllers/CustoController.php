<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Custo;
use App\Repository\CustosDiversosRepository;
use App\Repository\CustosVacinasRepository;
use App\Repository\CustosBaixasRepository;
use App\TipoBaixa;
use App\Vacina;

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
        session()->flash('status', 'Custo Salvo');
        return redirect()->route('custos.diversos.index');
    }

    public function EditarDiversos($id){
        $custo = $this->custosDiversosRepository->findById($id);
        //dd($custo);
        $data = $custo->data->format('Y-m-d');
        return view('custos.diversos.novocusto', compact('custo','data'));
    }

    public function deleteDiversos($id){
        $this->custosDiversosRepository->delete($id);
        session()->flash('status', 'Custo Apagado');
        return redirect()->route('custos.diversos.index');
    }

    public function diversosShowAnimais($id){
        $animais = $this->custosDiversosRepository->diversosShowAnimais($id);
        $custo = Custo::find($id);
        //dd($animais);
        return view('custos.diversos.custoanimais', compact('animais','custo'));
    }

    ############################################################################
    public function indexVacina(Request $request)
    {
        $custos = $this->custosVacinasRepository->findAll($request);
        //dd('ok');
        return view('custos.vacinas.index', compact('custos'));
    }

    public function showFormVacina(){
        $vacinas = Vacina::all();
        return view('custos.vacinas.novocusto', compact('vacinas'));
    }

    public function saveVacina(Request $request){
        $this->custosVacinasRepository->save($request);
        session()->flash('status', 'Custo Salvo');
        return redirect()->route('custos.vacinas.index');
    }

    public function deleteVacina($id){
        $this->custosVacinasRepository->delete($id);
        session()->flash('status', 'Custo Apagado');
        return redirect()->route('custos.vacinas.index');
    }

    ##############################################################################
    public function indexBaixas(Request $request)
    {
        $custos = $this->custosBaixasRepository->findAll($request);
        return view('custos.baixas.index', compact('custos'));
    }

    public function showFormBaixas(){
        $tipo_baixas = TipoBaixa::all();
        return view('custos.baixas.novocusto',compact('tipo_baixas'));
    }

    public function saveBaixa(Request $request){
        $this->custosBaixasRepository->save($request);
        session()->flash('status', 'Custo Salvo');
        return redirect()->route('custos.baixas.index');
    }

    public function deleteBaixas($id){
        $this->custosBaixasRepository->delete($id);
        session()->flash('status', 'Custo Apagado');
        return redirect()->route('custos.baixas.index');
    }
}
