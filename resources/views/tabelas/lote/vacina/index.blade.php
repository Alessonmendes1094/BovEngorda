@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Vacinas Vinculadas ao Lote</span>
                    <div class="row">
                        @if(Session::has('erro'))
                            <div class="card-panel red lighten-1">
                                {{session::get('erro')}}

                            </div>
                        @endif
                        <div class="col s12 right btnacoes">
                            <a class="btn green white-text right"
                               href="{{route('lote.showFormVacina' , $id)}}"><i
                                    class="material-icons right">add</i>Nova Vacina</a>

                            <a class="btn white-text right" href="{{route('lote.index')}}"><i
                                    class="material-icons right">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12 right">
                            <table>
                                <thead>
                                <tr>
                                    <th>Vacina</th>
                                    <th>Descricao</th>
                                    <th>Dosagem</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                @isset($vacinas)
                                    @foreach($vacinas as $vacina)
                                        <tr>
                                            <td>{{$vacina->nome}}</td>
                                            <td>{{$vacina->descricao}}</td>
                                            <td>{{$vacina->pivot->dosagem}}</td>
                                            <td>
                                                <a href="{{route('lote.showFormVacinaForEdit', $vacina->pivot->id)}}"
                                                   class="btnTableUser waves-effect blue btn-small"><i
                                                        class="material-icons">edit</i></a>
                                                <button
                                                    data-content="{{route('lote.deleteVacina', $vacina->pivot->id)}}"
                                                    class="btnTableUser btnDelete waves-effect red  btn-small">
                                                    <i
                                                        class="material-icons">delete</i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
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
                var resposta = confirm('Tem certeza que deseja apagar esse Lote ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
