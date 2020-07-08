@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 m6">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Cadastro de  Animal</span>
                    <div class="row">
                        <div class="col s12  right">
                            <a class="btn blue-grey white-text right" href="{{route('animal.index')}}"><i
                                    class="material-icons left">arrow_back</i>Todos Os Animais</a>
                        </div>
                        <div class="col s12 ">
                            <div class="row ">
                                <div class="col s12 ">
                                    <form class="form-cliente" method="POST" action="{{route('animal.save')}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($animal) ? $animal->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">looks_one</i>
                                                <input id="brinco" name="brinco" type="text" class="validate brinco"
                                                       value="{{  old('brinco', $animal->brinco) }}"
                                                       required>
                                                <label for="brinco">Brinco</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">person</i>
                                                <input id="nome" name="nome" type="text" class="validate"
                                                       value="{{  old('nome', $animal->nome) }}">
                                                <label for="nome">Nome</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">category</i>
                                                <select id="lote" name="lote">
                                                    <option value="" selected>Escolha o Lote</option>
                                                    @foreach($lotes as $lote)
                                                        <option @if($lote->id == old('lote', $animal->id_lote)) selected
                                                                @endif value="{{$lote->id}}">{{$lote->nome}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="lote">Lote</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">fingerprint</i>
                                                <select id="raca" name="raca">
                                                    <option value="" selected>Escolha a Raca</option>
                                                    @foreach($racas as $raca)
                                                        <option @if($raca->id == old('raca', $animal->id_raca)) selected
                                                                @endif value="{{$raca->id}}">{{$raca->nome}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="raca">Raça</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">call_split</i>
                                                <select name="sexo">
                                                    <option value="" selected>Escolha o Sexo</option>
                                                    <option @if("M" == old('sexo', $animal->sexo)) selected
                                                            @endif value="M">Masculino
                                                    </option>
                                                    <option @if("F" == old('sexo', $animal->sexo)) selected
                                                            @endif value="F">Feminino
                                                    </option>
                                                </select>
                                                <label>Sexo</label>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit"
                                                        class="btn green right">Salvar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col l2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if( isset($animal) )
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Dados Complementares</span>
                        <div class="row">
                            <div class="col s12">
                                @if(isset($animalGmdChart))
                                    {!! $animalGmdChart->container() !!}
                                @endif
                            </div>
                            <div class="col s12">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th></th>
                                        <th>Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalVenda = 0; $totalCompra = 0; ?>
                                    @if(isset($compra))
                                        <?php $totalCompra = $compra->valor; ?>
                                        <tr>
                                            <td class="aniamalcompra">Compra</td>
                                            <td>{{date('d/m/Y',strtotime($compra->data))}}</td>
                                            <td class="red-text"><strong>R$ -{{$compra->valor}}</strong></td>
                                        </tr>
                                    @endif
                                    <?php  $qtdDias = 0; $lastHistorico = null; $total = 0;?>
                                    @if(isset($historicoLotes))
                                        @foreach($historicoLotes as $historico)
                                            @if(isset($lastHistorico))
                                                <tr>
                                                    <td>
                                                        <a target="_blank"
                                                        href="{{route('lote.showFormLoteForEdit', $lastHistorico->id_lote)}}">{{$lastHistorico->nome}}</a>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $diferenca = strtotime($historico->data) - strtotime($lastHistorico->data);
                                                        $qtdDias = floor($diferenca / (60 * 60 * 24));
                                                        $qtdDias = $qtdDias == 0 ? 1 : $qtdDias;
                                                        $total += ($lastHistorico->valorkg * $lastHistorico->consumodia) * $qtdDias;
                                                        echo $qtdDias . ' dias'
                                                        ?>
                                                    </td>
                                                    <td class="red-text">
                                                        R$ -{{($lastHistorico->valorkg * $lastHistorico->consumodia) * $qtdDias}}
                                                    </td>
                                                </tr>
                                            @endif
                                            <?php $lastHistorico = $historico?>
                                        @endforeach
                                    @endif
                                    @if(isset($venda))
                                        <?php $totalVenda = $venda->valor; ?>
                                        <tr>
                                            <td class="aniamalvenda">Venda</td>
                                            <td>{{ date('d/m/Y',strtotime($venda->data)) }}</td>
                                            <td class="green-text">
                                                <strong>R$ {{ $venda->valor}}</strong>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2"><strong>Total:</strong></td>
                                        <td><strong>R$ {{ $totalVenda - ($total + $totalCompra)}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    @if(isset($animalGmdChart))
        {!! $animalGmdChart->script() !!}
    @endif
    <script>
        const input = document.querySelector('.brinco');
        input.addEventListener('change', (event) => {
            $.ajax({
                url: "{{route('api.verifyAnimalByBrinco', "")}}/" + input.value + "",
            }).done((data) => {
                if (typeof data.brinco !== "undefined") {
                    input.value = "";
                    input.focus();
                    alert("Brinco já cadastrado ! Cadastre Outro");
                }
            });
        });

    </script>
@endsection
