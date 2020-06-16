<?php

namespace App\Repository;

use App\Animal;
use App\HistoricoLotes;
use App\Lote;
use App\Manejo;
use App\ManejoAnimais;
use App\Pesagem;
use App\Raca;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraRepository
{

    public function findAllManejosResumo($request)
    {

        return Manejo::
            leftjoin('manejos_animais', 'manejos_animais.manejo_id', '=', 'manejos.id')
            ->leftjoin('fornecedores', 'fornecedores.id', '=', 'manejos.fornecedor_id')
            ->leftjoin('pesagens','pesagem_id','=','pesagens.id')
            ->select('manejos.id', 'fornecedores.nome as fornecedor', 'manejos.data', 'tipo', DB::raw('count(manejos_animais.animal_id) as qtdAnimais'), 'valorkg' , DB::raw('sum(peso) as total_peso'))
            ->where($this->buildFiltro($request))
            ->where('tipo', '=', 'compra')
            ->groupBy('manejos.id', 'fornecedores.nome', 'manejos.data', 'tipo')
            ->orderBy('data', 'desc')
            ->paginate(25);
    }

    public function save(Request $request)
    {
        $manejo = Manejo::find($request->input('id'));
        if (!isset($manejo)) {
            $manejo = new Manejo();
        }else if(isset($manejo)){
            $editar = 'true';
        }

        $manejo->data          = $request->input('data');
        $manejo->tipo          = 'compra';
        $manejo->fornecedor_id = $request->input('fornecedor');
        $manejo->valorkg       = $request->input('valor');
        $manejo->save();

        if(isset($editar)){
            $this->calculaPreco($manejo);
        }

        return $manejo;
    }

    public function saveanimais($animal, $manejo)
    {
        $newanimal                = new Animal();
        $newanimal->brinco        = $animal->brinco;
        $newanimal->nome          = "Boi " . $animal->brinco;
        $newanimal->sexo          = $animal->sexo;
        $newanimal->id_fornecedor = $manejo->fornecedor_id;
        $newanimal->id_raca       = $animal->raca;

        #calcula o lote do animal
        $lote = Lote::where('peso_inicial', '<=', $animal->peso)->where('peso_final', '>=', $animal->peso)->first();
        #verifica se o peso informado pertence a algum lote
        if (!isset($lote)) {
            Session::flash('erro', 'Não Encontrado Lote com o peso informado! Verifique o peso, ou cadastro de lotes');
            return route('compra.novoanimal', $manejo->id);
        }
        
        $newanimal->id_lote          = $lote->id;
        $newanimal->id_manejo_compra = $manejo->id;
        $newanimal->save();

        return $newanimal;

    }

    private function deleteManejoAnimais(Manejo $manejo)
    {
        ManejoAnimais::where('manejo_id', '=', $manejo->id)->delete();
    }

    public function saveManejoAnimais($animal, $id)
    {
        //busca manejo
        $manejo = Manejo::find($id);

        //inicializa variavel historico
        $historico         = new HistoricoLotes();
        $historico->origem = "Compra";

        //salva Animais
        $animalSaved = $this->saveAnimais($animal, $manejo);

        //grava dados na variavel historico
        $historico->id_lote = $animalSaved->id_lote;

        //grava pesagem que ficará vinculada ao manejo de venda
        $pesagemSaved = $this->savePesagem($animal, $manejo, $animalSaved);

        //termina inclusão da variavel historico e salva na base.
        $historico->data       = $manejo->data;
        $historico->id_animal  = $animalSaved->id;
        $historico->id_pesagem = $pesagemSaved->id;
        $historico->save();

        //cria manejo do animal vinculando a variavel $pesagemSaved.
        $manejoAnimal             = new ManejoAnimais();
        $manejoAnimal->animal_id  = $animalSaved->id;
        $manejoAnimal->pesagem_id = $pesagemSaved->id;
        $manejoAnimal->manejo_id  = $manejo->id;
        $manejoAnimal->valor      = 0;
        $manejoAnimal->save();

        #calcula a qtd de animais e divide o preço total.
        $this->calculaPreco($manejo);

    }

    public function calculaPreco( $manejo){
        $qtd = ManejoAnimais::join('pesagens','pesagens.id','=','pesagem_id')
        ->where('manejo_id','=',$manejo->id)->sum('peso');

        $manejos = ManejoAnimais::join('pesagens','pesagens.id','=','manejos_animais.pesagem_id')
        ->where('manejo_id','=',$manejo->id)->select('manejos_animais.id','pesagens.peso')->get();

        $value = $manejo->valorkg / $qtd; #calcula o valor do KG, porém o valor fica vom inumerar casas decimais
        
        $valor = floor($value*pow(10,4)+0.2)/pow(10,4); #arrenda o valor para 2 casas decimais
        
        
        //dd($manejos, $qtd);
        foreach ($manejos as $man){
            $manejo_animal = ManejoAnimais::find($man->id);
            $valor_kg = $valor * $man->peso;            
            $manejo_animal->valor = $valor_kg;
            $manejo_animal->save();

            //dd($manejo,$qtd,$value,$valor,$man,$valor_kg,$manejo_animal);
        }
    }

    private function savePesagem($request, $manejo, $animalSaved)
    {
        $pesagem            = new Pesagem();
        $pesagem->data      = $manejo->data;
        $pesagem->peso      = $request['peso'];
        $pesagem->animal_id = $animalSaved->id;
        $pesagem->save();
        return $pesagem;
    }

    public function delete($id)
    {
        Manejo::destroy($id);
    }

    private function buildFiltro($request)
    {
        $filtro   = array();
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
            $manejo                = new Manejo();
            $manejo->fornecedor_id = $manejoForm->fornecedor_id;
            $manejo->data          = $manejoForm->data;
            $manejo->tipo          = $manejoForm->tipo;
            $manejo->valorkg       = $manejoForm->valorkg;
            $manejo->save();

            foreach ($dados as $row) {
                if (count($row) > 0) {
                    //Inicializa variavel Historico
                    $historico = new HistoricoLotes();

                    //se não for venda é cadastrado um novo animal
                    $animal                = new Animal();
                    $animal->brinco        = $row[$request->input('brinco')];
                    $animal->nome          = "Boi " . $request['brinco'];
                    $animal->id_fornecedor = $manejo->fornecedor_id;
                    $animal->save();

                    //define a origem de compra no historico
                    $historico->origem = "Compra_Imp";

                    if (isset($animal)) {
                        // verefica se existe o lote se não existe cadastro um novo
                        $colunaLote = Lote::where('peso_inicial', '<=', $row[$request->input('peso')])->where('peso_final', '>=', $row[$request->input('peso')])->first();
                        if (isset($colunaLote)) {
                            $lote             = Lote::where('id', '=', $colunaLote->id)->first();
                            $lote             = is_null($lote) ? new Lote() : $lote;
                            $lote->nome       = 'lote criado por importação';
                            $lote->racao      = 'Ração Padrão';
                            $lote->consumodia = '1';
                            $lote->valorkg    = '1';
                            $lote->save();
                            //animal recebe o lote cadastrado
                            $animal->id_lote = $lote->id;
                        }

                        // verefica se existe o raca se não existe cadastro uma nova
                        $colunaRaca = $request->input('raca');
                        if (isset($colunaRaca)) {
                            $raca       = Raca::where('nome', '=', $row[$colunaRaca])->first();
                            $raca       = is_null($raca) ? new Raca() : $raca;
                            $raca->nome = $row[$colunaRaca];
                            $raca->save();
                            $animal->id_raca = $raca->id;
                        }

                        //Gera pesagem do Animal
                        $pesagem            = new Pesagem();
                        $pesagem->data      = $manejo->data;
                        $pesagem->peso      = $row[$request->input('peso')];
                        $pesagem->animal_id = $animal->id;
                        $pesagem->save();

                        //conclui gravação do historico
                        $historico->id_lote    = $lote->id;
                        $historico->data       = $manejo->data;
                        $historico->id_animal  = $animal->id;
                        $historico->id_pesagem = $pesagem->id;
                        $historico->save();

                        //Gera Manejo do animal
                        $manejoAnimal             = new ManejoAnimais();
                        $manejoAnimal->animal_id  = $animal->id;
                        $manejoAnimal->pesagem_id = $pesagem->id;
                        $manejoAnimal->manejo_id  = $manejo->id;
                        $manejoAnimal->valor      = $manejo->valorkg * $pesagem->peso;
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

}
