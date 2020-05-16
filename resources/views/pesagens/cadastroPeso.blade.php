@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Cadastro de peso Animal</span>
                    <div class="row">
                        <div class="col s12 right btnacoes">
                            <a class="btn white-text right" href="{{route('pesagem.index')}}"><i class="material-icons right">arrow_back</i>Voltar</a>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <form method="POST" action="{{route('pesagem.salvar')}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">date_range</i>
                                            <input type="date" id="data" name="data"
                                                   class="" >
                                            <label for="data">Data</label>
                                            @error('data')
                                            <span class="helper-text" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">fingerprint</i>
                                            <input type="text" id="autocomplete-input" name="animal"
                                                   class="autocomplete" autocomplete="off">
                                            <label for="autocomplete-input">Brinco</label>
                                            @error('animal')
                                            <span class="helper-text" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">fitness_center</i>
                                            <input id="peso" name="peso" type="number" step="any"
                                                   class="validate"
                                                   required>
                                            <label for="peso">Peso Kg</label>
                                            @error('peso')
                                            <span class="helper-text" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col s12">
                                            <button type="submit" class="btn green right">Salvar</button>
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $(function (request) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('/animais/buscar/bois/autocomplete')}}",
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function (response) {
                        var bois = response;
                        var boi = {};
                        for (var i = 0; i < bois.length; i++) {boi['Brinco: '+bois[i].brinco + ' - ' + bois[i].nome] = bois[i].flag;
                        }

                        $('input.autocomplete').autocomplete({
                            data: boi,
                            limit: 5,
                        });
                    }
                });
            });
        });
    </script>
@endsection
