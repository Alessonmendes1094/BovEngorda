@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Filtro</span>
                    <div class="row">
                        <form method="GET" action="{{route('financeiro.index')}}">
                            <div class="input-field col s12">
                                <input id="dataInit" name="dataInit" type="date" value="{{request()->get('dataInit')}}">
                                <label for="dataInit">Data Vencimento Inicial</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="dataFim" name="dataFim" type="date" value="{{request()->get('dataFim')}}">
                                <label for="dataFim">Data Vencimento Final</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="categoria" name="categoria" type="text" class="validate"
                                       value="{{request()->get('categoria')}}">
                                <label for="categoria">Categoria</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="tipo_dc">
                                    <option value="" selected>Escolha o Tipo do Movimento</option>
                                    <option value="debito">Saida</option>
                                    <option value="credito">Entrada</option>
                                </select>
                                <label>Raca</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="fornecedor" name="fornecedor" type="text" class="validate"
                                       value="{{request()->get('fornecedor')}}">
                                <label for="fornecedor">Fornecedor</label>
                            </div>
                            <div class="col s12 right">
                                <button class="btn blue-grey right"><i class="material-icons right">search</i> Pesquisar
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="col s12 l9">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right btnacoes">

                            <a class="btn green white-text right"
                               href="{{route('financeiro.showFormEntrada')}}"><i
                                    class="material-icons right">add</i>Nova Entrada</a>

                            <a class="btn green white-text right"
                               href="{{route('financeiro.showFormSaida')}}"><i
                                    class="material-icons right">add</i>Nova Saida</a>

                        </div>
                        <div class="indicadores-financeiro row">
                            <div class="col s4 center-align green-text">
                                <h6>Total A Receber</h6>
                                <p><strong>R$ {{$totalAReceber->valor}}</strong></p>
                            </div>
                            <div class="col s4 center-align brown-text">
                                <h6>Total A Pagar</h6>
                                <p><strong>R$ {{$totalAPagar->valor}}</strong></p>
                            </div>
                            <div class="col s4 center-align red-text">
                                <h6>Total Vencido</h6>
                                <p><strong>R$ {{$totalVencido->valor}}</strong></p>
                            </div>
                        </div>
                        <div class="col s12 ">
                            <table>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Data Vencimento</th>
                                    <th>Data Pagamento</th>
                                    <th>Tipo</th>
                                    <th>Fornecedor</th>
                                    <th>Categoria</th>
                                    <th>Valor</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($operacaoes as $operacao)
                                    <tr class="{!! $operacao->tipo_dc == 'debito'? 'red-text' : 'blue-text' !!} red-text">
                                        <td>{{$operacao->id}}</td>
                                        <td>{{ date('d/m/Y',strtotime($operacao->data_vencimento))}}</td>
                                        <td>{{ isset($operacao->data_pagamento) ? date('d/m/Y',strtotime($operacao->data_pagamento)) : ''}}</td>
                                        <td>{{ $operacao->tipo_dc == 'debito' ? 'SAIDA' : 'ENTRADA'}}</td>
                                        <td>{{$operacao->fornecedor}}</td>
                                        <td>{{$operacao->categoria}}</td>
                                        <td>R$ {{$operacao->valor}}</td>
                                        <td>
                                            <a class="btn-small blue" href="{{route('financeiro.edit', $operacao->id)}}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button
                                                data-content="{{route('financeiro.delete', $operacao->id)}}"
                                                class="btnDelete waves-effect red  btn-small">
                                                <i class="material-icons">delete</i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <?php echo $operacaoes->appends(
                                ['dataInit' => request()->query('dataInit')],
                                ['dataFim' => request()->query('dataFim')],
                                ['categoria' => request()->query('categoria')],
                                ['tipo_dc' => request()->query('tipo_dc')],
                                ['fornecedor' => request()->query('fornecedor')])->render(); ?>
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
                var resposta = confirm('Tem certeza que deseja apagar essa Operação ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
