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
                    <a href="{{route('relatorios.gmdAnimal.excel' , ['animais'=>$stringAnimais ,'racas'=>$stringRacas,'lotes'=>$stringLotes , 'fornecedores'=>$stringFornecedores, 'compraFornecedor'=>$compraFornecedor])}}" class="btn green right">Baixar Excel</a>
                </div>
                <span class="card-title">GMD por animal</span>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Brinco</th>
                            <th>Data</th>
                            <th>Peso</th>
                            <th>Dif. Dias</th>
                            <th>GMD</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(isset($dados))
                            <?php $animal = 0; $i=0; $cor=''; $compra = 0;?>
                            @foreach($dados as $dado)
                                @if($animal === 0 or $animal <> $dado->animal_id) <!-- verifica se é primeira linha OU animal diferente da linha anterior-->
                                    @if($animal <> 0 ) <!-- se animal diferente fecha a linha ocorrera somente após segunda linha, pois a linha nao é fechada até que gere todos os registros do mesmo animal-->
                                        </tr>                        
                                    @endif
                                    @if($compra <> $dado->id_manejo_compra)
                                        <tr class="grey">
                                            <td colspan="5"> Compra do fornecedor {{$dado->fornecedor}} do dia {{date('d/m/Y',strtotime($dado->data_compra))}} </td>
                                        </tr>                                        
                                        <?php $compra = $dado->id_manejo_compra;?>
                                    @endif
                                    <tr >
                                        <td>
                                            <a href="{{route('animal.showFormAnimalForEdit', $dado->animal_id)}}"
                                            target="_blank">{{$dado->brinco}}</a>
                                        </td>
                                        <?php $animal = $dado->animal_id; $i=0?><!-- grava variavel animal-->
                                @endif
                                @if($animal === $dado->animal_id)<!--se for o mesmo animal insere coluna-->
                                <?php $i=$i+1;?>
                                    <td class = "{{$i % 2 <> 0 ? "blue lighten-4" : "" }}">{{date('d/m/Y',strtotime($dado->data))}}</td>
                                    <td class = "{{$i % 2 <> 0 ? "blue lighten-4" : "" }}">{{$dado->peso}} Kg</td>
                                    <td class = "{{$i % 2 <> 0 ? "blue lighten-4" : "" }}">{{$dado->dif_dias}} dias</td>
                                    <td class = "{{$i % 2 <> 0 ? "blue lighten-4" : "" }}">
                                    @if(isset($dado->diff_peso) and isset($dado->dif_dias))
                                            {{number_format($dado->diff_peso / $dado->dif_dias, 2, ',', ' ')}}  Kg/dia
                                        @endif
                                    </td>
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
