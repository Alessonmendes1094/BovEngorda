@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l10">
            <div class="card" style="overflow:scroll;overflow:auto">
                <div class="card-content">
                    <span class="card-title">Cadastro de Pesagens</span>
                    <form action="{{route('pesagem.save')}}" method="POST">
                        @csrf
                        <table>
                            <thead>
                            <tr>
                                <th>Brinco</th>
                                <th>Raça</th>
                                <th>Lote</th>
                                <th>Data</th>
                                <th>Peso</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($animais as $animal)
                                <tr>
                                    <td>{{$animal->brinco}}</td>
                                    <td>{{isset($animal->raca) ? $animal->raca->nome : '' }}</td>
                                    <td class="input-field">
                                        <select id="lote[{{$animal->id}}]" name="lote[{{$animal->id}}]">
                                            <option value="" selected>Escolha o Lote</option>
                                            @foreach($lotes as $lote)
                                                <option @if($lote->id ==  $animal->id_lote) selected
                                                        @endif value="{{$lote->id}}">{{$lote->nome}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-field">
                                            <input id="date[{{$animal->id}}]" name="date[{{$animal->id}}]" type="date"
                                                   value="{{( date("Y-m-d"))}}"
                                                   class="validate" required>
                                            <label for="date[{{$animal->id}}]">Data</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field">
                                            <input id="peso[{{$animal->id}}]" name="peso[{{$animal->id}}]" type="number"
                                                   class="validate" required>
                                            <label for="peso[{{$animal->id}}]">Peso</label>
                                        </div>
                                    </td>

                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row ">
                            <div class="col s12 right">
                                <button type="submit" class="btn green right">Salvar Pessagens</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
