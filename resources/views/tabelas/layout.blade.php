@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <h6>Menu</h6>
                    <div class="collection">
                        <a href="{{route('fornecedor.index')}}"
                           class="collection-item {{ (request()->is('*/fornecedor') or request()->is('*/fornecedor/*'))  ? 'active' : '' }}">Fornecedores</a>
                        <a href="{{route('cliente.index')}}"
                           class="collection-item {{ (request()->is('*/cliente') or request()->is('*/cliente/*'))  ? 'active' : '' }}">Clientes</a>
                        <a href="{{route('lote.index')}}"
                           class="collection-item {{ (request()->is('*/lote') or request()->is('*/lote/*'))  ? 'active' : '' }}">Lotes</a>
                        <a href="{{route('raca.index')}}"
                           class="collection-item {{ (request()->is('*/raca') or request()->is('*/raca/*'))  ? 'active' : '' }}">Raças</a>
                        <a href="{{route('vacina.index')}}"
                           class="collection-item {{ (request()->is('*/vacina') or request()->is('*/vacina/*'))  ? 'active' : '' }}">Vacinas</a>
                        <a href="{{route('tipobaixa.index')}}"
                           class="collection-item {{ (request()->is('*/tipobaixas') or request()->is('*/tipobaixas/*'))  ? 'active' : '' }}">Tipos de Baixas</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 l9">
            @yield('content_tabela')
        </div>
    </div>
@endsection
