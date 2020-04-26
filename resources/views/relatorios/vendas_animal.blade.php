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
                        <a href="{{route('relatorios.vendas_Animal.excel' , ['animais'=>$stringAnimais ,'racas'=>$stringRacas , 'clientes'=>$stringClientes ,'dataini'=>$dataini , 'datafim'=>$datafim])}}"
                           class="btn green right">Baixar Excel</a>
                    </div>
                    <span class="card-title">Vendas de Animais</span>
                    <table>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Raça</th>
                            <th>Brinco</th>
                            <th>Valor KG</th>
                            <th>Peso</th>
                            <th>Total</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($dados))
                            <?php $i = 1; $end = end($dados); $total = 0?>

                            @foreach($dados as $dado)
                                <tr class="{{$dado->brinco % 2 == 0 ? "blue lighten-4" : ""  }}">
                                    <td>{{$i}}</td>
                                    <td>{{date('d/m/Y',strtotime($dado->data))}}</td>
                                    <td>{{$dado->cliente}}</td>
                                    <td>{{$dado->raca}}</td>
                                    <td>
                                        <a href="{{route('animal.showFormAnimalForEdit', $dado->animal_id)}}"
                                           target="_blank">{{$dado->brinco}}</a>
                                    </td>
                                    <td>R$ {{$dado->valorkg}}</td>
                                    <td>{{$dado->peso}}</td>
                                    <td>R$ {{$dado->valor}}</td>
                                </tr>
                                <?php $i = $i + 1; $total = $total + $dado->valor?>
                                @if($end == $dado)
                                    <tr class="blue lighten-1"}}">
                                        <td colspan="4" style='font-weight:bold; text-align: left'> Total de Animais Relacionados: {{$i -1}}</td>
                                        <td colspan="4" style='font-weight:bold; text-align: end'> Valor Total: R${{$total}}</td>
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
