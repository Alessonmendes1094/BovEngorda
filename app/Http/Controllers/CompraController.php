<?php

namespace App\Http\Controllers;

use App\Lote;
use App\Raca;
use App\Animal;
use App\Manejo;
use App\ManejoAnimais;
use App\Repository\AnimalRepository;
use App\Repository\ClienteRepository;
use App\Repository\FornecedorRepository;
use App\Repository\LoteRepository;
use App\Repository\CompraRepository;
use App\Repository\RacaRepository;
use App\Utils\ExcelUtils;
use Illuminate\Http\Request;


class CompraController extends Controller
{

    private $fornecedorRepository;
    private $clienteRepository;
    private $animalRepository;
    private $loteRepository;
    private $racaRepository;
    private $compraRepository;

    public function __construct()
    {
        $this->fornecedorRepository = new FornecedorRepository();
        $this->animalRepository = new AnimalRepository();
        $this->loteRepository = new LoteRepository();
        $this->racaRepository = new RacaRepository();
        $this->compraRepository = new CompraRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->middleware('auth');
    }

    public function index(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        $manejos = $this->compraRepository->findAllManejosResumo($request);
        return view('manejo.compra.index', compact('fornecedores', 'manejos'));
    }

    public function novaCompra(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        return view('manejo.compra.compra', compact('fornecedores'));
    }

    public function save(Request $request){
        $manejo = $this->compraRepository->save($request);
        session()->flash('status', 'Manejo Salvo');
        
        if($request->id === null){
            return redirect()->route('compra.novoanimal' , $manejo->id);
        } else{
            return redirect()->route('compra.index');
        }
    }

    public function novoanimal(Request $request, $id){
        $racas =  $this->racaRepository->findAll($request);
        return view('manejo.compra.compraAnimal', compact('racas','id'));
    }

    public function saveanimais(Request $request,$id){
        $this->animalRepository->validacaoAnimal($request);
        $this->compraRepository->saveManejoAnimais($request , $id);
        session()->flash('status', 'Animal Salvo');
        return redirect()->route('compra.novoanimal', $id);
    }

    public function showanimais($id){
        $racas = Raca::all();
        $lotes = Lote::all();
        $animais = Animal::join('manejos_animais','id_manejo_compra','=','manejos_animais.id')
        ->join('pesagens','animais.id','pesagens.animal_id')
        ->with('raca')
        ->with('lote')
        ->where('manejo_id','=',$id)
            ->get();
            
        return view('manejo.compra.showanimais', compact('animais','id','lotes','racas'));
    }

    public function edit(Request $request, $id){
        $manejo = $this->compraRepository->findById($id);
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        if($manejo->tipo == 'compra'){
            return view('manejo.compra.compra', compact('manejo', 'fornecedores'));
        }elseif ($manejo->tipo == 'venda'){
            return view('manejo.compra.venda', compact('manejo', 'fornecedores'));
        }
        return abort(404, "Manejo Não Encontrado");
    }

    public function delete($id){
        $this->compraRepository->delete($id);
        session()->flash('status', 'Manejo Apagado');
        return redirect()->route('compra.index');
    }

    public function showFormcarregarDados(Request $request){
        $fornecedores =  $this->fornecedorRepository->findAll($request);
        return view('manejo.compra.formplanilha', compact('fornecedores'));
    }

    public function carregarDados(Request $request){
        $dados = ExcelUtils::loadPlanilha($request->file('file'));
        $manejo = new Manejo();
        $manejo->tipo = $request->input('tipo');
        $manejo->data = $request->input('data');
        $manejo->valorkg = $request->input('valorkg');
        $manejo->fornecedor_id = $request->input('fornecedor');
        return view('manejo.compra.showdadosplanilha', compact('dados', 'manejo'));
    }

    public function importarDados(Request $request){
        $dados = json_decode($request->input('dados'));
        $manejo = json_decode($request->input('manejo'));
        $respostaImportacao = $this->compraRepository->importByPlanilha($dados, $request, $manejo);
        session()->flash('status', $respostaImportacao[1]);

        return redirect()->route('compra.index');
    }
}
