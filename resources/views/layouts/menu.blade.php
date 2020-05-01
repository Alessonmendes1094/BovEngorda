@section('li')
<li><a href="{{route('home')}}" class=" tab modulo {{ (request()->is('/'))  ? 'active' : '' }} ">
        <i class="material-icons left">home</i>
        <span>Painel</span>
    </a>
</li>
<li><a href="{{route('fornecedor.index')}}" class="tab {{ (request()->is('tabelas/*'))  ? 'active' : '' }} ">
        <i class="material-icons left">table_chart</i>
        <span>Tabelas</span>
    </a>
</li>
<li><a href="{{route('animal.index')}}" class="tab {{ (request()->is('animais') or request()->is('animais/*'))  ? 'active' : '' }} ">
        <i class="material-icons left">folder_open</i>
        <span>Animais</span>
    </a>
</li>
<li><a href="{{route('pesagem.index')}}" class="tab modulo {{ (request()->is('pesagem') or request()->is('pesagem/*'))  ? 'active' : '' }} ">
        <i class="material-icons left">fitness_center</i>
        <span>Pesagem</span>
    </a>
</li>
<li><a class="tab" href="{{route('compra.index')}}">
        <i class="material-icons left">add_shopping_cart</i>
        <span>Compras</span>
    </a>
</li>
<li><a class="tab" href="{{route('venda.index')}}">
        <i class="material-icons left">local_grocery_store</i>
        <span>Vendas</span>
    </a>
</li>
<li><a class="tab" href="{{route('custos.diversos.index')}}">
        <i class="material-icons left">money_off</i>
        <span>Custos</span>
    </a>
</li>
<li>
    <a href="{{route('financeiro.index')}}" class="tab modulo {{ (request()->is('financeiro') or request()->is('financeiro/*'))  ? 'active' : '' }} ">
        <i class="material-icons left">attach_money</i>
        <span>Financeiro</span>
    </a>
</li>
<li>
    <a href="{{route('relatorios.index')}}" class="tab modulo {{ (request()->is('relatorios') or request()->is('relatorios/*'))  ? 'active' : '' }} ">
        <i class="material-icons left">bar_chart</i>
        <span>Relatórios</span>
    </a>
</li>
<li><a class="tab" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Sair
        <i class="material-icons left">exit_to_app</i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
@endsection
