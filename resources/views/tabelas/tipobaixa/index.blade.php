@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Tipos Baixas Cadastrados</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right"
                               href="{{route('tipobaixa.showformTipoBaixa')}}"><i
                                    class="material-icons right">add</i>Novo Tipo Baixa</a>
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
                                @foreach($tipoBaixas as $tipoBaixa)
                                    <tr>
                                        <td>{{$tipoBaixa->nome}}</td>
                                        <td>
                                            @if($tipoBaixa->id != 1)
                                                <a href="{{route('tipobaixa.showFormTipoBaixaForEdit', $tipoBaixa->id)}}"
                                                   class="btnTableUser waves-effect blue btn-small"><i
                                                        class="material-icons">edit</i></a>
                                                <button
                                                    data-content="{{route('tipobaixa.delete', $tipoBaixa->id)}}"
                                                    class="btnTableUser btnDelete waves-effect red  btn-small">
                                                    <i class="material-icons">delete</i></button>
                                            @endif
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
                var resposta = confirm('Tem certeza que deseja apagar essa Tipo Baixa ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
