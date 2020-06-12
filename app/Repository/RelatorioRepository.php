<?php


namespace App\Repository;


use Illuminate\Support\Facades\DB;

class RelatorioRepository
{

    public function gmdAnimal($stringAnimais, $stringRacas, $stringFornecedores,$compraFornecedor)
    {
        $animais = '';
        $racas = '';
        $fornecedores = '';

        if ($stringAnimais <> 'Todo$') {
            $animais = 'and animais.id in (' . $stringAnimais . ')';
        }

        if ($stringRacas <> 'Todo$') {
            $racas = 'and animais.id_raca in (' . $stringRacas . ')';
        }

        if ($stringFornecedores <> 'Todo$') {
            $fornecedores = 'and fornecedores.id in (' . $stringFornecedores . ')';
        }

        return DB::select('select pes.animal_id,
                                       animais.brinco,
                                       fornecedores.nome as fornecedor,
                                       racas.nome as raca,
                                       pes.data,
                                       pes.peso,
                                       (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id) as data_anterior,
                                       DATEDIFF(pes.data, (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id)) as dif_dias,
                                       pes.peso - (select aux.peso from pesagens as aux where aux.animal_id = pes.animal_id and aux.data =
                                            (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id))	 as diff_peso
                                    from pesagens as pes
                                 inner join animais on pes.animal_id = animais.id
                                 left join fornecedores on fornecedores.id = animais.id_fornecedor
                                 left join racas on racas.id = animais.id_raca
                                 where animais.id_tipobaixa is null and id_manejo_compra = '.$compraFornecedor . '
                                 ' . $animais . ' ' . $racas . ' ' . $fornecedores . '
                                 order by pes.animal_id, pes.data;');

    }

    public function gmdAnimalBaixados($stringAnimais, $stringRacas, $stringFornecedores,$compraFornecedor)
    {
        $animais = '';
        $racas = '';
        $fornecedores = '';
        if ($stringAnimais <> 'Todo$') {
            $animais = 'and animais.id in (' . $stringAnimais . ')';
        }

        if ($stringRacas <> 'Todo$') {
            $racas = 'and animais.id_raca in (' . $stringRacas . ')';
        }

        if ($stringFornecedores <> 'Todo$') {
            $fornecedores = 'and fornecedores.id in (' . $stringFornecedores . ')';
        }


        return DB::select('select pes.animal_id,
                                       animais.brinco,
                                       fornecedores.nome as fornecedor,
                                       racas.nome as raca,
                                       pes.data,
                                       pes.peso,
                                       (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id) as data_anterior,
                                       DATEDIFF(pes.data, (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id)) as dif_dias,
                                       pes.peso - (select aux.peso from pesagens as aux where aux.animal_id = pes.animal_id and aux.data =
                                            (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id))	 as diff_peso
                                    from pesagens as pes
                                 inner join animais on pes.animal_id = animais.id
                                 left join fornecedores on fornecedores.id = animais.id_fornecedor
                                 left join racas on racas.id = animais.id_raca
                                 where animais.id_tipobaixa is not null and id_manejo_compra = '. $compraFornecedor.' 
                                 ' . $animais . ' ' . $racas . ' ' . $fornecedores . '
                                 order by pes.animal_id, pes.data;');

    }

    public function gmdRaca($stringRaca, $stringFornecedores)
    {
        return DB::select('select pes.animal_id,
                                       animais.brinco,
                                       fornecedores.nome as fornecedor,
                                       racas.nome as raca,
                                       pes.data,
                                       pes.peso,
                                       (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id) as data_anterior,
                                       DATEDIFF(pes.data, (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id)) as dif_dias,
                                       pes.peso - (select aux.peso from pesagens as aux where aux.animal_id = pes.animal_id and aux.data =
                                            (select max(sub.data) from pesagens as sub where sub.animal_id = pes.animal_id and sub.data < pes.data group by sub.animal_id))	 as diff_peso
                                    from pesagens as pes
                                 inner join animais on pes.animal_id = animais.id
                                 left join fornecedores on fornecedores.id = animais.id_fornecedor
                                 left join racas on racas.id = animais.id_raca
                                 where animais.id_tipobaixa is null
                                 and animais.id_raca in (' . $stringRaca .
            ')and fornecedores.id in (' . $stringFornecedores .
            ')order by pes.animal_id, pes.data;');

    }

    public function custo_animal($stringRacas, $stringAnimais, $stringFornecedores,$compraFornecedor)
    {
        $racas1 = '';
        $racas2 = '';
        $racas3 = '';
        if ($stringRacas <> 'Todo$') {
            $racas1 = 'where anim1.id_raca in (' . $stringRacas . ')';
            $racas2 = 'where anim2.id_raca in (' . $stringRacas . ')';
            $racas3 = 'where animais.id_raca in (' . $stringRacas . ')';
        }

        $animais1 = '';
        $animais2 = '';
        $animais3 = '';


        if (strlen($racas1) > 10) {
            $animais1 = 'and';
            $animais2 = 'and';
            $animais3 = 'and';
        } else if ($stringAnimais <> 'Todo$') {
            $animais1 = ' where';
            $animais2 = 'where ';
            $animais3 = 'where ';
        }

        if ($stringAnimais <> 'Todo$') {
            $animais1 = $animais1 . ' manejos_animais.animal_id in (' . $stringAnimais . ')';
            $animais2 = $animais2 . ' pes.animal_id in (' . $stringAnimais . ')';
            $animais3 = $animais3 . ' pesagens.animal_id in (' . $stringAnimais . ')';
        }

        if ($stringFornecedores <> 'Todo$') {
            $fornecedores = "inner join (SELECT ma.fornecedor_id, man_an.animal_id FROM bovengorda.manejos_animais as man_an
												inner join manejos as ma on man_an.manejo_id  = ma.id
												where ma.tipo = 'compra' and ma.fornecedor_id in (" . $stringFornecedores . ")) forn_compra on forn_compra.animal_id = pesagens.animal_id";
        } else {
            $fornecedores = '';
        }

        $consulta = 'select distinct animais.brinco,pesagens.id,peso_min,peso_max, animais.nome, animais.id_raca , racas.nome as raca_nome , animais.id_lote as animal_lote,lotes.valorkg, lotes.consumodia,lotes.id as lote_id , lotes.nome as lote_nome , man.* , pesagens.data as data_pesagem , historicos_lotes.id_lote as hist_lote , peso, pesagens.animal_id , origem
                                from pesagens
                                left join (SELECT
                                                man1.tipo , manejos_animais.valor as manejo_valor, pesagem_id, manejos_animais.id as manejos_an_id , manejo_id , man1.fornecedor_id , man1.cliente_id
                                            FROM bovengorda.manejos_animais
                                            inner join manejos as man1 on man1.id = manejos_animais.manejo_id
                                            inner join animais as anim1 on anim1.id = manejos_animais.animal_id
                                             ' . $racas1 . ' ' . $animais1 . ') man on man.pesagem_id = pesagens.id
                                inner join animais on animal_id = animais.id
                                inner join (select min(peso) as peso_min, max(peso) as peso_max , pes.animal_id
                                    from pesagens as pes
                                    inner join animais as anim2 on anim2.id = pes.animal_id
					                ' . $racas2 . ' ' . $animais2 . '
                                    group by pes.animal_id) as pesos on pesagens.animal_id = pesos.animal_id
                                left join historicos_lotes on historicos_lotes.id_animal = animais.id and historicos_lotes.data = pesagens.data
                                left join lotes on historicos_lotes.id_lote = lotes.id
                                inner join racas on racas.id = animais.id_raca
                                ' . $fornecedores . '
                                ' . $racas3 . ' ' . $animais3 . '
                                where id_manejo_compra = '.$compraFornecedor.'
                                order by brinco , data_pesagem, pesagens.id;  ';

        return DB::select($consulta);
    }

    public function compras_Animal($stringRacas, $stringAnimais, $stringFornecedores, $dataini , $datafim)
    {
        $inicio = '';
        $final = '';
        $racas = '';
        $animais = '';
        $fornecedores ='';

        if (strlen($dataini) > 6) {
            $inicio = 'and manejos.data >=  "' . $dataini . '"';
        }
        if (strlen($datafim) > 6) {
            $final = 'and manejos.data <= "' . $datafim . '"';
        }

        if ($stringRacas <> 'Todo$') {
            $racas = 'and animais.id_raca in ('.$stringRacas.')';
        }

        if ($stringAnimais <> 'Todo$') {
            $animais = ' and animais.id_raca in ('.$stringAnimais.')';
        }

        if ($stringFornecedores <> 'Todo$') {
            $fornecedores =' and fornecedores.id in ('.$stringFornecedores.')';
        }

        $consulta = "select manejos.id, manejos.data, tipo , manejos_animais.animal_id , brinco, fornecedores.nome as fornecedor , racas.nome as raca , valorkg , peso , valor   from manejos_animais
                        	inner join manejos on manejo_id = manejos.id
                        	inner join animais on animais.id = manejos_animais.animal_id
                        	inner join fornecedores on manejos.fornecedor_id = fornecedores.id
                        	inner join pesagens on pesagens.id = manejos_animais.pesagem_id
                        	inner join racas on racas.id = animais.id_raca
                        where  tipo = 'compra' ".
            $fornecedores . " " .
            $animais . " " .
            $racas . " " .
            $inicio . " " .
            $final . "
                        order by manejos.data , animais.id";

        return DB::select($consulta);
    }

    public function vendas_Animal($stringRacas, $stringAnimais, $stringClientes, $dataini , $datafim)
    {
        $inicio = '';
        $final = '';
        $racas = '';
        $animais = '';
        $clientes ='';

        if (strlen($dataini) > 6) {
            $inicio = 'and manejos.data >=  "' . $dataini . '"';
        }
        if (strlen($datafim) > 6) {
            $final = 'and manejos.data <= "' . $datafim . '"';
        }

        if ($stringRacas <> 'Todo$') {
            $racas = 'and animais.id_raca in ('.$stringRacas.')';
        }

        if ($stringAnimais <> 'Todo$') {
            $animais = ' and animais.id_raca in ('.$stringAnimais.')';
        }

        if ($stringClientes <> 'Todo$') {
            $clientes =' and clientes.id in ('.$stringClientes.')';
        }

        $consulta = "select manejos.id, manejos.data, tipo , manejos_animais.animal_id , brinco, clientes.nome as cliente , racas.nome as raca , valorkg , peso , valor   from manejos_animais
                        	inner join manejos on manejo_id = manejos.id
                        	inner join animais on animais.id = manejos_animais.animal_id
                        	inner join clientes on manejos.cliente_id = clientes.id
                        	inner join pesagens on pesagens.id = manejos_animais.pesagem_id
                        	inner join racas on racas.id = animais.id_raca
                        where  tipo = 'venda' ".
            $clientes . " " .
            $animais . " " .
            $racas . " " .
            $inicio . " " .
            $final . "
            order by manejos.data , animais.id";

        return DB::select($consulta);
    }

    public function financeiro_pagar($documento, $categoria, $fornecedor , $vencini , $vencfin ,$pgtoini  ,$pgtofin  ,$lctoini ,$lctofin)
    {
        $documentox = '';
        $categoriax = '';
        $fornecedorx = '';
        $vencinix = '';
        $vencfinx ='';
        $pgtoinix ='';
        $pgtofinx ='';
        $lctoinix ='';
        $lctofinx ='';

        if (strlen($documento) > 0) {
            $documentox = 'and numero_documento like  "%' . $documento . '%"';
        }
        if (strlen($categoria) > 0) {
            $categoriax = 'and categoria like  "%' . $categoria . '%"';
        }
        if (strlen($fornecedor) > 0) {
            $fornecedorx = 'and fornecedor like "%' . $fornecedor . '%"';
        }
        if (strlen($vencini) > 0) {
            $vencinix = 'and data_vencimento >= "' . $vencini . '"';
        }
        if (strlen($vencfin) > 0) {
            $vencfinx = 'and data_vencimento <=  "' . $vencfin . '"';
        }
        if (strlen($pgtoini) > 0) {
            $pgtoinix = 'and data_pagamento >= "' . $pgtoini . '"';
        }
        if (strlen($pgtofin) > 0) {
            $pgtofinx = 'and data_pagamento <= "' . $pgtofin . '"';
        }
        if (strlen($lctoini) > 0) {
            $lctoinix = 'and created_at >= "' . $lctoini . '"';
        }
        if (strlen($lctofin) > 0) {
            $lctofinx = 'and created_at <= "' . $lctofin . '"';
        }

        $consulta = "select * from operacoes_financeiras
                    where tipo_dc = 'debito' " .
            $documentox." " . $categoriax . " " . $fornecedorx . " " . $vencinix . " " .
            $vencfinx . " " . $pgtoinix . " " . $pgtofinx . " " . $lctoinix . " " . $lctofinx .
            " order by fornecedor , categoria, valor";
        return DB::select($consulta);
    }

    public function financeiro_receber($documento, $categoria, $fornecedor , $vencini , $vencfin ,$pgtoini  ,$pgtofin  ,$lctoini ,$lctofin)
    {
        $documentox = '';
        $categoriax = '';
        $fornecedorx = '';
        $vencinix = '';
        $vencfinx ='';
        $pgtoinix ='';
        $pgtofinx ='';
        $lctoinix ='';
        $lctofinx ='';

        if (strlen($documento) > 0) {
            $documentox = 'and numero_documento like  "%' . $documento . '%"';
        }
        if (strlen($categoria) > 0) {
            $categoriax = 'and categoria like  "%' . $categoria . '%"';
        }
        if (strlen($fornecedor) > 0) {
            $fornecedorx = 'and fornecedor like "%' . $fornecedor . '%"';
        }
        if (strlen($vencini) > 0) {
            $vencinix = 'and data_vencimento >= "' . $vencini . '"';
        }
        if (strlen($vencfin) > 0) {
            $vencfinx = 'and data_vencimento <=  "' . $vencfin . '"';
        }
        if (strlen($pgtoini) > 0) {
            $pgtoinix = 'and data_pagamento >= "' . $pgtoini . '"';
        }
        if (strlen($pgtofin) > 0) {
            $pgtofinx = 'and data_pagamento <= "' . $pgtofin . '"';
        }
        if (strlen($lctoini) > 0) {
            $lctoinix = 'and created_at >= "' . $lctoini . '"';
        }
        if (strlen($lctofin) > 0) {
            $lctofinx = 'and created_at <= "' . $lctofin . '"';
        }

        $consulta = "select * from operacoes_financeiras
                    where tipo_dc = 'credito' " .
            $documentox." " . $categoriax . " " . $fornecedorx . " " . $vencinix . " " .
            $vencfinx . " " . $pgtoinix . " " . $pgtofinx . " " . $lctoinix . " " . $lctofinx .
            " order by fornecedor , categoria, valor";
        return DB::select($consulta);
    }
}
