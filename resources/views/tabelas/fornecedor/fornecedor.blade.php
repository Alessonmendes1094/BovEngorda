@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Novo Fornecedor</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('fornecedor.index')}}"><i
                                    class="material-icons">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12">
                            <div class="row ">
                                <div class="col l2"></div>
                                <div class="col s12 m12 l8 center-align">
                                    <form class="form-fornecedor" method="POST" action="{{route('fornecedor.save')}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($fornecedor) ? $fornecedor->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">account_circle</i>
                                                <input id="nome" name="nome" type="text" class="validate"
                                                       value="{!! isset($fornecedor) ? $fornecedor->nome : null !!}"
                                                       required>
                                                <label for="nome">Nome</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">place</i>
                                                <input id="endereco" name="endereco" type="text" class="validate"
                                                       value="{!! isset($fornecedor) ? $fornecedor->endereco : null !!}">
                                                <label for="endereco">Endereço</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">money</i>
                                                <input id="cnpj" type="text" name="cnpj" class="validate"
                                                       value="{!! isset($fornecedor) ? $fornecedor->cnpj : null !!}">
                                                <label for="cnpj">CNPJ</label>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit"
                                                        class="btn green right">{!! isset($fornecedor) ? 'Editar' : 'Salvar' !!}</button>
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
