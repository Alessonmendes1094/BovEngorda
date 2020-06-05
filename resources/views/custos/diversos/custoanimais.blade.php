@extends('custos.layout')

@section('content_tabela')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Visualizar Animais do Custo {{$custo->titulo}} </span>
                <div class="row">
                    <div class="col s12 right">
                        <a class="btn green white-text right" href="{{route('custos.diversos.index')}}"><i class="material-icons">arrow_back</i>Voltar</a>
                    </div>
                    <div class="col s12">
                        <div class="row ">
                            <div class="col l2"></div>
                                    <div class="row">
                                        <div class="col s12 ">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Seq</th>
                                                        <th>Brinco</th>
                                                        <th>Valor Custo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($animais as $animal)
                                                    <tr>
                                                        <td>{{isset($animal->sequencia) ? $animal->sequencia : '' }}</td>
                                                        <td>{{isset($animal->id_animais) ? $animal->animal->brinco : '' }}</td>
                                                        <td>{{isset($animal->valor) ? $animal->valor : '' }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
