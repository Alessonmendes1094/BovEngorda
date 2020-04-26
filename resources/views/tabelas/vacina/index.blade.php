@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Vacinas Cadastradas</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('vacina.showformVacina')}}"><i
                                    class="material-icons right">add</i>Nova Vacina</a>
                        </div>
                        <div class="col s12 right">
                            <table>
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($vacinas as $vacina)
                                    <tr>
                                        <td>{{$vacina->nome}}</td>
                                        <td>{{$vacina->descricao}}</td>
                                        <td>
                                            <a href="{{route('vacina.showformVacinaForEdit', $vacina->id)}}"
                                               class="btnTableUser waves-effect blue btn-small"><i
                                                    class="material-icons">edit</i></a>
                                            <button data-content="{{route('vacina.delete', $vacina->id)}}"
                                                    class="btnTableUser btnDelete waves-effect red  btn-small"><i
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
                var resposta = confirm('Tem certeza que deseja apagar essa Vacina ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
