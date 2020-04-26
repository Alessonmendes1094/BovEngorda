@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Clientes Cadastrados</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('cliente.showformcliente')}}"><i
                                    class="material-icons right">add</i>Novo Cliente</a>
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
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{$cliente->nome}}</td>
                                        <td>
                                            <a href="{{route('fornecedor.showFormClienteForEdit', $cliente->id)}}"
                                               class="btnTableUser waves-effect blue btn-small"><i
                                                    class="material-icons">edit</i></a>
                                            <button data-content="{{route('cliente.delete', $cliente->id)}}"
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
                var resposta = confirm('Tem certeza que deseja apagar esse Cliente ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
