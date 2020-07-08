@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Fornecedores Cadastrados</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('fornecedor.showformfornecedor')}}"><i
                                    class="material-icons right">add</i>Novo Fornecedor</a>
                        </div>
                        <div class="col s12 right">
                            <table>
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Endereço</th>
                                    <th>CNPJ</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($fornecedores as $fornecedor)
                                    <tr>
                                        <td>{{$fornecedor->nome}}</td>
                                        <td>{{$fornecedor->endereco}}</td>
                                        <td>{{$fornecedor->cnpj}}</td>
                                        <td>
                                            <a href="{{route('fornecedor.showFormFornecedorForEdit', $fornecedor->id)}}"
                                               class="btnTableUser waves-effect blue btn-small"><i
                                                    class="material-icons">edit</i></a>
                                            <button data-content="{{route('fornecedor.delete', $fornecedor->id)}}"
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
                var resposta = confirm('Tem certeza que deseja apagar esse Fornecedor ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
