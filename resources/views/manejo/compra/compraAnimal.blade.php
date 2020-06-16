@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12 ">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Compra de Animais</span>
                <form method="POST" action="{{route('compra.saveanimais',$id)}}">
                    <div class="row">
                        @csrf
                        <input type="hidden" name="id" value="{!! isset($animal) ? $animal->id : null !!}">
                        <input type="hidden" name="tipo" value="compra">
                        <div class="col s12 m6">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">fingerprint</i>
                                <input id="brinco" name="brinco" type="number" class="validate" value="{!! isset($animal) ? $animal->brinco : old('brinco') !!}" required>
                                <label for="brinco">Brinco</label>
                                @error('brinco')
                                <span class="helper-text" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">fitness_center</i>
                                <input id="peso" name="peso" type="number" class="validate" step="0.001" value="{!! isset($animal) ? $animal->peso : old('peso') !!}" required>
                                <label for="peso">Peso/Kg</label>
                                @error('peso')
                                <span class="helper-text" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="raca" name="raca" required>
                                    <option value="" disabled selected>Selecione a Raça</option>
                                    @foreach($racas as $raca)
                                    <option @if(isset($animal) and $animal->id_raca == $raca->id)selected
                                        @endif value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="raca">Raça</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">wc</i>
                                <select id="sexo" name="sexo" required>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </select>
                                <label for="sexo">Sexo</label>
                            </div>
                            <div class="col s12 right">
                                <button type="submit" class="btn green white-text right">
                                    <i class="material-icons left">save</i>Salvar Animal
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
