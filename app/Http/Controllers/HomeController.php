<?php

namespace App\Http\Controllers;

use App\Charts\PizzaHomeChart;
use App\Repository\AnimalRepository;
use App\Repository\LoteRepository;
use App\Repository\PesagemRepository;
use App\Repository\RacaRepository;
use App\Repository\TipoBaixasRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $animalRepository;
    private $loteRepository;
    private $racaRepository;
    private $pessagemRepository;

    public function __construct()
    {
        $this->animalRepository = new AnimalRepository();
        $this->loteRepository = new LoteRepository();
        $this->racaRepository = new RacaRepository();
        $this->pessagemRepository = new PesagemRepository();
        $this->middleware('auth');
    }

    public function index()
    {
        $totalAnimais = $this->animalRepository->getTotalAnimais();

        $totalAnimaisPorRaca = $this->animalRepository->getTotalAnimaisPorRaca();
        $chartAnimaisPorRaca = new PizzaHomeChart();
        $chartAnimaisPorRaca->title("Total de Animais por Raça");
        $chartAnimaisPorRaca->labels($totalAnimaisPorRaca->keys());
        $chartAnimaisPorRaca->dataset('Raças', 'pie', $totalAnimaisPorRaca->values())->backgroundcolor(collect(['#FFEB29','#E8891A', '#FF3029', '#A11AE8', '#3C73FF', '#E8891A', '#FF3029', '#A11AE8', '#3C73FF']));

        $totalAnimaisPorLote = $this->animalRepository->getTotalAnimaisPorLote();
        $chartAnimaisPorLote = new PizzaHomeChart();
        $chartAnimaisPorLote->title("Total de Animais por Lote");
        $chartAnimaisPorLote->labels($totalAnimaisPorLote->keys());
        $chartAnimaisPorLote->dataset('Lotes', 'pie', $totalAnimaisPorLote->values())->backgroundcolor(collect(['#FFEB29','#E8891A', '#FF3029', '#A11AE8', '#3C73FF', '#E8891A', '#FF3029', '#A11AE8', '#3C73FF']));


        return view('home', compact('totalAnimais', 'chartAnimaisPorLote', 'chartAnimaisPorRaca'));
    }
}
