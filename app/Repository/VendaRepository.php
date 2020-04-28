<?php


namespace App\Repository;

use App\Animal;
use App\HistoricoLotes;
use App\Lote;
use App\Manejo;
use App\Raca;
use App\ManejoAnimais;
use App\Pesagem;
use App\TipoBaixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ManejoRepository
{

    public function findAllManejosResumo($request)
    {

        return Manejo::
        join('manejos_animais', 'manejos_animais.manejo_id', '=', 'manejos.id')
            ->leftjoin('fornecedores', 'fornecedores.id', '=', 'manejos.fornecedor_id')
            ->leftjoin('clientes', 'clientes.id', '=', 'manejos.cliente_id')
            ->select('manejos.id', 'fornecedores.nome as fornecedor', 'clientes.nome as cliente', 'data', 'tipo', DB::raw('count(animal_id) as qtdAnimais, sum(valor) as valorTotals'))
            ->where($this->buildFiltro($request))
            ->groupBy('manejos.id', 'fornecedores.nome', 'clientes.nome', 'data', 'tipo')
            ->orderBy('data', 'desc')
            ->paginate(25);
    }

    public function save(Request $request)
    {
        $manejo = Manejo::find($request->input('id'));
        if (!isset($manejo)) {
            $manejo = new Manejo();
        }

        $manejo->data = $request->input('data');
        $manejo->tipo = $request->input('tipo');
        if ($manejo->tipo == "compra") {
            $manejo->fornecedor_id = $request->input('fornecedor');
        } else if ($manejo->tipo == "venda") {
            $manejo->cliente_id = $request->input('cliente');
            $hist_lote = $request->input('lote');
        }
        $manejo->valorkg = $request->input('valorkg');
        $animais = $request->input('animal');
        $manejo->save();
        if (count($animais) > 0) {
            $this->deleteManejoAnimais($manejo);
            $this->saveManejoAnimais($animais, $manejo, $hist_lote);
        }
    }

    private function deleteManejoAnimais(Manejo $manejo)
    {
        ManejoAnimais::where('manejo_id', '=', $manejo->id)->delete();
    }

    private function saveAnimal($request, $manejo)
    {
        $animal = new Animal();
        $animal->brinco = $request['brinco'];
        $animal->nome = "Boi " . $request['brinco'];
        $animal->id_fornecedor = $manejo->fornecedor_id;
        $animal->save();
        return $animal;
    }

    private function savePesagem($request, $manejo, $animalSaved)
    {
        $pesagem = new Pesagem();
        $pesagem->data = $manejo->data;
        $pesagem->peso = $request['peso'];
        $pesagem->animal_id = $animalSaved->id;
        $pesagem->save();
        return $pesagem;
    }

    public function saveManejoAnimais($animais, Manejo $manejo, $hist_lote)
    {
        foreach ($animais as $animal) {
            //inicializa variavel historico
            $historico = new  HistoricoLotes();

            if ($manejo->tipo == "compra") {
                //salva Animais
                $animalSaved = $this->saveAnimal($animal, $manejo);

                //grava dados na variavel historico
                $historico->origem = "Compra";
                $historico->id_lote = $hist_lote;

            } else if ($manejo->tipo == "venda") {
                //busca animal cadastrado
                $animalSaved = Animal::find($animal["id"]);
                $animalSaved->id_tipobaixa = 1;
                $animalSaved->save();

                //grava dados na variavel historico
                $historico->origem = "Ultima Pesagem";
                $historico->id_lote = $animalSaved->id_lote;

                //grava ultima pesagem antes da venda (utilizado para calculo do custo com alimento até o ultimo peso)
                $pesagemUlt = $this->savePesagem($animal, $manejo, $animalSaved);

            }
            //grava pesagem que ficará vinculada ao manejo de venda
            $pesagemSaved = $this->savePesagem($animal, $manejo, $animalSaved);

            //termina inclusão da variavel historico e salva na base.
            $historico->data = $manejo->data;
            $historico->id_animal = $animalSaved->id;
            $historico->id_pesagem = $pesagemSaved->id;
            $historico->save();

            //cria manejo do animal vinculando a variavel $pesagemSaved.
            $manejoAnimal = new  ManejoAnimais();
            $manejoAnimal->animal_id = $animalSaved->id;
            $manejoAnimal->pesagem_id = $pesagemSaved->id;
            $manejoAnimal->manejo_id = $manejo->id;
            $manejoAnimal->valor = $animal['valor'];
            $manejoAnimal->save();
        }
    }

    public function delete($id)
    {
        Manejo::destroy($id);
    }

    private function buildFiltro($request)
    {
        $filtro = array();
        $dataInit = $request->input("dataInit");
        if (isset($dataInit)) {
            array_push($filtro, ['data', '>=', $dataInit]);
        }
        $dataFim = $request->input("dataFim");
        if (isset($dataFim)) {
            array_push($filtro, ['data', '<=', $dataFim]);
        }
        $tipo = $request->input("tipo");
        if (isset($tipo)) {
            array_push($filtro, ['tipo', '=', $tipo]);
        }
        $fornecedor = $request->input("fornecedor");
        if (isset($fornecedor)) {
            array_push($filtro, ['fornecedor_id', '=', $fornecedor]);
        }
        return $filtro;

    }

    public function findById($id)
    {
        return Manejo::find($id);
    }

    public function importByPlanilha($dados, $request, $manejoForm)
    {
        try {
            DB::beginTransaction();
            //Inicializa variavel Manejo
            $manejo = new Manejo();
            $manejo->fornecedor_id = $manejoForm->fornecedor_id;
            $manejo->data = $manejoForm->data;
            $manejo->tipo = $manejoForm->tipo;
            $manejo->valorkg = $manejoForm->valorkg;
            $manejo->save();

            foreach ($dados as $row) {
                if (count($row) > 0) {
                    //Inicializa variavel Historico
                    $historico = new  HistoricoLotes();

                    if ($manejo->tipo == "venda") {
                        //busca animal cadastrado
                        $animal = Animal::where('brinco', '=', $row[$request->input('brinco')])->first();
                        $animal->id_tipobaixa = 1;
                        $animal->save();

                        //define a origem do historico na variavel
                        $historico->origem = "Venda_Imp";

                        //grava ultima pesagem antes da venda (utilizado para calculo do custo com alimento até o ultimo peso)
                        $pesagemUlt = new Pesagem();
                        $pesagemUlt->data = $manejo->data;
                        $pesagemUlt->peso = $row[$request->input('peso')];
                        $pesagemUlt->animal_id = $animal->id;
                        $pesagemUlt->save();

                    } else {
                        //se não for venda é cadastrado um novo animal
                        $animal = new Animal();
                        $animal->brinco = $row[$request->input('brinco')];
                        $animal->nome = "Boi " . $request['brinco'];
                        $animal->id_fornecedor = $manejo->fornecedor_id;
                        $animal->save();

                        //define a origem de compra no historico
                        $historico->origem = "Compra_Imp";
                    }
                    if (isset($animal)) {
                        // verefica se existe o lote se não existe cadastro um novo
                        $colunaLote = $request->input('lote');
                        if (isset($colunaLote)) {
                            $lote = Lote::where('nome', '=', $row[$colunaLote])->first();
                            $lote = is_null($lote) ? new Lote() : $lote;
                            $lote->nome = $row[$colunaLote];
                            $lote->racao = 'Ração Padrão';
                            $lote->consumodia = '1';
                            $lote->valorkg = '1';
                            $lote->save();
                            //animal recebe o lote cadastrado
                            $animal->id_lote = $lote->id;
                        }

                        // verefica se existe o raca se não existe cadastro uma nova
                        $colunaRaca = $request->input('raca');
                        if (isset($colunaRaca)) {
                            $raca = Raca::where('nome', '=', $row[$colunaRaca])->first();
                            $raca = is_null($raca) ? new Raca() : $raca;
                            $raca->nome = $row[$colunaRaca];
                            $raca->save();
                            $animal->id_raca = $raca->id;
                        }

                        //Gera pesagem do Animal
                        $pesagem = new Pesagem();
                        $pesagem->data = $manejo->data;
                        $pesagem->peso = $row[$request->input('peso')];
                        $pesagem->animal_id = $animal->id;
                        $pesagem->save();

                        //conclui gravação do historico
                        $historico->id_lote = $lote->id;
                        $historico->data = $manejo->data;
                        $historico->id_animal = $animal->id;
                        $historico->id_pesagem = $pesagem->id;
                        $historico->save();

                        //Gera Manejo do animal
                        $manejoAnimal = new  ManejoAnimais();
                        $manejoAnimal->animal_id = $animal->id;
                        $manejoAnimal->pesagem_id = $pesagem->id;
                        $manejoAnimal->manejo_id = $manejo->id;
                        $manejoAnimal->valor = $manejo->valorkg * $pesagem->peso;
                        $manejoAnimal->save();

                        $animal->save();
                    }
                }
            }
            DB::commit();
            return array(true, 'Importação Realizada com Sucesso');
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollBack();
            return array(true, 'Ocorreu um erro: ' . $exception->getMessage());
        }

    }

    public function findManejoByAnimal($animal, $tipo)
    {
        return Manejo::join('manejos_animais', 'manejos.id', '=', 'manejos_animais.manejo_id')
            ->where('animal_id', '=', $animal->id)
            ->where('tipo', '=', $tipo)->first();
    }

    public function findVendaByAnimal($animal)
    {
    }
}
