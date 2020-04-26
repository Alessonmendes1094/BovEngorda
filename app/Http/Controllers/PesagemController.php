<?php

namespace App\Http\Controllers;

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
        return view('pesagens.cadastroPeso');
    }
    public function listAnimais(Request $request){
        $animais = $this->animalRepository->findAll($request);
        $racas = $this->racaRepository->findAll(null);
        $lotes = $this->loteRepository->findAll(null);
        return view('pesagens.listAnimais', compact('animais', 'racas', 'lotes'));
    }

    public function listAnimaisRequest(Request $request){
        $animaisCheckded =  $request->input('check');

        if(isset($animaisCheckded)){
            $animais = $this->animalRepository->findAllByCheck($animaisCheckded);
            $lotes = $this->loteRepository->findAll(null);
        }else{
            session()->flash('status', 'ERRO: Nenhum animal selecionado');
            return redirect()->route('pesagem.listAnimais');
        }

        return view('pesagens.pesagens', compact('animais', 'lotes'));
    }

    public function save(Request $request){
        $this->pesagemRepository->save($request);
        session()->flash('status', 'Pessagens Salvas com sucesso');
        return redirect()->route('pesagem.index');
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
