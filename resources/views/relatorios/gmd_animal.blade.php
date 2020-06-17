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
                        <a href="{{route('relatorios.gmdAnimal.excel' , ['animais'=>$stringAnimais ,'racas'=>$stringRacas,'lotes'=>$stringLotes , 'fornecedores'=>$stringFornecedores, 'compraFornecedor'=>$compraFornecedor])}}"
                           class="btn green right">Baixar Excel</a>
                    </div>
                    <span class="card-title">GMD por animal</span>
                    <table>
                        <thead>
                        <tr>
                            <th>Brinco</th>
                            <th>Fornecedor</th>
                            <th>Raça</th>
                            <th>Data</th>
                            <th>Peso</th>
                            <th>Dif. Dias</th>
                            <th>GMD</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(isset($dados))
                            @foreach($dados as $dado)
                                <tr class="{{$dado->brinco % 2 == 0 ? "blue lighten-4" : ""  }}">
                                    <td>
                                        <a href="{{route('animal.showFormAnimalForEdit', $dado->animal_id)}}"
                                           target="_blank">{{$dado->brinco}}</a>
                                    </td>
                                    <td>{{$dado->fornecedor}}</td>
                                    <td>{{$dado->raca}}</td>
                                    <td>{{date('d/m/Y',strtotime($dado->data))}}</td>
                                    <td>{{$dado->peso}}</td>
                                    <td>{{$dado->dif_dias}}</td>
                                    <td>
                                        @if(isset($dado->diff_peso) and isset($dado->dif_dias))
                                            {{number_format($dado->diff_peso / $dado->dif_dias, 2, ',', ' ')}}
                                        @endif
                                    </td>
                                </tr>
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
