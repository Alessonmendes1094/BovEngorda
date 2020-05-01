<?php

namespace App\Http\Controllers;

use App\Manejo;
use App\Repository\AnimalRepository;
use App\Repository\ClienteRepository;
use App\Repository\FornecedorRepository;
use App\Repository\LoteRepository;
use App\Repository\ManejoRepository;
use App\Repository\RacaRepository;
use App\Utils\ExcelUtils;
use Illuminate\Http\Request;


class ManejoController extends Controller
{

    private $fornecedorRepository;
    private $clienteRepository;
    private $animalRepository;
    private $loteRepository;
    private $racaRepository;
    private $manejoRepository;

    public function __construct()
    {
        $this->fornecedorRepository = new FornecedorRepository();
        $this->animalRepository = new AnimalRepository();
        $this->loteRepository = new LoteRepository();
        $this->racaRepository = new RacaRepository();
        $this->manejoRepository = new ManejoRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->middleware('auth');
    }

    public function index(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        $manejos = $this->manejoRepository->findAllManejosResumo($request);
        return view('manejo.index', compact('fornecedores', 'manejos'));
    }

    public function novaCompra(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        $lotes = $this->loteRepository->findAll($request);
        return view('manejo.compra', compact('fornecedores','lotes'));
    }

    public function novaVendaShowAnimais(Request $request){
        $animais = $this->animalRepository->findAll($request);
        $racas = $this->racaRepository->findAll(null);
        $lotes = $this->loteRepository->findAll(null);
        return view('manejo.listAnimais', compact('animais', 'racas', 'lotes'));
    }

    public function novaVendaShowForm(Request $request){
        $clientes = $this->clienteRepository->findAll($request);
        $animaisCheckded =  $request->input('check');
        if(isset($animaisCheckded)){
            $animais = $this->animalRepository->findAllByCheck($animaisCheckded);
            return view('manejo.venda', compact( 'clientes', 'animais'));
        }else {
            session()->flash('status', 'ERRO: Nenhum animal selecionado');
            return redirect()->route('manejo.novaVendaShowAnimais');
        }

    }

    public function save(Request $request){
        $this->manejoRepository->save($request);
        session()->flash('status', 'Manejo Salvo');
        return redirect()->route('manejo.index');
    }

    public function edit(Request $request, $id){
        $manejo = $this->manejoRepository->findById($id);
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        if($manejo->tipo == 'compra'){
            return view('manejo.compra', compact('manejo', 'fornecedores'));
        }elseif ($manejo->tipo == 'venda'){
            return view('manejo.venda', compact('manejo', 'fornecedores'));
        }
        return abort(404, "Manejo Não Encontrado");
    }

    public function delete($id){
        $this->manejoRepository->delete($id);
        session()->flash('status', 'Manejo Apagado');
        return redirect()->route('manejo.index');
    }

    public function showFormcarregarDados(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        return view('manejo.formplanilha', compact('fornecedores'));
    }

    public function carregarDados(Request $request){
        $dados = ExcelUtils::loadPlanilha($request->file('file'));
        $manejo = new Manejo();
        $manejo->tipo = $request->input('tipo');
        $manejo->data = $request->input('data');
        $manejo->valorkg = $request->input('valorkg');
        $manejo->fornecedor_id = $request->input('fornecedor');
        return view('manejo.showdadosplanilha', compact('dados', 'manejo'));
    }

    public function importarDados(Request $request){
        $dados = json_decode($request->input('dados'));
        $manejo = json_decode($request->input('manejo'));
        $respostaImportacao = $this->manejoRepository->importByPlanilha($dados, $request, $manejo);
        session()->flash('status', $respostaImportacao[1]);

        return redirect()->route('manejo.index');
    }
}