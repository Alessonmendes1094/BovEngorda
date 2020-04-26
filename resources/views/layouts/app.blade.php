<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Boi Engorda</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
@include('layouts.menu')

<ul id="dropdown1" class="dropdown-content">
    <li><a>Bem Vindo {{auth()->user()->name}}</a></li>
    <li><a class="" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sair
            <i class="material-icons left">exit_to_app</i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>
<nav>
    <div class="nav-wrapper">
        <a href="#!" class="brand-logo">BoiEngorda</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            @yield('li')
            <li>
                <a class="dropdown-trigger" href="#!" data-target="dropdown1">Bem Vindo {{auth()->user()->name}}
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    @yield('li')
    <li><a class="" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sair
            <i class="material-icons left">exit_to_app</i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>

<div class="container">
    @if(Session::has('success'))
        <div class="card-panel green lighten-2">
            {{session::get('success')}}
        </div>
    @endif
    @if(Session::has('erro'))
        <div class="card-panel red lighten-2">
            {{session::get('erro')}}
        </div>
    @endif
    @yield('content')
</div>

</div>
<div id="divcarregando">
    <img src="{{asset('gif/carregando.gif')}}">
</div>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.sidenav').sidenav();
        $(".dropdown-trigger").dropdown();

    });
        @if(session()->has('status'))
    var toastHTML = '<span>{{session('status')}}</span>';
    M.toast({html: toastHTML});
    @endif

    $(function () {
        $(".filtros").click(function (e) {
            $('.painel').hide('slow');
            e.preventDefault();
            el = $(this).data('element');
            $(el).toggle(800);
        });
        setTimeout(function () {
            $('.card-panel').fadeOut();
        }, 5000);
    });
</script>
@yield('scripts')
</body>
</html>

