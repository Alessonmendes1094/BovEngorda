<?php

namespace App\Repository;

use App\Animal;
use App\HistoricoLotes;
use App\Lote;
use App\Pesagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PesagemRepository
{

    public function findAll($request)
    {
        return Pesagem::select('pesagens.animal_id', 'pesagens.data', 'pesagens.peso', 'pesagens.id as pesagen_id', 'animais.brinco', 'racas.nome as raca', 'lotes.nome as lote')
            ->where($this->buildFiltro($request))
            ->join('animais', 'pesagens.animal_id', '=', 'animais.id')
            ->leftJoin('racas', 'animais.id_raca', '=', 'racas.id')
            ->leftJoin('lotes', 'animais.id_lote', '=', 'lotes.id')
            ->orderByRaw('pesagens.animal_id, pesagens.data')
            ->paginate(150);
    }

    public function salvar(Request $request)
    {
        $req               = $request->all();
        $animal_concatenar = $this->animal($request);

        if($animal_concatenar == null){
            $mensagem[0] = 'erro';
            $mensagem[1] = 'Brinco não cadastrado!';
            return $mensagem;
        }

        $peso = $req['peso'];
        $lote = Lote::where('peso_inicial', '<=', $peso)->where('peso_final', '>=', $peso)->first();
        #verifica se o peso informado pertence a algum lote
        if (!isset($lote)) {
            $mensagem[0] = 'erro';
            $mensagem[1] = 'Não Encontrado Lote com o peso informado! Verifique o peso, ou cadastro de lotes';
            return $mensagem;
        }

        #gera nova pesagem do animal
        $pesagem            = new Pesagem();
        $pesagem->data      = $req['data'];
        $pesagem->peso      = $req['peso'];
        $pesagem->animal_id = $animal_concatenar->id;
        $pesagem->save();

        #gera um historio da pesagem
        $historicoLote = new HistoricoLotes();

        $animal = Animal::find($animal_concatenar->id);

        #verifica se o lote do animal é diferente do lote que o peso do animal se enquadra
        if ($lote->id != $animal_concatenar->id_lote) {
            $animal->id_lote = $lote->id;
            $animal->save();
            $historicoLote->lote_alterado = "S";
        }
        #continua o processo de gravação do historico do lote
        $historicoLote->data       = $req['data'];
        $historicoLote->id_lote    = $animal->id_lote;
        $historicoLote->id_animal  = $animal->id;
        $historicoLote->origem     = "Pesagem";
        $historicoLote->id_pesagem = $pesagem->id;
        $historicoLote->save();

        $mensagem[0] = 'status';
        $mensagem[1] = 'Pesagem do brinco ' . $animal->brinco . ' salva com sucesso!';
        return $mensagem;

    }

    public function gmdChart($idAnimal)
    {
        $pesos = Pesagem::where('animal_id', '=', $idAnimal)->orderByRaw('animal_id, data')->get();
        $gmds  = $this->getGMD($pesos);
        $datas = $this->getDatas($pesos);
//        $pessagens = $this->getPesos($pesos);

        return array($gmds, $datas);
    }

    public function getGMD($pesos)
    {
        $gmds         = array();
        $pesoAnterior = 0;
        $dataAnteior  = 0;
        foreach ($pesos as $peso) {
            try {
                $gmd = ($peso->peso - $pesoAnterior) / $this->difenrecaDias($dataAnteior, $peso->data);
                array_push($gmds, $gmd);
                $pesoAnterior = $peso->peso;
                $dataAnteior  = $peso->data;
            } catch (\Exception $e) {

            }

        }
        return $gmds;
    }

    private function difenrecaDias($data_inicial, $data_final)
    {
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        $diferenca = $diferenca == 0 ? 1 : $diferenca;
        return floor($diferenca / (60 * 60 * 24));
    }

    private function getDatas($pesos)
    {
        $datas = array();
        foreach ($pesos as $peso) {
            $data = date('d/m/Y', strtotime($peso->data));
            array_push($datas, $data);
        }
        return $datas;
    }

    public function deleteById($id)
    {
        Pesagem::destroy($id);
    }

    public function importByPlanilha($dados, Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($dados as $row) {
                $animal = Animal::where('brinco', '=', $row[$request->input('brinco')])->first();

                if (isset($animal)) {
                    $pesgem            = new Pesagem();
                    $pesgem->animal_id = $animal->id;
                    $pesgem->peso      = $row[$request->input('peso')];
                    $pesgem->data      = Date::excelToDateTimeObject($row[$request->input('data')]);

                    // verefica se existe o lote se não existe cadastro um novo
                    $colunaLote = $request->input('lote');
                    if (isset($colunaLote)) {
                        $lote       = Lote::where('nome', '=', $row[$colunaLote])->first();
                        $lote       = is_null($lote) ? new Lote() : $lote;
                        $lote->nome = $row[$colunaLote];
                        $lote->save();

                        $animal->id_lote = $lote->id;
                    }

                    $animal->save();
                    $pesgem->save();

                    $historicoLote             = new HistoricoLotes();
                    $historicoLote->data       = $pesgem->data;
                    $historicoLote->id_lote    = $lote->id;
                    $historicoLote->id_animal  = $animal->id;
                    $historicoLote->origem     = "Pesagem_Imp";
                    $historicoLote->id_pesagem = $pesgem->id;
                    if ($lote->id != $animal->id_lote) {
                        $historicoLote->lote_alterado = "S";
                    }
                    $historicoLote->save();
                }

            }
            DB::commit();
            return array(true, 'Importação Realizada com Sucesso');
        } catch (\Exception $exception) {
            DB::rollBack();
            return array(true, 'Ocorreu um erro: ' . $exception->getMessage());
        }
    }

    private function getPesos($pesos)
    {
        $pessagens = array();
        foreach ($pesos as $peso) {
            array_push($pessagens, $peso->peso);
        }
        return $pessagens;
    }

    private function buildFiltro(Request $request)
    {
        $filtro = array();
        $brinco = $request->input("brinco");
        if (isset($brinco)) {
            array_push($filtro, ['animais.brinco', 'like', '%' . $brinco . '%']);
        }
        $lote = $request->input("lote");
        if (isset($lote)) {
            array_push($filtro, ['animais.id_lote', '=', $lote]);
        }
        $raca = $request->input("raca");
        if (isset($raca)) {
            array_push($filtro, ['animais.id_raca', '=', $raca]);
        }
        $sexo = $request->input("sexo");
        if (isset($sexo)) {
            array_push($filtro, ['animais.sexo', '=', $sexo]);
        }

        return $filtro;
    }

    public function animal(Request $req)
    {
        $this->validaAnimalPeso($req);
        $this->validaPeso($req);

        $animal_concatenar = Animal::where('brinco', '=', $req->animal)->first();

        
        if ($animal_concatenar == null) {
            $animais = DB::select("select * , concat('Brinco: ',brinco,' - ',nome) as concatenar from animais ");

            foreach ($animais as $ani) {
                if ($ani->concatenar == $req->animal) {
                    $animal_concatenar = $ani;
                    break;
                }
            }
        }

        
        return $animal_concatenar;
    }

    public function validaAnimalPeso(Request $request)
    {
        $dosagem = $request->all();
        $valid   = [
            'animal' => 'required',
        ];
        $messages = [
            'required' => 'O campo é de preenchimento obrigatório!',
            'min'      => 'Animal não informado. Verifique!',
            'max'      => 'Animal não informado. Verifique!',
        ];

        $validacao = Validator($dosagem, $valid, $messages)->validate();

    }

    public function validaPeso(Request $request)
    {
        $dosagem = $request->all();
        $valid   = [
            'peso' => 'required|numeric|min:10|max:2000',
        ];
        $messages = [
            'required' => 'O campo é de preenchimento obrigatório!',
            'min'      => 'Peso incorreto! Peso mínimo 10 Kg',
            'max'      => 'Peso incorreto! Peso máximo 2000 Kg',
        ];

        $validacao = Validator($dosagem, $valid, $messages)->validate();

    }
}
