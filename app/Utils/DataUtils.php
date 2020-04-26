<?php


namespace App\Utils;


class DataUtils
{
    private function difenrecaDias($data_inicial, $data_final)
    {
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        return floor($diferenca / (60 * 60 * 24));
    }


}
