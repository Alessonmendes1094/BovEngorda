@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="col s12">
                        <a href="{{route('relatorios.index')}}" class="waves-effect waves-light btn deep-blue">Voltar
                            <i class="material-icons right">reply</i>
                        </a>
                        <a href="{{route('relatorios.custo_Animal.excel',  ['animais'=>$stringAnimais ,'racas'=>$stringRacas , 'fornecedores'=>$stringFornecedores])}}"
                           class="btn green right">Baixar Excel</a>
                    </div>
                    <span class="card-title">Custo por Animal</span>
                    <table>
                        <thead>
                        <tr>
                            <th>Brinco</th>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Lote</th>
                            <th>Peso</th>
                            <th>Tipo</th>
                            <th>Consumo</th>
                            <th>Valor</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($dados))
                            <?php $qtdDias = 0; $lastHistorico = null; $total = 0; $next = null; $keys = array_keys($dados);
                            $num_keys = count($keys); $i = 1; $compra = 0; $venda = 0; $pesagem = 0?>

                            @foreach($dados as $dado)
                                <tr class="{{$dado->brinco % 2 == 0 ? "blue lighten-4" : ""  }}">
                                    <td>
                                        <a href="{{route('animal.showFormAnimalForEdit', $dado->animal_id)}}"
                                           target="_blank">{{$dado->brinco}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('animal.showFormAnimalForEdit', $dado->animal_id)}}"
                                           target="_blank">{{$dado->nome}}</a>
                                    </td>
                                    <td>{{date('d/m/Y',strtotime($dado->data_pesagem))}}</td>
                                    <td>{{$dado->lote_id}} - {{$dado->lote_nome}}</td>
                                    <td>{{$dado->peso}} Kg</td>
                                    @if( $dado->tipo == 'compra')
                                        <td class="red-text">{{$dado->tipo}}</td>
                                        <td class="red-text"><strong>0 Kg</strong></td>
                                        <td class="red-text"><strong>R$ -{{$dado->manejo_valor}}</strong></td>
                                        <?php $compra = $dado->manejo_valor ?>
                                    @elseif($dado->tipo == 'venda')
                                        <td class="green-text">{{$dado->tipo}}</td>
                                        <td class="green-text"><strong>0 Kg</strong></td>
                                        <td class="green-text"><strong>R${{$dado->manejo_valor}}</strong></td>
                                        <?php $venda = $dado->manejo_valor ?>
                                    @else
                                        @if(isset($lastHistorico))
                                            <td class="orange-text">Pesagem</td>
                                            <?php
                                            $diferenca = strtotime($dado->data_pesagem) - strtotime($lastHistorico->data_pesagem);
                                            $qtdDias = floor($diferenca / (60 * 60 * 24));
                                            $qtdDias = $qtdDias == 0 ? 1 : $qtdDias;
                                            $total = ($lastHistorico->valorkg * $lastHistorico->consumodia) * $qtdDias;
                                            $pesagem = $pesagem + $total
                                            ?>
                                            <td class="orange-text">{{$lastHistorico->consumodia * $qtdDias}} Kg</td>
                                            <td class="orange-text">R$
                                                -{{($lastHistorico->valorkg * $lastHistorico->consumodia) * $qtdDias}}</td>
                                        @endif
                                    @endif
                                    <?php $lastHistorico = $dado?>
                                </tr>
                                @if (($i < $num_keys && $dados[$keys[$i]]->brinco != $dado->brinco) || ($i == $num_keys))
                                    <td colspan="4" class="red-text">Custos (Compra R$ {{$compra}} , Alimentação
                                        R$ {{$pesagem}}) -> <strong>Total R${{$compra + $pesagem}}</strong></td>
                                    <td colspan="2" class="orange-text">Peso Mín - {{$dado->peso_min}}Kg / Peso Máx
                                        - {{$dado->peso_max}}Kg -> <strong>Ganho {{$dado->peso_max - $dado->peso_min}}
                                            Kg</strong></td>
                                    <td colspan="3" class="green-text">Valor Liquido (Venda R$ {{$venda}} - Custos
                                        R$ {{$compra + $pesagem}}) -><strong> Total
                                            R${{$venda - ($compra + $pesagem)}}</strong></td>
                                    <?php $compra = 0; $venda = 0; $pesagem = 0?>
                                @endif
                                <?php $i++;?>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
