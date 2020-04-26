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
                        <a href="{{route('relatorios.financeiro_pagar.excel' , ['documento'=>$documento ,'categoria'=>$categoria , 'fornecedor'=>$fornecedor ,'vencini'=>$vencini ,'vencfin'=>$vencfin , 'pgtoini'=>$pgtoini ,'pgtofin'=>$pgtofin ,'lctoini'=>$lctoini , 'lctofin'=>$lctofin ])}}"
                           class="btn green right">Baixar Excel</a>
                    </div>
                    <span class="card-title">Pendências Financeiras a Receber</span>
                    <table>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Doc</th>
                            <th>Lançamento</th>
                            <th>Conta</th>
                            <th>Categoria</th>
                            <th>Fornecedor</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($dados))
                            <?php $i = 1; $end = end($dados); $total = 0?>

                            @foreach($dados as $dado)
                                <tr class="{{$i % 2 == 0 ? "blue lighten-4" : ""  }}">
                                    <td>{{$i}}</td>
                                    <td>{{$dado->numero_documento}}</td>
                                    <td>{{date('d/m/Y',strtotime($dado->created_at))}}</td>
                                    <td>{{$dado->conta_corrente}}</td>
                                    <td>{{$dado->categoria}}</td>
                                    <td>{{$dado->fornecedor}}</td>
                                    <td>R$ {{$dado->valor}}</td>
                                    <td>{{date('d/m/Y',strtotime($dado->data_vencimento))}}</td>
                                    @if(isset($dado->data_pagamento))
                                        <td  style="color: #0f9d58">{{date('d/m/Y',strtotime($dado->data_pagamento))}}</td>
                                    @else
                                        <td style="color: #9f191f">Pendente</td>
                                    @endif
                                </tr>
                                <?php $i = $i + 1; $total = $total + $dado->valor?>
                                @if($end == $dado)
                                    <tr class="blue lighten-1" }}">
                                    <td colspan="4" style='font-weight:bold; text-align: left'> Total de Lançamentos
                                        Relacionados: {{$i -1}}</td>
                                    <td colspan="5" style='font-weight:bold; text-align: end'> Valor Total:
                                        R${{$total}}</td>
                                    </tr>
                                @endif
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
