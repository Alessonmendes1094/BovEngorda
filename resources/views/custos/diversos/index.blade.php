@extends('custos.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Custos Diversos Cadastrados</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('custos.diversos.showformcustos')}}"><i
                                    class="material-icons right">add</i>Novo Custo</a>
                        </div>
                        <div class="col s12 right">
                            <table>
                                <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Qtd Animais</th>
                                    <th>Valor Total</th>
                                    <th>Data</th>
                                    <th>Opções</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($custos as $custo)
                                    <tr>
                                        <td>{{$custo->titulo}}</td>
                                        <td>{{$custo->qtd_animais}}</td>
                                        <td>{{$custo->valor_total}}</td>
                                        <td>{{$custo->data->format('d/m/Y')}}</td>
                                        <td>
                                            <a href="{{route('custos.diversos.ShowAnimais', $custo->id)}}"
                                               class="waves-effect blue btn-small"><i
                                                    class="material-icons">visibility</i></a>
                                            <a href="{{route('custos.diversos.editar', $custo->id)}}"
                                               class="waves-effect blue btn-small"><i
                                                    class="material-icons">edit</i></a>
                                            <button data-content="{{route('custos.diversos.delete', $custo->id)}}"
                                                    class="btnDelete waves-effect red  btn-small"><i
                                                    class="material-icons">delete</i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
                var resposta = confirm('Tem certeza que deseja apagar esse Fornecedor ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
