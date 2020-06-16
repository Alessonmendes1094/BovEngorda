@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Filtro</span>
                    <form method="GET" action="{{route('pesagem.index')}}">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="brinco" name="brinco" value="{{request()->query('brinco')}}" type="text"
                                       class="validate">
                                <label for="brinco">Brinco</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="lote">
                                    <option value="" selected>Escolha o Lote</option>
                                    @foreach($lotes as $lote)
                                        <option @if(request()->query('lote') == $lote->id) selected
                                                @endif value="{{$lote->id}}">{{$lote->nome}}</option>
                                    @endforeach
                                </select>
                                <label>Lote</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="raca">
                                    <option value="" selected>Escolha a Raca</option>
                                    @foreach($racas as $raca)
                                        <option @if(request()->query('raca') == $raca->id) selected
                                                @endif value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label>Raca</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="sexo">
                                    <option value="" selected>Escolha o Sexo</option>
                                    <option @if(request()->query('sexo') == "M") selected @endif value="M">Masculino
                                    </option>
                                    <option @if(request()->query('sexo') == "F") selected @endif  value="F">Feminino
                                    </option>
                                </select>
                                <label>Sexo</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="fornecedor">
                                    <option value="" selected>Escolha o Fornecedor</option>
                                    @foreach($fornecedores as $fornecedor)
                                        <option @if(request()->query('fornecedor') == $fornecedor->id) selected @endif 
                                            value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
                                    @endforeach
                                </select>
                                <label>Fornecedor de Compra</label>
                            </div>
                            <div class="input-field col s12">
                                <input type="date" id="data" name="data"
                                                   class="validate" value="{!! isset($data) ? $data->data : null !!}">
                                <label>Data de Compra</label>
                            </div>
                            <div class="col s12 right">
                                <button class="btn blue-grey right"><i class="material-icons right">search</i> Pesquisar
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col s12 l9">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Pesos Cadastrado</span>
                    <div class="row">
                        <div class="col s12 right btnacoes">

                            <!--<a class="btn green white-text right"
                               href="{{route('pesagem.listAnimais')}}"><i
                                    class="material-icons right">group_add</i>Pessagem em Massa</a>
                            -->
                            <a class="btn green white-text right"
                               href="{{route('pesagem.cadastroPeso')}}"><i
                                    class="material-icons right">person_add</i>Pesagem Individual</a>

                            <a class="btn blue white-text right"
                               href="{{route('pesagem.showFormcarregarDados')}}"><i
                                    class="material-icons right">cloud_upload</i>Importar Pesos</a>
                        </div>
                        <div class="col s12 ">
                            <table>
                                <thead>
                                <tr>
                                    <th>Brinco</th>
                                    <th>Lote</th>
                                    <th>Raça</th>
                                    <th>Data</th>
                                    <th>Peso</th>
                                    <th>GMD</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $lastData = 0;
                                $lastPeso = 0;
                                $lastAnimal =  0;
                                ?>
                                @foreach($pesagens as $pesagem)
                                    <?php
                                    if ($lastAnimal != $pesagem->animal_id) {
                                        $lastData = 0;
                                        $lastPeso = 0;
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="{{route('animal.showFormAnimalForEdit', $pesagem->animal_id)}}" target="_blank">{{$pesagem->brinco}}</a>
                                        </td>
                                        <td>{{isset($pesagem->lote)  ? $pesagem->lote : '' }}</td>
                                        <td>{{isset($pesagem->raca)  ? $pesagem->raca : '' }}</td>
                                        <td>{{date('d/m/Y',strtotime($pesagem->data))}}</td>
                                        <td>{{$pesagem->peso}}</td>
                                        <td>
                                            <?php
                                            if ($lastAnimal != $pesagem->animal_id) {
                                                echo  number_format(0, 2, ',', ' ');
                                            }else{
                                                $diferenca = strtotime($pesagem->data) - strtotime($lastData);
                                                $qtdDias = floor($diferenca / (60 * 60 * 24));
                                                $qtdDias = $qtdDias == 0 ? 1 : $qtdDias;
                                                echo number_format((($pesagem->peso - $lastPeso) / $qtdDias), 2, ',', ' ');
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button
                                                data-content="{{route('pesagem.delete', $pesagem->pesagen_id)}}"
                                                class="btnDelete waves-effect red  btn-small">
                                                <i class="material-icons">delete</i></button>
                                        </td>
                                    </tr>
                                    <?php

                                    $lastData = $pesagem->data;
                                    $lastPeso = $pesagem->peso;
                                    $lastAnimal = $pesagem->animal_id;

                                    ?>
                                @endforeach
                                </tbody>
                            </table>
                            <?php echo $pesagens->appends(['brinco' => request()->query('brinco')],
                                ['sexo' => request()->query('sexo')],
                                ['lote' => request()->query('lote')],
                                ['raca' => request()->query('raca')])->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        btnsdDelete = document.querySelectorAll('.btnDelete');
        btnsdDelete.forEach((btn) => {
            btn.addEventListener('click', function () {
                var resposta = confirm('Tem certeza que deseja apagar esse Peso ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
