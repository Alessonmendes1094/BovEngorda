@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card">
                <div class="card-content">
                    <h6>Menu</h6>
                    <div class="collection">
                        <a href="{{route('custos.diversos.index')}}"
                           class="collection-item {{ (request()->is('*/diversos') or request()->is('*/diversos/*'))  ? 'active' : '' }}">Diversos</a>
                        <a href="{{route('custos.vacinas.index')}}"
                           class="collection-item {{ (request()->is('*/vacinas') or request()->is('*/vacinas/*'))  ? 'active' : '' }}">Vacinas</a>
                        <a href="{{route('custos.baixas.index')}}"
                           class="collection-item {{ (request()->is('*/baixas') or request()->is('*/baixas/*'))  ? 'active' : '' }}">Baixas Animais</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 l9">
            @yield('content_tabela')
        </div>
    </div>
@endsection
