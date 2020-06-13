<?php

namespace App\Http\Controllers;

use App\Pesagem;
use App\Repository\AnimalRepository;
use App\Repository\LoteRepository;
use App\Repository\PesagemRepository;
use App\Repository\RacaRepository;
use App\Repository\TipoBaixasRepository;
use App\Utils\ExcelUtils;
use Illuminate\Http\Request;

class PesagemController extends Controller
{
    private $animalRepository;
    private $loteRepository;
    private $racaRepository;
    private $pesagemRepository;

    public function __construct()
    {
        $this->animalRepository = new AnimalRepository();
        $this->loteRepository = new LoteRepository();
        $this->racaRepository = new RacaRepository();
        $this->pesagemRepository = new PesagemRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $pesagens = $this->pesagemRepository->findAll($request);
        $racas = $this->racaRepository->findAll(null);
        $lotes = $this->loteRepository->findAll(null);
        return view('pesagens.index', compact('pesagens', 'racas', 'lotes'));
    }

    public function cadastroPeso(){
        $data = Pesagem::orderBy('id','desc')->select('data')->first();
        return view('pesagens.cadastroPeso', compact('data'));
    }

    public function salvar(Request $request){
        $validacao = $this->pesagemRepository->salvar($request);
        session()->flash($validacao[0], $validacao[1]);
        return view('pesagens.cadastroPeso');
    }

    public function delete($id){
        $this->pesagemRepository->deleteById($id);
        session()->flash('status', 'Peso  Apagado');
        return redirect()->route('pesagem.index');
    }

    public function showFormcarregarDados(){
        return view('pesagens.formplanilha');
    }

    public function carregarDados(Request $request){
        $dados = ExcelUtils::loadPlanilha($request->file('file'));
        return view('pesagens.showdadosplanilha', compact('dados'));
    }

    public function importarDados(Request $request){
        $dados = json_decode($request->input('dados'));
        $respostaImportacao = $this->pesagemRepository->importByPlanilha($dados, $request);
        session()->flash('status', $respostaImportacao[1]);

        return redirect()->route('pesagem.index');
    }

}
