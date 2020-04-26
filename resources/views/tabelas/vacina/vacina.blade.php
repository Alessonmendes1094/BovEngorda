@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Nova Vacina</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('vacina.index')}}"><i
                                    class="material-icons">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12">
                            <div class="row ">
                                <div class="col l2"></div>
                                <div class="col s12 m12 l8 center-align">
                                    <form class="form-vacina" method="POST" action="{{route('vacina.save')}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($vacina) ? $vacina->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">account_circle</i>
                                                <input id="nome" name="nome" type="text" class="validate"
                                                       value="{!! isset($vacina) ? $vacina->nome : null !!}"
                                                       required>
                                                <label for="nome">Nome</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">place</i>
                                                <input id="descricao" name="descricao" type="text" class="validate"
                                                       value="{!! isset($vacina) ? $vacina->descricao : null !!}">
                                                <label for="descricao">Descrição</label>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit"
                                                        class="btn green right">{!! isset($vacina) ? 'Editar' : 'Salvar' !!}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col l2"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
