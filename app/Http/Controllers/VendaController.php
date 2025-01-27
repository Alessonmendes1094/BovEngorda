<?php

namespace App\Http\Controllers;

use App\venda;
use App\Repository\AnimalRepository;
use App\Repository\ClienteRepository;
use App\Repository\FornecedorRepository;
use App\Repository\LoteRepository;
use App\Repository\VendaRepository;
use App\Repository\RacaRepository;
use App\Utils\ExcelUtils;
use Illuminate\Http\Request;


class VendaController extends Controller
{

    private $fornecedorRepository;
    private $clienteRepository;
    private $animalRepository;
    private $loteRepository;
    private $racaRepository;
    private $vendaRepository;

    public function __construct()
    {
        $this->fornecedorRepository = new FornecedorRepository();
        $this->animalRepository = new AnimalRepository();
        $this->loteRepository = new LoteRepository();
        $this->racaRepository = new RacaRepository();
        $this->vendaRepository = new VendaRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->middleware('auth');
    }

    public function index(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        $manejos = $this->vendaRepository->findAllvendasResumo($request);
        return view('manejo.venda.index', compact('fornecedores', 'manejos'));
    }

    public function novaCompra(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        $lotes = $this->loteRepository->findAll($request);
        return view('manejo.venda.compra', compact('fornecedores','lotes'));
    }

    public function novaVendaShowAnimais(Request $request){
        $animais = $this->animalRepository->findAll($request);
        $racas = $this->racaRepository->findAll(null);
        $lotes = $this->loteRepository->findAll(null);
        return view('manejo.venda.listAnimais', compact('animais', 'racas', 'lotes'));
    }

    public function novaVendaShowForm(Request $request){
        $clientes = $this->clienteRepository->findAll($request);
        $animaisCheckded =  $request->input('check');
        if(isset($animaisCheckded)){
            $animais = $this->animalRepository->findAllByCheck($animaisCheckded);
            return view('manejo.venda.venda', compact( 'clientes', 'animais'));
        }else {
            session()->flash('status', 'ERRO: Nenhum animal selecionado');
            return redirect()->route('venda.novaVendaShowAnimais');
        }

    }

    public function save(Request $request){
        $this->vendaRepository->save($request);
        session()->flash('status', 'venda Salvo');
        return redirect()->route('venda.index');
    }

    public function edit(Request $request, $id){
        $venda = $this->vendaRepository->findById($id);
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        if($venda->tipo == 'compra'){
            return view('manejo.venda.compra', compact('venda', 'fornecedores'));
        }elseif ($venda->tipo == 'venda'){
            return view('manejo.venda.venda', compact('venda', 'fornecedores'));
        }
        return abort(404, "venda Não Encontrado");
    }

    public function delete($id){
        $this->vendaRepository->delete($id);
        session()->flash('status', 'venda Apagado');
        return redirect()->route('venda.index');
    }

    public function showFormcarregarDados(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        return view('manejo.venda.formplanilha', compact('fornecedores'));
    }

    public function carregarDados(Request $request){
        $dados = ExcelUtils::loadPlanilha($request->file('file'));
        $venda = new venda();
        $venda->tipo = $request->input('tipo');
        $venda->data = $request->input('data');
        $venda->valorkg = $request->input('valorkg');
        $venda->fornecedor_id = $request->input('fornecedor');
        return view('manejo.venda.showdadosplanilha', compact('dados', 'venda'));
    }

    public function importarDados(Request $request){
        $dados = json_decode($request->input('dados'));
        $venda = json_decode($request->input('venda'));
        $respostaImportacao = $this->vendaRepository->importByPlanilha($dados, $request, $venda);
        session()->flash('status', $respostaImportacao[1]);

        return redirect()->route('venda.index');
    }
}
