<?php

namespace App\Http\Controllers\Tabelas;

use App\Http\Controllers\Controller;
use App\Repository\VacinaRepository;
use Illuminate\Http\Request;

class VacinaController extends Controller
{
    private $vacinaRepository;
    public function __construct()
    {
        $this->vacinaRepository = new VacinaRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $vacinas = $this->vacinaRepository->findAll($request);
        return view('tabelas.vacina.index', compact('vacinas'));
    }

    public function showFormVacina(){
        return view('tabelas.vacina.vacina');
    }

    public function save(Request $request){
        $this->vacinaRepository->save($request);
        session()->flash('status', 'Vacina Salva');
        return redirect()->route('vacina.index');
    }

    public function showFormVacinaForEdit($id){
        $vacina = $this->vacinaRepository->findById($id);
        return view('tabelas.vacina.vacina', compact('vacina'));
    }

    public function delete($id){
        $this->vacinaRepository->deleteById($id);
        session()->flash('status', 'Vacina Apagada');
        return redirect()->route('vacina.index');
    }
}
