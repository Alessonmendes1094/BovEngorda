@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Lotes Cadastrados</span>
                    <div class="row">
                        
                        <div class="col s12 right">
                            <a class="btn green white-text right"
                               href="{{route('lote.showFormLote')}}"><i
                                    class="material-icons right">add</i>Novo Lote</a>
                        </div>
                        <div class="col s12 right">
                            <table>
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Peso Inicial</th>
                                    <th>Peso Final</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($lotes as $lote)
                                    <tr>
                                        <td>{{$lote->nome}}</td>
                                        <td>{{$lote->peso_inicial}}</td>
                                        <td>{{$lote->peso_final}}</td>
                                        <td>
                                            <a href="{{route('lote.indexVacina', $lote->id)}}"
                                               class="btnTableUser waves-effect blue btn-small"><i
                                                    class="material-icons right">local_hospital</i>Vacinas</a>
                                            <a href="{{route('lote.showFormLoteForEdit', $lote->id)}}"
                                               class="btnTableUser waves-effect blue btn-small"><i
                                                    class="material-icons">edit</i></a>
                                            <button
                                                data-content="{{route('lote.delete', $lote->id)}}"
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
        });
    </script>
@endsection
