@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Novo Lote</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('lote.index')}}"><i
                                    class="material-icons right">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12">
                            <div class="row ">
                                <div class="col l2"></div>
                                <div class="col s12 m12 l8 center-align">
                                    <form class="form-lote" method="POST" action="{{route('lote.save')}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($lote) ? $lote->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">account_circle</i>
                                                <input id="nome" name="nome" type="text" class="validate"
                                                       value="{!! isset($lote) ? $lote->nome : null !!}"
                                                       required>
                                                <label for="nome">Nome</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">line_weight</i>
                                                <input id="peso_inicial" name="peso_inicial" type="number" step="any" class="validate"
                                                       value="{!! isset($lote) ? $lote->peso_inicial : null !!}"
                                                       required>
                                                <label for="peso_inicial">Peso Inicial(Kg)</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">line_weight</i>
                                                <input id="peso_final" name="peso_final" type="number" step="any" class="validate"
                                                       value="{!! isset($lote) ? $lote->peso_final : null !!}"
                                                       required>
                                                <label for="peso_final">Peso Final(Kg)</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">fastfood</i>
                                                <input id="racao" name="racao" type="text" class="validate"
                                                       value="{!! isset($lote) ? $lote->racao : null !!}"
                                                       required>
                                                <label for="racao">Ração</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">attach_file</i>
                                                <input id="consumodia" name="consumodia" type="number" step="any" class="validate"
                                                       value="{!! isset($lote) ? $lote->consumodia : null !!}"
                                                       required>
                                                <label for="consumodia">Consumo(Kg) Dia</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">attach_money</i>
                                                <input id="valorkg" name="valorkg" type="number" step="any" class="validate"
                                                       value="{!! isset($lote) ? $lote->valorkg : null !!}"
                                                       required>
                                                <label for="valorkg">Valor Kg</label>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit"
                                                        class="btn green right">{!! isset($lote) ? 'Editar' : 'Salvar' !!}</button>
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
