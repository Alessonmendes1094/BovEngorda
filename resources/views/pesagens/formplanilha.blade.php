@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 m3"></div>
        <div class="col s12 m6">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Carregar Dados</span>
                    <div class="row">
                        <div class="col s12">
                            <form action="{{route('pesagem.carregarDados')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>File</span>
                                        <input type="file" name="file" required>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                </div>
                                <div class="col s12 right">
                                    <button class="btn green right" type="submit">  <i class="material-icons left">cloud_upload</i>Carregar</button>
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
