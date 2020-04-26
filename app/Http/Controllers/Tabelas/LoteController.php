<?php

namespace App\Http\Controllers\Tabelas;

use App\Repository\LoteRepository;
use App\Repository\LoteVacinaRepository;
use App\Vacina;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoteController extends Controller
{
    private $loteRepository;
    private $VacinasLotesRepository;

    public function __construct()
    {
        $this->loteRepository = new LoteRepository();
        $this->VacinasLotesRepository = new LoteVacinaRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $lotes = $this->loteRepository->findAll($request);
        return view('tabelas.lote.index', compact('lotes'));
    }

    public function showFormLote(){
        return view('tabelas.lote.lote');
    }

    public function save(Request $request){
        $erro=$this->loteRepository->validaPeso($request);
        if($erro <> ''){
            session()->flash('erro', $erro);
            return redirect()->route('lote.index');
        }
        $this->loteRepository->save($request);
        session()->flash('status', 'Lote Salvo');
        return redirect()->route('lote.index');
    }

    public function showFormLoteForEdit($id){
        $lote = $this->loteRepository->findById($id);
        return view('tabelas.lote.lote', compact('lote'));
    }

    public function delete($id){
        $this->loteRepository->deleteById($id);
        session()->flash('status', 'Lote Apagado');
        return redirect()->route('lote.index');
    }

    #############################################################################################

    public function indexVacina($id){
        $vacinas = $this->VacinasLotesRepository->findAll($id);
        //dd($vacinas);
        return view('tabelas.lote.vacina.index', compact('vacinas','id'));
    }

    public function showFormVacina($id){
        $vacinas = Vacina::all();
        return view('tabelas.lote.vacina.vacina', compact('vacinas','id'));
    }

    public function saveVacina(Request $request , $id){

        $this->VacinasLotesRepository->validaVacina($request);

        $this->VacinasLotesRepository->save($request , $id);
        session()->flash('status', 'Dosagem de Vacinação Salva');
        return redirect()->route('lote.indexVacina',$id);
    }

    public function showFormVacinaForEdit($id){
        $vacina = $this->VacinasLotesRepository->findById($id);
        $vacinas = Vacina::all();
        $id = $vacina->lote_id;
        //dd($id);
        return view('tabelas.lote.vacina.vacina', compact('vacina','vacinas','id'));
    }

    public function deleteVacina($id){
        $this->VacinasLotesRepository->deleteById($id);
        session()->flash('status', 'Lote Apagado');
        return redirect()->route('lote.index');
    }
}
