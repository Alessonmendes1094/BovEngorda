@extends('custos.layout')

@section('content_tabela')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Novo Custo com vacinação</span>
                <p>Selecione o animal que estará sendo vacinado.</p>
                <div class="row">
                    <div class="col s12 right">
                        <a class="btn green white-text right" href="{{route('custos.vacinas.index')}}"><i class="material-icons">arrow_back</i>Voltar</a>
                    </div>
                    <div class="col s12">
                        <div class="row ">                            
                            <div class="col l2"></div>
                            <div class="col s12 m12 l8 ">
                                <form class="form-custo" method="POST" action="{{route('custos.vacinas.save')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{!! isset($custo) ? $custo->id : null !!}">
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
                                            <i class="material-icons prefix">colorize</i>
                                            <select id="vacina" name="vacina">
                                                <option value="" selected>Escolha a Vacina</option>
                                                @foreach($vacinas as $vacina)
                                                <option value="{{$vacina->id}}">{{$vacina->nome}}</option>
                                                @endforeach
                                            </select>
                                            <label for="vacina">Vacina</label>
                                            @error('vacina')
                                            <span class="helper-text" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">date_range</i>
                                            <input id="data" type="date" name="data" required class="validate" >
                                            <label for="data">Data</label>
                                        </div>
                                        <div class="col s12">
                                            <button type="submit" class="btn green right">{!! isset($custo) ? 'Editar' : 'Salvar' !!}</button>
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
