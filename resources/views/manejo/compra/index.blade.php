@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Filtro</span>
                    <form method="GET" action="{{route('compra.index')}}">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="dataInit" name="dataInit" type="date" value="{{request()->query('dataInit')}}">
                                <label for="dataInit">Data Inicial</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="dataFim" name="dataFim" type="date" value="{{request()->query('dataFim')}}">
                                <label for="dataFim">Data Final</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="tipo">
                                    <option value="" selected>Escolha um tipo de manejo</option>
                                    <option @if(request()->query('tipo') == 'compra') selected @endif value="compra">Compra</option>
                                    <option  @if(request()->query('tipo') == 'venda') selected @endif value="venda">Venda</option>
                                </select>
                                <label>Tipo</label>
                            </div>
                            <div class="input-field col s12">
                                <select id="fornecedor" name="fornecedor">
                                    <option value="" selected>Escolha um tipo um Fornecedor</option>
                                    @foreach($fornecedores as $forncedor)
                                        <option @if(request()->query('fornecedor') == $forncedor->id) selected @endif value="{{$forncedor->id}}">{{$forncedor->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="fornecedor">Fornecedor</label>
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
                    <span class="card-title">Manejos Cadastrados</span>
                    <div class="row">
                        <div class="col s12 right btnacoes">
                            <a class="btn green white-text right" href="{{route('compra.novaCompra')}}">
                                <i class="material-icons right">add</i>
                                Nova Compra
                            </a>
                            <a class="btn blue white-text right"  href="{{route('compra.showFormcarregarDados')}}">
                                <i class="material-icons right">cloud_upload</i>
                                Importar Dados
                            </a>

                        </div>
                        <div class="col s12 ">
                            <table>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Data</th>
                                    <th>Tipo</th>
                                    <th>Fornecedor</th>
                                    <th class="center-align">Qtd de Animais</th>
                                    <th>Valor</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($manejos as $manejo)
                                    <tr>
                                        <td>{{$manejo->id}}</td>
                                        <td>{{date('d/m/Y', strtotime($manejo->data)) }}</td>
                                        <td>
                                            <strong
                                                class="@if($manejo->tipo == 'compra') red-text @else green-text @endif">
                                                {{$manejo->tipo}}</strong>
                                        </td>
                                        <td>{{$manejo->fornecedor}}</td>
                                        <td class="center-align">{{$manejo->qtdAnimais}}</td>
                                        <td>R$ {{number_format($manejo->valorTotals, 2, ',', ' ')}}</td>
                                        <td>
                                            <!--<a class="btn blue" href="{{route('compra.edit', $manejo->id)}}">
                                                <i class="material-icons">edit</i>
                                            </a>-->
                                            <a class="btn blue" href="{{route('compra.showanimais', $manejo->id)}}">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <button
                                                data-content="{{route('compra.delete', $manejo->id)}}"
                                                class="btnDelete waves-effect red  btn">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <?php echo $manejos->appends(
                                ['dataInit' => request()->query('dataInit')],
                                ['dataFim' => request()->query('dataFim')],
                                ['tipo' => request()->query('tipo')],
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
                var resposta = confirm('Tem certeza que deseja apagar esse Manejo?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
