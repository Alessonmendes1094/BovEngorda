@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 ">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Compra</span>
                    <form method="POST" action="{{route('compra.save')}}">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id" value="{!! isset($manejo) ? $manejo->id : null !!}">
                            <input type="hidden" name="tipo" value="compra">
                            <div class="col s12 m3">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">calendar_today</i>
                                    <input id="data" name="data" type="date" class="validate"
                                           value="{!! isset($manejo) ? $manejo->data : date('Y-m-d') !!}"
                                           required>
                                    <label for="data">Data</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">device_hub</i>
                                    <input id="valor" name="valor" type="number" step="any" class="validate"
                                           value="{!! isset($manejo) ? $manejo->valorkg : '' !!}" required>
                                    <label for="valor">Valor Total</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">person</i>
                                    <select id="fornecedor" name="fornecedor" required>
                                        <option value="" disabled selected>Selecione um Fornecedor</option>
                                        @foreach($fornecedores as $fornecedor)
                                            <option
                                                @if(isset($manejo) and $manejo->fornecedor_id == $fornecedor->id)selected
                                                @endif  value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
                                        @endforeach
                                    </select>
                                    <label for="fornecedor">Fornecedor</label>
                                </div>
                                <div class="col s12 right">
                                    <button type="submit" class="btn green white-text right">
                                        <i class="material-icons left">save</i>Salvar Compra
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

