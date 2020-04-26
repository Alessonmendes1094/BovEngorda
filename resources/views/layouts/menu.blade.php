@section('li')
    <li><a href="{{route('home')}}" class="modulo {{ (request()->is('/'))  ? 'active' : '' }} ">
            <i class="material-icons left">home</i>
            <span>Painel</span>
        </a>
    </li>
    <li><a href="{{route('fornecedor.index')}}"
           class=" {{ (request()->is('tabelas/*'))  ? 'active' : '' }} ">
            <i class="material-icons left">table_chart</i>
            <span>Tabelas</span>
        </a>
    </li>
    <li><a href="{{route('animal.index')}}"
           class=" {{ (request()->is('animais') or request()->is('animais/*'))  ? 'active' : '' }} ">
            <i class="material-icons left">folder_open</i>
            <span>Animais</span>
        </a>
    </li>
    <li><a href="{{route('pesagem.index')}}"
           class="modulo {{ (request()->is('pesagem') or request()->is('pesagem/*'))  ? 'active' : '' }} ">
            <i class="material-icons left">fitness_center</i>
            <span>Pesagem</span>
        </a>
    </li>
    <li>
        <a href="{{route('manejo.index')}}"
           class="modulo {{ (request()->is('manejo') or request()->is('manejo/*'))  ? 'active' : '' }} ">
            <i class="material-icons left">repeat</i>
            <span>Manejo</span>
        </a>
    </li>
    <li>
        <a href="{{route('financeiro.index')}}"
           class="modulo {{ (request()->is('financeiro') or request()->is('financeiro/*'))  ? 'active' : '' }} ">
            <i class="material-icons left">attach_money</i>
            <span>Financeiro</span>
        </a>
    </li>
    <li>
        <a href="{{route('relatorios.index')}}"
           class="modulo {{ (request()->is('relatorios') or request()->is('relatorios/*'))  ? 'active' : '' }} ">
            <i class="material-icons left">bar_chart</i>
            <span>Relatórios</span>
        </a>
    </li>
@endsection

