@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Novo Tipo Peso</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('tipopeso.index')}}"><i
                                    class="material-icons right">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12">
                            <div class="row ">
                                <div class="col l2"></div>
                                <div class="col s12 m12 l8 center-align">
                                    <form class="form-tipopeso" method="POST" action="{{route('tipopeso.save')}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($tipopeso) ? $tipopeso->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">account_circle</i>
                                                <input id="nome" name="nome" type="text" class="validate"
                                                       value="{!! isset($tipopeso) ? $tipopeso->nome : null !!}"
                                                       required>
                                                <label for="nome">Nome</label>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit"
                                                        class="btn green right">{!! isset($tipopeso) ? 'Editar' : 'Salvar' !!}</button>
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
