<?php

namespace App\Repository;

use App\Animal;
use App\Custo;
use App\Custo_Animal;
use App\HistoricoLotes;
use App\ManejoAnimais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustosBaixasRepository
{

    public function findAll($request)
    {
        return Custo::
            where('tipo', '=', 'baixas')
            ->orderBy('data', 'desc')
            ->paginate(25);
    }

    public function save(Request $request)
    {
        $animal_concatenar = $this->animal($request->animal); #identifica o animal

        #compra do animal.
        $compra = HistoricoLotes::join('manejos_animais', 'id_animal', '=', 'animal_id')
            ->join('pesagens', 'pesagens.id', '=', 'id_pesagem')
            ->join('lotes', 'id_lote', '=', 'lotes.id')
            ->where('origem', '=', 'Compra')
            ->where('id_animal', '=', $animal_concatenar->id)
            ->select('valor', 'historicos_lotes.data', 'valorkg', 'consumodia')
            ->first();

        #valores gastos com alimentação do animal.
        $pesagens = HistoricoLotes::join('pesagens', 'pesagens.id', '=', 'id_pesagem')
            ->join('lotes', 'id_lote', '=', 'lotes.id')
            ->where('origem', '=', 'Pesagem')
            ->where('id_animal', '=', $animal_concatenar->id)
            ->get();

        $qtdDias       = 0;
        $lastHistorico = $compra;
        $total         = 0;
        $valor_total   = 0;
        
        foreach ($pesagens as $pesagem) {
            if($lastHistorico <> null){
            $diferenca = strtotime($pesagem->data) - strtotime($lastHistorico->data);
            $qtdDias   = floor($diferenca / (60 * 60 * 24));
            //$qtdDias = $qtdDias == 0 ? 1 : $qtdDias;
            $total       = ($lastHistorico->valorkg * $lastHistorico->consumodia) * $qtdDias;
            $valor_total = $valor_total + $total;
            }
            $lastHistorico = $pesagem;
        }

        #valores de custos com animais.
        $valor_custos = Custo_Animal::where('id_animais', '=', $animal_concatenar->id)
            ->sum('valor');

        #animais comprados junto com o animal baixado.
        $animais_comprados = ManejoAnimais::where('manejo_id', '=', $animal_concatenar->id_manejo_compra)
            ->where('animal_id', '<>', $animal_concatenar->id)
            ->select('animal_id')
            ->get();

            #total de custos+alimentação+valor de compra
        $total_custos = $valor_custos + $valor_total + isset($compra->valor);

        #inclusão de custo
        $custo              = new Custo();
        $custo->tipo        = 'Baixas';
        $custo->titulo      = 'Baixa animal ' . $animal_concatenar->brinco;
        $custo->descricao   = 'Animal "' . $animal_concatenar->nome . '" baixado com um custo total de R$' . $total_custos . '. Sendo estes referente a R$ ' . isset($compra->valor) . ' de compra, R$' . $valor_total . ' de alimentação, e R$' . $valor_custos . ' de outros custos agregados.';
        $custo->valor_total = $total_custos;
        $custo->data        = $request->data;
        $custo->save();

        #inclusão de custo por animal
        $seq=$this->dividecusto($total_custos, $animais_comprados,$custo);

        #alteração de status de animal baixado.
        $animal = Animal::find($animal_concatenar->id);
        $animal->id_tipobaixa = $request->baixa;
        $animal->save();

        $custo2 = Custo::find($custo->id);
        $custo2->qtd_animais = $seq;
        $custo2->save();


    }

    public function dividecusto($total_custos, $animais_comprados,$custo)
    {

        $countanimais = count($animais_comprados);
        $valoranimal  = $total_custos / $countanimais;

        
        $seq = 0;
        foreach ($animais_comprados as $animal) {
            $seq = $seq + 1;
            
            $custoanimal             = new Custo_Animal();
            $custoanimal->valor      = $valoranimal;
            $custoanimal->sequencia  = $seq;
            $custoanimal->id_animais = $animal->animal_id;
            $custoanimal->id_custos  = $custo->id;
            $custoanimal->save();
        }

        return $seq;
    }

    public function delete($id)
    {
        $custo = Custo::find($id);

        $animal = Animal::find($custo->id_animais);
        $animal->id_tipobaixa = null;
        $animal->save();

        
        Custo::destroy($id);


    }

    public function findManejoByAnimal($animal, $tipo)
    {
        return Manejo::join('manejos_animais', 'manejos.id', '=', 'manejos_animais.manejo_id')
            ->where('animal_id', '=', $animal->id)
            ->where('tipo', '=', $tipo)->first();
    }

    public function animal($req)
    {
        $animais = DB::select("select * , concat('Brinco: ',brinco,' - ',nome) as concatenar from animais ");

        foreach ($animais as $ani) {
            if ($ani->concatenar == $req) {
                $animal_concatenar = $ani;
                break;
            }
        }

        return $animal_concatenar;
    }
}
