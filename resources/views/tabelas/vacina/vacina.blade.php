@extends('tabelas.layout')

@section('content_tabela')
<div class="row">
    <div class="col s12">
        <div class="card" style="overflow:scroll;overflow:auto">
            <div class="card-content">
                <span class="card-title">Nova Vacina</span>
                <div class="row">
                    <div class="col s12 right">
                        <a class="btn green white-text right" href="{{route('vacina.index')}}"><i class="material-icons">arrow_back</i>Voltar</a>
                    </div>
                    <div class="col s12">
                        <div class="row ">
                            <div class="col l2"></div>
                            <div class="col s12 m12 l8 center-align">
                                <form class="form-vacina" method="POST" action="{{route('vacina.save')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{!! isset($vacina) ? $vacina->id : null !!}">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="nome" name="nome" type="text" class="validate" value="{!! isset($vacina) ? $vacina->nome : null !!}" required>
                                            <label for="nome">Nome</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">place</i>
                                            <input id="descricao" name="descricao" type="text" class="validate" value="{!! isset($vacina) ? $vacina->descricao : null !!}">
                                            <label for="descricao">Descrição</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">view_agenda</i>
                                            <input id="dosagem" name="dosagem" type="number" step="0.001" onkeypress="calcular()" onchange="calcular()"  class="validate" value="{!! isset($vacina) ? $vacina->dosagem : null !!}">
                                            <p style="color: gray"><b> A quantidade de ML adquirida. Exemplo: 1 L deve ser informado 1000ml.</b></p>
                                            <label for="dosagem">Dose Frasco (ML)</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">attach_money</i>
                                            <input id="valor_pago" name="valor_pago" type="number" step="0.01" onkeypress="calcular()" onblur="calcular()" class="validate" value="{!! isset($vacina) ? $vacina->valor_pago : null !!}">
                                            <label for="valor_pago">Valor Pago na frasco</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">attach_money</i>
                                            <input disabled id="valor" name="valor" type="number" class="validate" value="{!! isset($vacina) ? $vacina->valor_ml : null !!}">
                                            <input id="valor_ml" hidden name="valor_ml" type="number" step="0.001" value="{!! isset($vacina) ? $vacina->valor_ml : null !!}">
                                            <p style="color: gray">Valor Pago em cada ML.</p>
                                        </div>
                                        <div class="col s12">
                                            <button type="submit" class="btn green right">{!! isset($vacina) ? 'Editar' : 'Salvar' !!}</button>
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
@section('scripts')
<script>
    function calcular() {
        var valor_pago = parseInt(document.getElementById('valor_pago').value, 10);
        var dosagem = parseInt(document.getElementById('dosagem').value, 10);
        const num = valor_pago / dosagem;
        
        document.getElementById('valor').value = num.toFixed(3);
        document.getElementById('valor_ml').value = num.toFixed(3);
    }

</script>
@endsection
