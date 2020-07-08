@extends('custos.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Novo Custo Com Baixas</span>
                    <p>A baixa do animal, somará todo o custo gasto com ele ate a presente data e dividirá entre <b>todos os animais</b> comprados no mesmo lote</p>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('custos.baixas.index')}}"><i
                                    class="material-icons">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12">
                            <div class="row ">
                                <div class="col l2"></div>
                                <div class="col s12 m12 l8">
                                    <form class="form-custo" method="POST" action="{{route('custos.baixas.save')}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($custo) ? $custo->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">fingerprint</i>
                                                <input type="text" id="autocomplete-input" name="animal" class="autocomplete" autocomplete="off">
                                                <label for="autocomplete-input">Brinco</label>
                                                @error('animal')
                                                <span class="helper-text" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">airline_seat_flat</i>
                                                <select id="baixa" name="baixa">
                                                    <option value="" selected>Escolha o  Tipo de Baixa</option>
                                                    @foreach($tipo_baixas as $baixa)
                                                    <option value="{{$baixa->id}}">{{$baixa->nome}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="baixa">Tipos de Baixas</label>
                                                @error('baixa')
                                                <span class="helper-text" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">date_range</i>
                                                <input id="data" type="date" name="data" required class="validate" >
                                                <label for="data">Data</label>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit"
                                                        class="btn green right">Salvar</button>
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
<script type="text/javascript">
    $(document).ready(function() {

        $(function(request) {
            $.ajax({
                type: 'GET'
                , url: "{{url('/animais/buscar/bois/autocomplete')}}"
                , data: {
                    term: request.term
                }
                , dataType: "json"
                , success: function(response) {
                    var bois = response;
                    var boi = {};
                    for (var i = 0; i < bois.length; i++) {
                        boi['Brinco: ' + bois[i].brinco + ' - ' + bois[i].nome] = bois[i].flag;
                    }

                    $('input.autocomplete').autocomplete({
                        data: boi
                        , limit: 5
                    , });
                }
            });
        });
    });

</script>
@endsection