@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Tipo Pesos Cadastrados</span>
                    @section('content_tabela')
                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content">
                                        <span class="card-title">Tipos Pesos Cadastrados</span>
                                        <div class="row">
                                            <div class="col s12 right">
                                                <a class="btn green white-text right"
                                                   href="{{route('tipopeso.showFormTipoPeso')}}"><i
                                                        class="material-icons right">add</i>Novo Tipo Peso</a>
                                            </div>
                                            <div class="col s12 right">
                                                <table>
                                                    <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($tipoPesos as $tipoPeso)
                                                        <tr>
                                                            <td>{{$tipoPeso->nome}}</td>
                                                            <td>
                                                                <a href="{{route('tipopeso.showFormTipoPesosForEdit', $tipoPeso->id)}}"
                                                                   class="btnTableUser waves-effect blue btn-small"><i
                                                                        class="material-icons">edit</i></a>
                                                                <button
                                                                    data-content="{{route('tipopeso.delete', $tipoPeso->id)}}"
                                                                    class="btnTableUser btnDelete waves-effect red  btn-small">
                                                                    <i
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
                var resposta = confirm('Tem certeza que deseja apagar esse TipoPesos ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
