@extends('tabelas.layout')

@section('content_tabela')
    <div class="row">
        <div class="col s12">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Nova Vacina</span>
                    <div class="row">
                        <div class="col s12 right">
                            <a class="btn green white-text right" href="{{route('lote.indexVacina', $id)}}"><i
                                    class="material-icons right">arrow_back</i>Voltar</a>
                        </div>
                        <div class="col s12">
                            <div class="row ">
                                <div class="col l2"></div>
                                <div class="col s12 m12 l8 center-align">
                                    <form class="form-lote" method="POST" action="{{route('lote.saveVacina' , $id)}}">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{!! isset($vacina) ? $vacina->id : null !!}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <select name="vacina" id="vacina">
                                                    @if(isset($vacina))
                                                        @foreach($vacinas as $vac)
                                                            @if($vac->id == $vacina->vacina_id)
                                                                <option value="{{$vac->id}}" selected
                                                                >{{$vac->nome}}</option>
                                                            @endif
                                                            <option value="{{$vac->id}}">{{$vac->nome}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="" disabled selected>Selecione uma Opção</option>
                                                        @foreach($vacinas as $vac)
                                                            <option value="{{$vac->id}}">{{$vac->nome}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                                <label>Vacina</label>
                                                @error('vacina')
                                                <span class="helper-text" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">line_weight</i>
                                                <input id="dosagem" name="dosagem" type="number" step="any"
                                                       class="validate"
                                                       value="{!! isset($vacina) ? $vacina->dosagem : null !!}"
                                                       required>
                                                <label for="dosagem">Dosagem (Litro)</label>
                                                @error('dosagem')
                                                <span class="helper-text" style="color:red">{{ $message }}</span>
                                                @enderror
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
