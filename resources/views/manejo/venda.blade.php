@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 ">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Venda</span>
                    <form method="POST" action="{{route('manejo.save')}}">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id">
                            <input type="hidden" name="tipo" value="venda">
                            <div class="col s12 m4">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">calendar_today</i>
                                    <input id="data" name="data" type="date" class="validate"
                                           required value="{{date('Y-m-d') }}">
                                    <label for="data">Data</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">device_hub</i>
                                    <input id="valorkg" name="valorkg" type="number" step="any" class="validate"
                                           required value="0">
                                    <label for="valorkg">Valor Kg</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">person</i>
                                    <select id="cliente" name="cliente" required>
                                        <option value="" disabled selected>Selecione um Cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                        @endforeach
                                    </select>
                                    <label for="cliente">Cliente</label>
                                </div>
                                <div class="col s12 right">
                                    <button type="submit" class="btn green white-text right">
                                        <i class="material-icons left">save</i>Salvar Venda
                                    </button>
                                </div>
                            </div>
                            <div class="col s12 m8">
                                <div class="col s12 right bois">
                                    <?php $count = 0; ?>
                                    @foreach($animais as $animal)
                                        <div class="col s12">
                                            <div class="col s2" style="margin-top: 15px">
                                                <input type="hidden" name="animal[{{$count}}][id]" value="{{$animal->id}}">
                                                <p>Brinco</p>
                                                <p>{{$animal->brinco}}</p>
                                            </div>
                                            <div class="input-field col s4">
                                                <i class="material-icons prefix ">horizontal_split</i>
                                                <input id="peso[{{$count}}]" name="animal[{{$count}}][peso]"
                                                       type="number" step="any"
                                                       class="validate peso"
                                                       required>
                                                <label for="peso[{{$count}}]">Peso</label>
                                            </div>
                                            <div class="input-field col s4 valordiv">
                                                <i class="material-icons prefix ">money</i>
                                                <input id="valor[{{$count}}]" name="animal[{{$count}}][valor]"
                                                       type="number" step="any"
                                                       class="validate"
                                                       required>
                                                <label for="valor[{{$count}}]">Valor</label>
                                            </div>
                                        </div>
                                        <?php $count++; ?>
                                    @endforeach
                                </div>
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
        document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });

        var inputValorKg = document.querySelector('#valorkg');
        inputValorKg.addEventListener('change', function (event) {
            var inputPesos = document.querySelectorAll('.peso');
            inputPesos.forEach((input) => {
                var inputValor = input.parentElement.parentElement.querySelector('.valordiv').querySelector('.valordiv input');
                var valorKg = document.querySelector('#valorkg').value;
                inputValor.value = valorKg * input.value;

            });
        });

        function addEventChangeValor() {
            var inputPesos = document.querySelectorAll('.peso');
            inputPesos.forEach((input) => {
                input.addEventListener('change', function (event) {
                    var inputValor = this.parentElement.parentElement.querySelector('.valordiv').querySelector('.valordiv input');
                    var valorKg = document.querySelector('#valorkg').value;
                    inputValor.value = valorKg * this.value;
                });
            });
        }

        addEventChangeValor();
    </script>
@endsection
