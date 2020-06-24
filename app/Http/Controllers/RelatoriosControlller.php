<?php

namespace App\Http\Controllers;

use App\Repository\AnimalRepository;
use App\Repository\ClienteRepository;
use App\Repository\FornecedorRepository;
use App\Repository\LoteRepository;
use App\Repository\RacaRepository;
use App\Repository\RelatorioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RelatoriosControlller extends Controller
{
    private $fornecedorRepository;
    private $animalRepository;
    private $loteRepository;
    private $racaRepository;
    private $manejoRepository;
    private $relatorioRepository;
    private $clienteRepository;

    public function __construct()
    {
        $this->fornecedorRepository = new FornecedorRepository();
        $this->animalRepository     = new AnimalRepository();
        $this->loteRepository       = new LoteRepository();
        $this->racaRepository       = new RacaRepository();
        #$this->manejoRepository = new ManejoRepository();
        $this->relatorioRepository = new RelatorioRepository();
        $this->clienteRepository   = new ClienteRepository();
        $this->middleware('auth');
    }

    public function index()
    {
        $fornecedores = $this->fornecedorRepository->All();
        $animais      = $this->animalRepository->All();
        $racas        = $this->racaRepository->All();
        $lotes        = $this->loteRepository->All();
        $clientes     = $this->clienteRepository->All();
        return view('relatorios.index', compact('fornecedores', 'animais', 'racas', 'lotes', 'clientes'));
    }

    public function gmdAnimal(Request $request)
    {

        $animais            = $request->animais;
        $racas              = $request->racas;
        $lotes              = $request->lotes;
        $fornecedores       = $request->fornecedores;
        $compras            = $request->compra_fornecedor;
        $stringAnimais      = '';
        $stringRacas        = '';
        $stringLotes        = '';
        $stringFornecedores = '';
        $compraFornecedor   = '';

        if (in_array("Todo$", $animais)) {
            $stringAnimais = 'Todo$';
        } else {
            $fimAnimais = end($animais);
            foreach ($animais as $animal) {
                if ($fimAnimais == $animal) {
                    $stringAnimais = $stringAnimais . $animal;
                } else {
                    $stringAnimais = $stringAnimais . $animal . ',';
                }
            }
        }

        if (in_array("Todo$", $racas)) {
            $stringRacas = 'Todo$';
        } else {
            $fimracas = end($racas);
            foreach ($racas as $raca) {
                if ($fimracas == $raca) {
                    $stringRacas = $stringRacas . $raca;
                } else {
                    $stringRacas = $stringRacas . $raca . ',';
                }
            }
        }

        if (in_array("Todo$", $lotes)) {
            $stringLotes = 'Todo$';
        } else {
            $fimlotes = end($lotes);
            foreach ($lotes as $lote) {
                if ($fimlotes == $lote) {
                    $stringLotes = $stringLotes . $lote;
                } else {
                    $stringLotes = $stringLotes . $lote . ',';
                }
            }
        }

        if ($fornecedores == null) {
            $stringFornecedores = 'Todo$';
        } else {
            $fimFornecedores = end($fornecedores);
            foreach ($fornecedores as $fornecedor) {
                if ($fimFornecedores == $fornecedor) {
                    $stringFornecedores = $stringFornecedores . $fornecedor;
                } else {
                    $stringFornecedores = $stringFornecedores . $fornecedor . ',';
                }
            }
        }

        if ($compras == null) {
            $compraFornecedor = 'Todo$';
        } else {
            $fimcompras = end($compras);
            foreach ($compras as $compra) {
                if ($fimcompras == $compra) {
                    $compraFornecedor = $compraFornecedor . $compra;
                } else {
                    $compraFornecedor = $compraFornecedor . $compra . ',';
                }
            }
        }

        $dados = $this->relatorioRepository->gmdAnimal($stringAnimais, $stringRacas, $stringLotes, $stringFornecedores, $compraFornecedor);
        return view('relatorios.gmd_animal', compact('dados', 'stringAnimais', 'stringRacas', 'stringLotes', 'stringFornecedores', 'compraFornecedor'));
    }

    public function gmdAnimalExcel($animais, $fornecedor, $racas, $lotes, $compraFornecedor)
    {
        $dados       = $this->relatorioRepository->gmdAnimal($animais, $racas, $lotes, $fornecedor, $compraFornecedor);
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $x = 1;
        $sheet->setCellValue('A' . $x, "Brinco");
        $sheet->setCellValue('B' . $x, "Data");
        $sheet->setCellValue('C' . $x, "Peso");
        $sheet->setCellValue('D' . $x, "Dif Dias");
        $sheet->setCellValue('E' . $x, "GMD");
        $x++;

        $animal = 0;
        $letra  = '';
        $compra = 0;
        foreach ($dados as $get) {
            if ($animal === 0 or $animal != $get->animal_id) {
                if ($animal != 0) {
                    $x++;
                }
                if ($compra != $get->id_manejo_compra) {  //DEFINE LINHA DE COMPRA DO FORNECEDOR
                    $sheet->setCellValue('A' . $x, 'Compra do fornecedor "'.$get->fornecedor.'" do dia "'.date('d/m/Y', strtotime($get->data_compra)).'"');
                    $x++;
                    $compra = $get->id_manejo_compra;
                }
                $letra = 'A';
                $sheet->setCellValue($letra . $x, $get->brinco);
                $animal = $get->animal_id;
            }
            if($animal === $get->animal_id){ //GERA REGISTROS DE PESAGENS DOS ANIMAIS
                ++$letra;
                $sheet->setCellValue($letra . $x, date('d/m/Y', strtotime($get->data)));
                ++$letra;
                $sheet->setCellValue($letra . $x, $get->peso);
                ++$letra;
                $sheet->setCellValue($letra . $x, $get->dif_dias);
                ++$letra;
                if (isset($get->dif_dias) and isset($get->diff_peso)) {
                    $sheet->setCellValue($letra . $x, number_format($get->diff_peso / $get->dif_dias, 2, ',', ' '));
                }
            }
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::put("gmdAnimais.xlsx", $content);
        return Storage::download('gmdAnimais.xlsx');
    }

    public function gmdAnimalBaixados(Request $request)
    {
        $animais            = $request->animais;
        $racas              = $request->racas;
        $fornecedores       = $request->fornecedores;
        $stringAnimais      = '';
        $stringRacas        = '';
        $stringFornecedores = '';
        $compraFornecedor   = $request->compra_fornecedor[0];

        if (in_array("Todo$", $animais)) {
            $stringAnimais = 'Todo$';
        } else {
            $fimAnimais = end($animais);
            foreach ($animais as $animal) {
                if ($fimAnimais == $animal) {
                    $stringAnimais = $stringAnimais . $animal;
                } else {
                    $stringAnimais = $stringAnimais . $animal . ',';
                }
            }
        }

        if (in_array("Todo$", $racas)) {
            $stringRacas = 'Todo$';
        } else {
            $fimracas = end($racas);
            foreach ($racas as $raca) {
                if ($fimracas == $raca) {
                    $stringRacas = $stringRacas . $raca;
                } else {
                    $stringRacas = $stringRacas . $raca . ',';
                }
            }
        }

        if (in_array("Todo$", $fornecedores)) {
            $stringFornecedores = 'Todo$';
        } else {
            $fimFornecedores = end($fornecedores);
            foreach ($fornecedores as $fornecedor) {
                if ($fimFornecedores == $fornecedor) {
                    $stringFornecedores = $stringFornecedores . $fornecedor;
                } else {
                    $stringFornecedores = $stringFornecedores . $fornecedor . ',';
                }
            }
        }

        //dd($animais, $stringAnimais,$fornecedores,$stringFornecedores);
        $dados = $this->relatorioRepository->gmdAnimalBaixados($stringAnimais, $stringRacas, $stringFornecedores, $compraFornecedor);
        return view('relatorios.gmd_animal_baixados', compact('dados', 'stringAnimais', 'stringRacas', 'stringFornecedores', 'compraFornecedor'));
    }

    public function gmdAnimalExcelBaixados($animais, $fornecedor, $racas, $compraFornecedor)
    {
        $dados       = $this->relatorioRepository->gmdAnimalBaixados($animais, $fornecedor, $racas, $compraFornecedor);
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $x = 1;
        $sheet->setCellValue('A' . $x, "Brinco");
        $sheet->setCellValue('B' . $x, "Fornecedor");
        $sheet->setCellValue('C' . $x, "Racao");
        $sheet->setCellValue('D' . $x, "Data");
        $sheet->setCellValue('E' . $x, "Peso");
        $sheet->setCellValue('F' . $x, "GMD");
        $x++;
        foreach ($dados as $get) {

            $sheet->setCellValue('A' . $x, $get->brinco);
            $sheet->setCellValue('B' . $x, $get->fornecedor);
            $sheet->setCellValue('C' . $x, $get->raca);
            $sheet->setCellValue('D' . $x, date('d/m/Y', strtotime($get->data)));
            $sheet->setCellValue('E' . $x, $get->peso);
            if (isset($get->dif_dias) and isset($get->diff_peso)) {
                $sheet->setCellValue('F' . $x, number_format($get->diff_peso / $get->dif_dias, 2, ',', ' '));
            }
            $x++;
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::put("myfile.xlsx", $content);
        return Storage::download('myfile.xlsx');
    }

    public function custo_Animal(Request $request)
    {
        $racas              = $request->racas;
        $stringRacas        = '';
        $animais            = $request->animais;
        $stringAnimais      = '';
        $fornecedores       = $request->fornecedores;
        $stringFornecedores = '';
        $compraFornecedor   = $request->compra_fornecedor[0];

        if (in_array("Todo$", $racas)) {
            $stringRacas = 'Todo$';
        } else {
            $fimracas = end($racas);
            foreach ($racas as $raca) {
                if ($fimracas == $raca) {
                    $stringRacas = $stringRacas . $raca;
                } else {
                    $stringRacas = $stringRacas . $raca . ',';
                }
            }
        }

        if (in_array("Todo$", $animais)) {
            $stringAnimais = 'Todo$';
        } else {
            $fimanimais = end($animais);
            foreach ($animais as $animal) {
                if ($fimanimais == $animal) {
                    $stringAnimais = $stringAnimais . $animal;
                } else {
                    $stringAnimais = $stringAnimais . $animal . ',';
                }
            }
        }

        if (in_array("Todo$", $fornecedores)) {
            $stringFornecedores = 'Todo$';
        } else {
            $fimforn = end($fornecedores);
            foreach ($fornecedores as $fornecedor) {
                if ($fimforn == $fornecedor) {
                    $stringFornecedores = $stringFornecedores . $fornecedor;
                } else {
                    $stringFornecedores = $stringFornecedores . $fornecedor . ',';
                }
            }
        }

        $dados = $this->relatorioRepository->custo_animal($stringRacas, $stringAnimais, $stringFornecedores, $compraFornecedor);
        return view('relatorios.custo_animal', compact('dados', 'stringRacas', 'stringAnimais', 'stringFornecedores', 'compraFornecedor'));
    }

    public function custo_AnimalExcel($animais, $fornecedor, $racas, $compraFornecedor)
    {
        $dados = $this->relatorioRepository->custo_animal($animais, $fornecedor, $racas, $compraFornecedor);
        //dd($dados);
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $x = 1;
        $sheet->setCellValue('A' . $x, "Brinco");
        $sheet->setCellValue('B' . $x, "Nome");
        $sheet->setCellValue('C' . $x, "Raça");
        $sheet->setCellValue('D' . $x, "Data_Pesagem");
        $sheet->setCellValue('E' . $x, "Peso");
        $sheet->setCellValue('F' . $x, "Animal_Lote");
        $sheet->setCellValue('G' . $x, "Tipo");
        $sheet->setCellValue('H' . $x, "Valor");
        $x++;
        foreach ($dados as $get) {

            $sheet->setCellValue('A' . $x, $get->brinco);
            $sheet->setCellValue('B' . $x, $get->nome);
            $sheet->setCellValue('C' . $x, $get->id_raca);
            $sheet->setCellValue('D' . $x, date('d/m/Y', strtotime($get->data_pesagem)));
            $sheet->setCellValue('E' . $x, $get->peso);
            $sheet->setCellValue('F' . $x, $get->animal_lote);
            $sheet->setCellValue('G' . $x, $get->tipo);
            $sheet->setCellValue('H' . $x, $get->manejo_valor);

            $x++;
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::put("myfile.xlsx", $content);
        return Storage::download('myfile.xlsx');
    }

    public function compras_Animal(Request $request)
    {
        $animais            = $request->animais;
        $racas              = $request->racas;
        $fornecedores       = $request->fornecedores;
        $dataini            = $request->dataini;
        $datafim            = $request->datafim;
        $stringAnimais      = '';
        $stringRacas        = '';
        $stringFornecedores = '';

        if ($dataini === null) {
            $dataini = '1950-01-01';
        }
        if ($datafim === null) {
            $datafim = '2100-01-01';
        }

        if (in_array("Todo$", $animais)) {
            $stringAnimais = 'Todo$';
        } else {
            $fimAnimais = end($animais);
            foreach ($animais as $animal) {
                if ($fimAnimais == $animal) {
                    $stringAnimais = $stringAnimais . $animal;
                } else {
                    $stringAnimais = $stringAnimais . $animal . ',';
                }
            }
        }

        if (in_array("Todo$", $racas)) {
            $stringRacas = 'Todo$';
        } else {
            $fimracas = end($racas);
            foreach ($racas as $raca) {
                if ($fimracas == $raca) {
                    $stringRacas = $stringRacas . $raca;
                } else {
                    $stringRacas = $stringRacas . $raca . ',';
                }
            }
        }

        if (in_array("Todo$", $fornecedores)) {
            $stringFornecedores = 'Todo$';
        } else {
            $fimFornecedores = end($fornecedores);
            foreach ($fornecedores as $fornecedor) {
                if ($fimFornecedores == $fornecedor) {
                    $stringFornecedores = $stringFornecedores . $fornecedor;
                } else {
                    $stringFornecedores = $stringFornecedores . $fornecedor . ',';
                }
            }
        }

        //dd($animais, $stringAnimais,$fornecedores,$stringFornecedores);
        $dados = $this->relatorioRepository->compras_Animal($stringAnimais, $stringRacas, $stringFornecedores, $dataini, $datafim);
        return view('relatorios.compras_animal', compact('dados', 'stringAnimais', 'stringRacas', 'stringFornecedores', 'dataini', 'datafim'));
    }

    public function compras_AnimalExcel($animais, $fornecedor, $racas, $dataini, $datafim)
    {
        $dados = $this->relatorioRepository->compras_Animal($animais, $fornecedor, $racas, $dataini, $datafim);
        //dd($dados);
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $x = 1;
        $sheet->setCellValue('A' . $x, "Data");
        $sheet->setCellValue('B' . $x, "Fornecedor");
        $sheet->setCellValue('C' . $x, "Raça");
        $sheet->setCellValue('D' . $x, "Brinco");
        $sheet->setCellValue('E' . $x, "Valor KG");
        $sheet->setCellValue('F' . $x, "Peso");
        $sheet->setCellValue('G' . $x, "Total");
        $x++;
        $i     = 1;
        $end   = end($dados);
        $total = 0;
        foreach ($dados as $dado) {

            $sheet->setCellValue('A' . $x, date('d/m/Y', strtotime($dado->data)));
            $sheet->setCellValue('B' . $x, $dado->fornecedor);
            $sheet->setCellValue('C' . $x, $dado->raca);
            $sheet->setCellValue('D' . $x, $dado->brinco);
            $sheet->setCellValue('E' . $x, $dado->valorkg);
            $sheet->setCellValue('F' . $x, $dado->peso);
            $sheet->setCellValue('G' . $x, $dado->valor);

            $i     = $i + 1;
            $total = $total + $dado->valor;
            $x++;
            if ($end == $dado) {
                $sheet->setCellValue('G' . $x, $total);
            }
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::put("compras_animais.xlsx", $content);
        return Storage::download('compras_animais.xlsx');
    }

    public function vendas_Animal(Request $request)
    {
        $animais        = $request->animais;
        $racas          = $request->racas;
        $clientes       = $request->clientes;
        $dataini        = $request->dataini;
        $datafim        = $request->datafim;
        $stringAnimais  = '';
        $stringRacas    = '';
        $stringClientes = '';

        if ($dataini === null) {
            $dataini = '1950-01-01';
        }
        if ($datafim === null) {
            $datafim = '2100-01-01';
        }

        if (in_array("Todo$", $animais)) {
            $stringAnimais = 'Todo$';
        } else {
            $fimAnimais = end($animais);
            foreach ($animais as $animal) {
                if ($fimAnimais == $animal) {
                    $stringAnimais = $stringAnimais . $animal;
                } else {
                    $stringAnimais = $stringAnimais . $animal . ',';
                }
            }
        }

        if (in_array("Todo$", $racas)) {
            $stringRacas = 'Todo$';
        } else {
            $fimracas = end($racas);
            foreach ($racas as $raca) {
                if ($fimracas == $raca) {
                    $stringRacas = $stringRacas . $raca;
                } else {
                    $stringRacas = $stringRacas . $raca . ',';
                }
            }
        }

        if (in_array("Todo$", $clientes)) {
            $stringClientes = 'Todo$';
        } else {
            $fimclientes = end($clientes);
            foreach ($clientes as $cliente) {
                if ($fimclientes == $cliente) {
                    $stringClientes = $stringClientes . $cliente;
                } else {
                    $stringClientes = $stringClientes . $cliente . ',';
                }
            }
        }

        //dd($animais, $stringAnimais,$fornecedores,$stringFornecedores);
        $dados = $this->relatorioRepository->vendas_Animal($stringAnimais, $stringRacas, $stringClientes, $dataini, $datafim);
        return view('relatorios.vendas_animal', compact('dados', 'stringAnimais', 'stringRacas', 'stringClientes', 'dataini', 'datafim'));
    }

    public function vendas_AnimalExcel($animais, $clientes, $racas, $dataini, $datafim)
    {
        $dados = $this->relatorioRepository->vendas_Animal($animais, $clientes, $racas, $dataini, $datafim);
        //dd($dados);
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $x = 1;
        $sheet->setCellValue('A' . $x, "Data");
        $sheet->setCellValue('B' . $x, "Cliente");
        $sheet->setCellValue('C' . $x, "Raça");
        $sheet->setCellValue('D' . $x, "Brinco");
        $sheet->setCellValue('E' . $x, "Valor KG");
        $sheet->setCellValue('F' . $x, "Peso");
        $sheet->setCellValue('G' . $x, "Total");
        $x++;
        $i     = 1;
        $end   = end($dados);
        $total = 0;
        foreach ($dados as $dado) {

            $sheet->setCellValue('A' . $x, date('d/m/Y', strtotime($dado->data)));
            $sheet->setCellValue('B' . $x, $dado->cliente);
            $sheet->setCellValue('C' . $x, $dado->raca);
            $sheet->setCellValue('D' . $x, $dado->brinco);
            $sheet->setCellValue('E' . $x, $dado->valorkg);
            $sheet->setCellValue('F' . $x, $dado->peso);
            $sheet->setCellValue('G' . $x, $dado->valor);

            $i     = $i + 1;
            $total = $total + $dado->valor;
            $x++;
            if ($end == $dado) {
                $sheet->setCellValue('G' . $x, $total);
            }
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::put("vendas_animais.xlsx", $content);
        return Storage::download('vendas_animais.xlsx');
    }

    public function financeiro_pagar(Request $request)
    {
        $documento  = $request->documento;
        $categoria  = $request->categoria;
        $fornecedor = $request->fornecedor;
        $vencini    = $request->vencini;
        $vencfin    = $request->vencfin;
        $pgtoini    = $request->pgtoini;
        $pgtofin    = $request->pgtofin;
        $lctoini    = $request->lctoini;
        $lctofin    = $request->lctofin;

        $dados = $this->relatorioRepository->financeiro_pagar($documento, $categoria, $fornecedor, $vencini, $vencfin, $pgtoini, $pgtofin, $lctoini, $lctofin);
        return view('relatorios.financeiro_pagar', compact('dados', 'documento', 'categoria', 'fornecedor', 'vencini', 'vencfin', 'pgtoini', 'pgtofin', 'lctoini', 'lctofin'));
    }

    public function financeiro_pagarExcel(Request $request)
    {
        $array = $request->array;
        $array = utf8_encode($array);
        $dados = json_decode(json_encode($array));
        dd($dados, $array);

        foreach ($dados as $i) {
            echo $i;
        }

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $x = 1;
        $sheet->setCellValue('A' . $x, "Data");

        $x++;
        $i     = 1;
        $end   = end($dados);
        $total = 0;
        foreach ($dados as $dado) {

            $sheet->setCellValue('A' . $x, date('d/m/Y', strtotime($dado->data)));

            $i     = $i + 1;
            $total = $total + $dado->valor;
            $x++;
            if ($end == $dado) {
                $sheet->setCellValue('G' . $x, $total);
            }
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::put("vendas_animais.xlsx", $content);
        return Storage::download('vendas_animais.xlsx');
    }

    public function financeiro_receber(Request $request)
    {
        $documento  = $request->documento;
        $categoria  = $request->categoria;
        $fornecedor = $request->fornecedor;
        $vencini    = $request->vencini;
        $vencfin    = $request->vencfin;
        $pgtoini    = $request->pgtoini;
        $pgtofin    = $request->pgtofin;
        $lctoini    = $request->lctoini;
        $lctofin    = $request->lctofin;

        $dados = $this->relatorioRepository->financeiro_receber($documento, $categoria, $fornecedor, $vencini, $vencfin, $pgtoini, $pgtofin, $lctoini, $lctofin);
        return view('relatorios.financeiro_receber', compact('dados', 'documento', 'categoria', 'fornecedor', 'vencini', 'vencfin', 'pgtoini', 'pgtofin', 'lctoini', 'lctofin'));
    }

}
