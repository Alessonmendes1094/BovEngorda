@extends('tabelas.layout')

@section('content_tabela')
<div class="row">
    <div class="col s12">
        <div class="card" style="overflow:scroll;overflow:auto">
            <div class="card-content">
                <span class="card-title">Novo Custo Diversos</span>
                <div class="row">
                    <div class="col s12 right">
                        <a class="btn green white-text right" href="{{route('custos.diversos.index')}}"><i class="material-icons">arrow_back</i>Voltar</a>
                    </div>
                    <div class="col s12">
                        <div class="row ">
                            <div class="col l2"></div>
                            <form action="{{route('custos.diversos.animaisShowForm')}}" method="POST">
                                @csrf
                                <div class="card-content">
                                    <span class="card-title">Selecione os animais que serão vinculados ao custo</span>
                                    <div class="col s12 right btnacoes">

                                        <button class="btn green white-text right"><i class="material-icons right">add</i>Gravar Animais Selecionados
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
                                                                    <input name="check[{{$animal->id}}]" type="checkbox" />
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

                                                <button class="btn green white-text right"><i class="material-icons right">add</i>Gravar Animais Selecionados
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
