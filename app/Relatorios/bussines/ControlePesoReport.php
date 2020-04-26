<?php


namespace App\Relatorios\bussines;


use App\Relatorios\models\GanhoMedioDiario;

class ControlePesoReport
{
    public function ganhoMedioDiario($pesos){
        $relatorio = array();
        $pesoAnterior = 0;
        $dataAnteior = 0;
        $index = 0;
        foreach ($pesos as $peso) {
            try{
                if ($index != 0) {
                    $ganhoMedioDiario = new GanhoMedioDiario();
                    $ganhoMedioDiario->dias = $this->difenrecaDias($dataAnteior, $peso->data);
                    $ganhoMedioDiario->data = $peso->data;
                    $ganhoMedioDiario->ganhoPeso = $peso->peso - $pesoAnterior;
                    $ganhoMedioDiario->gmd = ($peso->peso - $pesoAnterior ) / $this->difenrecaDias($dataAnteior, $peso->data);
                    $ganhoMedioDiario->brinco = $peso->brinco;
                    $ganhoMedioDiario->peso = $peso->peso;
                    array_push($relatorio, $ganhoMedioDiario);
                }else{
                    $ganhoMedioDiario = new GanhoMedioDiario();
                    $ganhoMedioDiario->dias = 0;
                    $ganhoMedioDiario->data = $peso->data;
                    $ganhoMedioDiario->ganhoPeso = $peso->peso - $pesoAnterior;
                    $ganhoMedioDiario->gmd = ($peso->peso - $pesoAnterior );
                    $ganhoMedioDiario->brinco = $peso->brinco;
                    $ganhoMedioDiario->peso = $peso->peso;
                    array_push($relatorio, $ganhoMedioDiario);
                }
                $index++;
                $pesoAnterior = $peso->peso;
                $dataAnteior = $peso->data;
            }catch (\Exception $e){

            }

        }

        return $relatorio;
    }

    private function difenrecaDias($data_inicial, $data_final)
    {
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        return floor($diferenca / (60 * 60 * 24));
    }
}