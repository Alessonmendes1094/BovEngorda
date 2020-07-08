@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12 l9">
        <div class="card" style="overflow:scroll;overflow:auto">

            <div class="card-content">
                <span class="card-title">Animais do Manejo {{$id}}</span>
                <div class="row">
                    <div class="col s12 right btnacoes">
                        <a class="btn white-text left" href="{{route('compra.index')}}"><i
                            class="material-icons">arrow_back</i>Voltar</a>
                        <a class="btn green white-text right" href="{{route('compra.novoanimal', $id)}}"><i class="material-icons right">add</i>Novo Animal</a>

                    </div>
                    <div class="col s12 ">
                        <table>
                            <thead>
                                <tr>
                                    <th>Brinco</th>
                                    <th>Lote</th>
                                    <th>Peso</th>
                                    <th>Valor do Animal</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($animais as $animal)
                                <tr>
                                    <td>{{$animal->brinco}}</td>
                                    <td>{{$animal->nome}}</td>
                                    <td>{{$animal->peso}} Kg</td>
                                    <td>R${{number_format($animal->valor, 2, ',', ' ')}}</td>
                                    <td>
                                        <a href="{{route('animal.showFormAnimalForEdit', $animal->id)}}" class="btnTableUser waves-effect blue btn-small"><i class="material-icons" disabled>edit</i></a>
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
    @endsection
    @section('scripts')
    <script>
        btnsdDelete = document.querySelectorAll('.btnDelete');
        btnsdDelete.forEach((btn) => {
            btn.addEventListener('click', function() {
                var resposta = confirm('Tem certeza que deseja apagar esse Animal ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })

    </script>
    @endsection
