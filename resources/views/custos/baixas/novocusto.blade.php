@extends('custos.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Novo Custo Com Baixas</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('custos.baixas.index')}}"><i
                                    class="material-icons">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12">
                            <div class="row ">
                                <div class="col l2"></div>
                                <div class="col s12 m12 l8 center-align">
                                    <form class="form-custo" method="POST" action="{{route('custos.baixas.save')}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($custo) ? $custo->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">account_circle</i>
                                                <input id="titulo" name="titulo" type="text" class="validate"
                                                       value="{!! isset($custo) ? $custo->titulo : null !!}"
                                                       required>
                                                <label for="titulo">Titulo</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">place</i>
                                                <textarea  id="descricao" name="descricao" type="text" class="materialize-textarea" data-length="120"
                                                       value="{!! isset($custo) ? $custo->descricao : null !!}"></textarea>
                                                <label for="descricao">Descricao</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">money</i>
                                                <input id="valor" type="text" name="valor" class="validate"
                                                       value="{!! isset($custo) ? $custo->valor : null !!}">
                                                <label for="valor">valor</label>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit"
                                                        class="btn green right">{!! isset($custo) ? 'Editar' : 'Salvar' !!}</button>
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
