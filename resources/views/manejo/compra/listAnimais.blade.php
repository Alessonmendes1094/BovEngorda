@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Filtro</span>
                    <form method="GET" action="{{route('compra.novaVendaShowAnimais')}}">
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
