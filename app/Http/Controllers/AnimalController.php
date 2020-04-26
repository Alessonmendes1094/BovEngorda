<?php

namespace App\Http\Controllers;

use App\Animal;
use App\Charts\AnimalGmdChart;
use App\Pessoa;
use App\Repository\AnimalRepository;
use App\Repository\LoteRepository;
use App\Repository\ManejoRepository;
use App\Repository\PesagemRepository;
use App\Repository\RacaRepository;
use App\Repository\TipoBaixasRepository;
use App\Utils\ExcelUtils;
use Faker\Provider\bn_BD\Utils;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    private $animalRepository;
    private $loteRepository;
    private $racaRepository;
    private $tipoBaixasRepository;
    private $pessagemRepository;
    private $manejoRepository;

    public function __construct()
    {
        $this->animalRepository = new AnimalRepository();
        $this->loteRepository = new LoteRepository();
        $this->racaRepository = new RacaRepository();
        $this->pessagemRepository = new PesagemRepository();
        $this->tipoBaixasRepository = new TipoBaixasRepository();
        $this->manejoRepository = new ManejoRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $animais = $this->animalRepository->findAll($request);
        $racas = $this->racaRepository->findAll($request);
        $lotes = $this->loteRepository->findAll($request);
        $tiposBaixas = $this->tipoBaixasRepository->findAll($request);
        return view('animais.index', compact('animais', 'lotes', 'racas', 'tiposBaixas'));
    }

    public function autocomplete(Request $request) {

        $search = $request->get('term');

        $result = Animal::where('id_tipobaixa' , '=',null)->get();

        return response()->json($result);
    }

    public function showFormAnimal(Request $request){
        $animal = new Animal();
        $lotes = $this->loteRepository->findAll($request);
        $racas = $this->racaRepository->findAll($request);
        $tipoBaixas = $this->tipoBaixasRepository->findAll($request);
        $historicoLotes = null;
        return view('animais.animal', compact('lotes', 'racas', 'tipoBaixas', 'animal', 'historicoLotes'));
    }

    public function showFormcarregarDados(){
        return view('animais.formplanilha');
    }

    public function carregarDados(Request $request){
        $dados = ExcelUtils::loadPlanilha($request->file('file'));
        return view('animais.showdadosplanilha', compact('dados'));
    }

    public function importarDados(Request $request){
        $dados = json_decode($request->input('dados'));
        $respostaImportacao = $this->animalRepository->importByPlanilha($dados, $request);
        session()->flash('status', $respostaImportacao[1]);

        return redirect()->route('animal.index');
    }

    public function save(Request $request){
        $this->animalRepository->save($request);
        session()->flash('status', 'Animal Salvo');
        return redirect()->route('animal.index');
    }

    public function showFormAnimalForEdit(Request $request, $id){
        $animal = $this->animalRepository->findById($id);
        $lotes = $this->loteRepository->findAll($request);
        $racas = $this->racaRepository->findAll($request);
        $tipoBaixas = $this->tipoBaixasRepository->findAll($request);

        $animalGmdChart = new AnimalGmdChart();
        $gmd = $this->pessagemRepository->gmdChart($id);
        $animalGmdChart->labels($gmd[1]);
        $animalGmdChart->dataset('GMDs', 'line', $gmd[0])->color('#000000');

        $compra = $this->manejoRepository->findManejoByAnimal($animal, 'compra');
        $venda = $this->manejoRepository->findManejoByAnimal($animal, 'venda');
        $historicoLotes = $this->loteRepository->findHistoricoByAnimal($animal);

        return view('animais.animal', compact('animal', 'lotes', 'racas', 'tipoBaixas', 'historicoLotes',
            'compra', 'venda', 'animalGmdChart'));
    }

    public function delete($id){
        $this->animalRepository->deleteById($id);
        session()->flash('status', 'Animal Apagado');
        return redirect()->route('animal.index');
    }

    public function verifyAnimalByBrinco($brinco){
        $animal = $this->animalRepository->findByBrinco($brinco);
        return response()->json($animal);
    }

}
