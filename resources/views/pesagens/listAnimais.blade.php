@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Filtro</span>
                    <form method="GET" action="{{route('pesagem.listAnimais')}}">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="brinco" name="brinco" value="{{request()->query('brinco')}}" type="text"
                                       class="validate">
                                <label for="brinco">Brinco</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="lote">
                                    <option value="" selected>Escolha o Lote</option>
                                    @foreach($lotes as $lote)
                                        <option @if(request()->query('lote') == $lote->id) selected
                                                @endif value="{{$lote->id}}">{{$lote->nome}}</option>
                                    @endforeach
                                </select>
                                <label>Lote</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="raca">
                                    <option value="" selected>Escolha a Raca</option>
                                    @foreach($racas as $raca)
                                        <option @if(request()->query('raca') == $raca->id) selected
                                                @endif value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label>Raca</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="sexo">
                                    <option value="" selected>Escolha o Sexo</option>
                                    <option @if(request()->query('sexo') == "M") selected @endif value="M">Masculino
                                    </option>
                                    <option @if(request()->query('sexo') == "F") selected @endif  value="F">Feminino
                                    </option>
                                </select>
                                <label>Sexo</label>
                            </div>
                            <div class="col s12 right">
                                <button class="btn blue-grey right"><i class="material-icons right">search</i> Pesquisar
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col s12 l9">
            <div class="card">
                <form action="{{route('pesagem.listAnimaisRequest')}}" method="POST">
                    @csrf
                    <div class="card-content">
                        <span class="card-title">Selecione os animais que serão pesados</span>
                        <div class="col s12 right btnacoes">

                            <button class="btn green white-text right"><i
                                    class="material-icons right">add</i>Cadastrar Peso dos Animais Selecionados
                            </button>
                        </div>
                        <div class="row">
                            <div class="col s12 ">

                                <table>
                                    <thead>
                                    <tr>
                                        <th>Brinco</th>
                                        <th>Raça</th>
                                        <th>Lote</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($animais as $animal)
                                        <tr>
                                            <td>
                                                <p>
                                                    <label>
                                                        <input name="check[{{$animal->id}}]" type="checkbox"/>
                                                        <span>{{$animal->brinco}}</span>
                                                    </label>
                                                </p>
                                            </td>
                                            <td>{{isset($animal->raca) ? $animal->raca->nome : '' }}</td>
                                            <td>{{isset($animal->lote) ? $animal->lote->nome : '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <?php echo $animais->appends(['brinco' => request()->query('brinco')],
                                    ['sexo' => request()->query('sexo')],
                                    ['lote' => request()->query('lote')],
                                    ['raca' => request()->query('raca')])->render(); ?>
                                <div class="col s12 right btnacoes">

                                    <button class="btn green white-text right"><i
                                            class="material-icons right">add</i>Cadastrar Peso dos Animais Selecionados
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        btnsdDelete = document.querySelectorAll('.btnDelete');
        btnsdDelete.forEach((btn) => {
            btn.addEventListener('click', function () {
                var resposta = confirm('Tem certeza que deseja apagar esse Animal ?');
                if (resposta) {
                    document.location.href = btn.getAttribute('data-content');
                }
            });
        })
    </script>
@endsection
