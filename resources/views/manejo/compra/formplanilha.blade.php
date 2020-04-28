@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 m3"></div>
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Carregar Dados</span>
                    <div class="row">
                        <div class="col s12">
                            <form action="{{route('compra.carregarDados')}}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>File</span>
                                        <input type="file" name="file" required>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                    <p>Dados Necessários : Brinco, Peso, Raça</p>
                                </div>
                                <div hidden class="input-field col s12">
                                    <i class="material-icons prefix">category</i>
                                    <input id="tipo" name="tipo" value="compra" required>
                                    <label for="tipo">Tipo</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">calendar_today</i>
                                    <input id="data" name="data" type="date" class="validate"
                                           value="{!!  date('Y-m-d') !!}"
                                           required>
                                    <label for="data">Data</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">device_hub</i>
                                    <input id="valorkg" name="valorkg" type="number" step="any" class="validate"
                                           required>
                                    <label for="valorkg">Valor Kg</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">person</i>
                                    <select id="fornecedor" name="fornecedor">
                                        <option value="" selected>Escolha um tipo um Fornecedor</option>
                                        @foreach($fornecedores as $forncedor)
                                            <option  value="{{$forncedor->id}}">{{$forncedor->nome}}</option>
                                        @endforeach
                                    </select>
                                    <label for="fornecedor">Fornecedor</label>
                                </div>
                                <div class="col s12 right">
                                    <button class="btn green right" type="submit"><i class="material-icons left">cloud_upload</i>Carregar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m3"></div>
    </div>
@endsection
