@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Resumo</span>
                <div class="row">
                    <div class="col s12 center-align">
                        <h5 class="center-align">Total de Animais: {{$totalAnimais}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6">
                        @if(isset($chartAnimaisPorLote))
                            {!! $chartAnimaisPorLote->container() !!}
                        @endif
                    </div>
                    <div class="col s6">
                        @if(isset($chartAnimaisPorRaca))
                            {!! $chartAnimaisPorRaca->container() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    @if(isset($chartAnimaisPorLote))
        {!! $chartAnimaisPorLote->script() !!}
    @endif
    @if(isset($chartAnimaisPorRaca))
        {!! $chartAnimaisPorRaca->script() !!}
    @endif
@endsection
