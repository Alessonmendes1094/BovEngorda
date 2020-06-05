@extends('custos.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Custos Vacinas Cadastrados</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('custos.vacinas.showformcustos')}}"><i
                                    class="material-icons right">add</i>Novo Custo</a>
                        </div>
                        <div class="col s12 right">
                            <table>
                                <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                    <th>Opções</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($custos as $custo)
                                    <tr>
                                        <td>{{$custo->titulo}}</td>
                                        <td>{{$custo->valor_total}}</td>
                                        <td>{{$custo->data->format('d/m/Y')}}</td>
                                        <td>
                                            <button data-content="{{route('custos.vacinas.delete', $custo->id)}}"
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
