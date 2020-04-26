<?php

namespace App\Http\Controllers\Tabelas;

use App\Repository\RacaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RacasController extends Controller
{
    private $racaRepository;
    public function __construct()
    {
        $this->racaRepository = new RacaRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $racas = $this->racaRepository->findAll($request);
        return view('tabelas.raca.index', compact('racas'));
    }

    public function showFormRaca(){
        return view('tabelas.raca.raca');
    }

    public function save(Request $request){
        $this->racaRepository->save($request);
        session()->flash('status', 'Raça Salvo');
        return redirect()->route('raca.index');
    }

    public function showFormRacaForEdit($id){
        $raca = $this->racaRepository->findById($id);
        return view('tabelas.raca.raca', compact('raca'));
    }

    public function delete($id){
        $this->racaRepository->deleteById($id);
        session()->flash('status', 'Raca Apagado');
        return redirect()->route('raca.index');
    }
}
