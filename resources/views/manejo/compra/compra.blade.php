@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 ">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Compra</span>
                    <form method="POST" action="{{route('compra.save')}}">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id" value="{!! isset($manejo) ? $manejo->id : null !!}">
                            <input type="hidden" name="tipo" value="compra">
                            <div class="col s12 m3">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">calendar_today</i>
                                    <input id="data" name="data" type="date" class="validate"
                                           value="{!! isset($manejo) ? $manejo->data : date('Y-m-d') !!}"
                                           required>
                                    <label for="data">Data</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">device_hub</i>
                                    <input id="valorkg" name="valorkg" type="number" step="any" class="validate"
                                           value="{!! isset($manejo) ? $manejo->valorkg : 0 !!}" required>
                                    <label for="valorkg">Valor Kg</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">person</i>
                                    <select id="fornecedor" name="fornecedor" required>
                                        <option value="" disabled selected>Selecione um Fornecedor</option>
                                        @foreach($fornecedores as $fornecedor)
                                            <option
                                                @if(isset($manejo) and $manejo->fornecedor_id == $fornecedor->id)selected
                                                @endif  value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
                                        @endforeach
                                    </select>
                                    <label for="fornecedor">Fornecedor</label>
                                </div>
                                <div class="col s12 right">
                                    <button type="submit" class="btn green white-text right">
                                        <i class="material-icons left">save</i>Salvar Compra
                                    </button>
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

            inputsBrinco = document.querySelectorAll('.brinco');
            inputsBrinco.forEach((input) => {
                input.addEventListener('change', (event) => {
                    $.ajax({
                        url: "{{route('api.verifyAnimalByBrinco', "")}}/"+input.value+ "",
                    }).done((data) => {
                        if(typeof data.brinco !== "undefined"){
                            input.value = "";
                            input.focus();
                            alert("Brinco já cadastrado ! Cadastre Outro");
                        }
                    });
                });
            });
        }
        addEventChangeValor();


        const btnAddBoi = document.querySelector('.btnAddBoi');
        qtdBois = 0;
        btnAddBoi.addEventListener('click', (event) => {
            event.preventDefault();
            qtdBois++;
            const divBois = document.querySelector('.bois');
            const template = document.createElement('div');
            template.classList.add("col");
            template.classList.add("s12");
            template.innerHTML = `<div class="input-field col s3">
                        <i class="material-icons prefix ">fingerprint</i>
                        <input id="brinco[${qtdBois}]" name="animal[${qtdBois}][brinco]" type="text"  class="validate brinco"
                               required>
                        <label for="brinco[${qtdBois}]">Brinco</label>
                    </div>
                    <div class="input-field col s3">
                        <i class="material-icons prefix ">horizontal_split</i>
                        <input id="peso[${qtdBois}]" name="animal[${qtdBois}][peso]" type="number" step="any" class="validate peso" required>
                        <label for="peso[${qtdBois}]">Peso</label>
                    </div>
                    <div class="input-field col s3 valordiv">
                        <i class="material-icons prefix ">money</i>
                        <input id="valor[${qtdBois}]" name="animal[${qtdBois}][valor]" type="number" step="any" class="validate" required>
                        <label for="valor[${qtdBois}]">Valor</label>
                    </div>
                    <div class="col s2 divBtnRemov">
                            <button class="btn btn-small red btnRemovBoi"> <i class="material-icons ">delete</i></button>
                        </div>`;
            divBois.appendChild(template);
            atualizaBtns();
            addEventChangeValor();
        });
        atualizaBtns();

        function atualizaBtns() {
            btnRemovesBoi = document.querySelectorAll('.btnRemovBoi');
            btnRemovesBoi.forEach((btn) => {
                btn.addEventListener('click', (event) => {
                    event.preventDefault();
                    divBoi = btn.parentNode.parentNode;
                    btn.parentNode.parentNode.parentNode.removeChild(divBoi);
                });
            });
        }
    </script>
@endsection
