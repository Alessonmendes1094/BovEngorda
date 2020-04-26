@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 m2"></div>
        <div class="col s12 m8">
            <div class="card">
                <div class="card-content">
                    @if($tipo == 'entrada')
                        <span class="card-title">Nova Entrada</span>
                    @else
                        <span class="card-title">Nova Saida</span>
                    @endif

                    <div class="row">
                        <div class="col s12 ">
                            <form action="{{route('financeiro.save')}}" method="POST">
                                @if($tipo == 'entrada')
                                    <input type="hidden" name="dc" value="credito">
                                @else
                                    <input type="hidden" name="dc" value="debito">
                                @endif
                                @csrf
                                <input type="hidden" name="id"
                                       value="{!! isset($operacao) ? $operacao->id : null!!}">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="numero_documento" name="numero_documento" type="text" class="validate"
                                           value="{!! isset($operacao) ? $operacao->numero_documento : null !!}"
                                           required>
                                    <label for="numero_documento">Documento</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">fingerprint</i>
                                    <input id="conta_corrente" name="conta_corrente" type="text" class="validate"
                                           value="{!! isset($operacao) ? $operacao->conta_corrente : null !!}"
                                           required>
                                    <label for="conta_corrente">Conta Corrente</label>
                                </div>
                                <div class="input-field col s4">
                                    <i class="material-icons prefix">calendar_today</i>
                                    <input id="data_pagamento" name="data_pagamento" type="date" class="validate"
                                           value="{!! isset($operacao) ? $operacao->data_pagamento : '' !!}">
                                    <label for="data_pagamento">Data Pagamento</label>
                                </div>
                                <div class="input-field col s8">
                                    <i class="material-icons prefix">person</i>
                                    <input id="fornecedor" name="fornecedor" type="text" class="validate"
                                           value="{!! isset($operacao) ? $operacao->fornecedor : null !!}"
                                           required>
                                    <label for="fornecedor">Fornecedor</label>
                                </div>
                                    <div class="input-field col s4">
                                        <i class="material-icons prefix">calendar_today</i>
                                        <input id="data_vencimento" name="data_vencimento" type="date" class="validate"
                                               value="{!! isset($operacao) ? $operacao->data_vencimento : date('Y-m-d') !!}"
                                               required>
                                        <label for="data_vencimento">Data Vencimento</label>
                                    </div>
                                <div class="input-field col s4">
                                    <i class="material-icons prefix">category</i>
                                    <input id="categoria" name="categoria" type="text" class="validate"
                                           value="{!! isset($operacao) ? $operacao->categoria : null !!}"
                                           required>
                                    <label for="categoria">Categoria</label>
                                </div>
                                <div class="input-field col s4">
                                    <i class="material-icons prefix">money</i>
                                    <input id="valor" name="valor" type="number" step="any" class="validate"
                                           value="{!! isset($operacao) ? $operacao->valor : null !!}"
                                           required>
                                    <label for="valor">Valor</label>
                                </div>
                                <div class="col s12 right">
                                    <button type="submit" class="btn green white-text right"><i
                                            class="material-icons left">save</i>Salvar Movimento Financeiro
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m2"></div>
    </div>
@endsection
