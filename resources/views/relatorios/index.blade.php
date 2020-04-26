@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12 l3">
            <div class="card">
                <div class="card-content">
                    <h6>Selecione o Relatorio</h6>
                    <div class="collection">
                        <a href="" data-element="#gmdAnimal" class="filtros collection-item">GMD por Animal - Ativos</a>
                        <a href="" data-element="#gmdAnimal-baixado" class="filtros collection-item">GMD por Animal -
                            Baixados</a>
                        <a href="" data-element="#custo_animais" class="filtros collection-item">Margem de Lucro</a>
                        <a href="" data-element="#compras_animais" class="filtros collection-item">Compras de
                            Animais</a>
                        <a href="" data-element="#vendas_animais" class="filtros collection-item">Vendas de Animais</a>
                        <a href="" data-element="#financeiro_pagar" class="filtros collection-item">Financeiro - Contas
                            a Pagar</a>
                        <a href="" data-element="#financeiro_receber" class="filtros collection-item">Financeiro - Contas
                            a Receber</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s15 l5 painel" id="gmdAnimal" style="display:none">
            <div class="card">
                <div class="card-content">
                    <h6>Filtros GMD por Animal</h6>
                    <div class="row">
                        <form action="{{route('relatorios.gmdAnimal')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="animais" multiple name="animais[]" required>
                                    <option value="" disabled>Escolha os Animais</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($animais as $animal)
                                        <option value="{{$animal->id}}">{{$animal->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="animais">Animais</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="raca" multiple name="racas[]" required>
                                    <option value="" disabled>Escolha os Animais</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($racas as $raca)
                                        <option value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="raca">Raças</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person</i>
                                <select id="fornecedor" multiple name="fornecedores[]" required>
                                    <option value="" disabled>Escolha os Fornecedores</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($fornecedores as $forncedor)
                                        <option value="{{$forncedor->id}}">{{$forncedor->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="fornecedor">Fornecedor</label>
                            </div>
                            <div class="col s12 right">
                                <button type="submit" class="btn green right">Gerar Relatório</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s15 l5 painel" id="gmdAnimal-baixado" style="display:none">
            <div class="card">
                <div class="card-content">
                    <h6>Filtros GMD por Animais Baixados</h6>
                    <div class="row">
                        <form action="{{route('relatorios.gmdAnimal-baixados')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="animais_2" multiple name="animais[]" required>
                                    <option value="" disabled>Escolha os Animais</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($animais as $animal)
                                        <option value="{{$animal->id}}">{{$animal->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="animais_2">Animais</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="raca_2" multiple name="racas[]" required>
                                    <option value="" disabled>Escolha os Animais</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($racas as $raca)
                                        <option value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="raca_2">Raças</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person</i>
                                <select id="fornecedor_2" multiple name="fornecedores[]" required>
                                    <option value="" disabled>Escolha os Fornecedores</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($fornecedores as $forncedor)
                                        <option value="{{$forncedor->id}}">{{$forncedor->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="fornecedor_2">Fornecedor</label>
                            </div>
                            <div class="col s12 right">
                                <button type="submit" class="btn green right">Gerar Relatório</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s15 l5 painel" id="custo_animais" style="display:none">
            <div class="card">
                <div class="card-content">
                    <h6>Filtros Custos por Animal</h6>
                    <div class="row">
                        <form action="{{route('relatorios.custo_Animal')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="animais_3" multiple name="animais[]" required>
                                    <option value="" disabled>Escolha os Animais</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($animais as $animal)
                                        <option value="{{$animal->id}}">{{$animal->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="animais_3">Animais</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="racas_3" multiple name="racas[]" required>
                                    <option value="" disabled>Escolha as Raças</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($racas as $raca)
                                        <option value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="racas_3">Racas</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="fornecedores_3" multiple name="fornecedores[]" required>
                                    <option value="" disabled>Escolha os Fornecedores de Compra</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($fornecedores as $fornecedor)
                                        <option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="fornecedores_3">Fornecedores de Compra</label>
                            </div>
                            <div class="col s12 right">
                                <button type="submit" class="btn green right">Gerar Relatório</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s15 l5 painel" id="compras_animais" style="display:none">
            <div class="card">
                <div class="card-content">
                    <h6>Filtros Compra por Animal</h6>
                    <div class="row">
                        <form action="{{route('relatorios.compras_Animal')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="input-field col s6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="date" id="dataini" name="dataini">
                                <label for="dataini">Data Inicial</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="date" id="datafim" name="datafim">
                                <label for="datafim">Data Final</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="animais_4" multiple name="animais[]" required>
                                    <option value="" disabled>Escolha os Animais</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($animais as $animal)
                                        <option value="{{$animal->id}}">{{$animal->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="animais_4">Animais</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="racas_4" multiple name="racas[]" required>
                                    <option value="" disabled>Escolha as Raças</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($racas as $raca)
                                        <option value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="racas_4">Racas</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="fornecedores_4" multiple name="fornecedores[]" required>
                                    <option value="" disabled>Escolha os Fornecedores de Compra</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($fornecedores as $fornecedor)
                                        <option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="fornecedores_4">Fornecedores de Compra</label>
                            </div>
                            <div class="col s12 right">
                                <button type="submit" class="btn green right">Gerar Relatório</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s15 l5 painel" id="vendas_animais" style="display:none">
            <div class="card">
                <div class="card-content">
                    <h6>Filtros Venda por Animal</h6>
                    <div class="row">
                        <form action="{{route('relatorios.vendas_Animal')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="input-field col s6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="date" id="dataini_2" name="dataini">
                                <label for="dataini_2">Data Inicial</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="date" id="datafim_2" name="datafim">
                                <label for="datafim_2">Data Final</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="animais_5" multiple name="animais[]" required>
                                    <option value="" disabled>Escolha os Animais</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($animais as $animal)
                                        <option value="{{$animal->id}}">{{$animal->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="animais_5">Animais</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="racas_5" multiple name="racas[]" required>
                                    <option value="" disabled>Escolha as Raças</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($racas as $raca)
                                        <option value="{{$raca->id}}">{{$raca->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="racas_5">Racas</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">pets</i>
                                <select id="clientes" multiple name="clientes[]" required>
                                    <option value="" disabled>Escolha os Clientes das Vendas</option>
                                    <optgroup label="Selecionar Todos">
                                        <option value="Todo$">Todos</option>
                                    </optgroup>
                                    @foreach($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="clientes">Clientes das Vendas</label>
                            </div>
                            <div class="col s12 right">
                                <button type="submit" class="btn green right">Gerar Relatório</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s9 l9 painel" id="financeiro_pagar" style="display:none">
            <div class="card">
                <div class="card-content">
                    <h6>Filtros Contas a Pagar</h6>
                    <div class="row">
                        <form action="{{route('relatorios.financeiro_pagar')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="col s6">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="lctoini_1" name="lctoini">
                                    <label for="lctoini_1">Lançamentos De:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="lctofin_1" name="lctofin">
                                    <label for="lctofin_1">Até:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="vencini_1" name="vencini">
                                    <label for="vencini_1">Vencimentos De:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="vencfin_1" name="vencfin">
                                    <label for="vencfin_1">Até</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="pgtoini_1" name="pgtoini">
                                    <label for="pgtoini_1">Pagamentos De:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="pgtofin_1" name="pgtofin">
                                    <label for="pgtofin_1">Até:</label>
                                </div>
                            </div>

                            <div class="col s6">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">bookmark</i>
                                    <input id="documento_1" name="documento">
                                    <label for="documento_1">Documento</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">assignment</i>
                                    <input id="categoria_1" name="categoria">
                                    <label for="categoria_1">Categoria</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">assignment_ind</i>
                                    <input id="fornecedor_1" name="fornecedor">
                                    <label for="fornecedor_1">Fornecedor</label>
                                </div>
                                <div class="col s12 right">
                                    <button type="submit" class="btn green right">Gerar Relatório</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s9 l9 painel" id="financeiro_receber" style="display:none">
            <div class="card">
                <div class="card-content">
                    <h6>Filtros Contas a Receber</h6>
                    <div class="row">
                        <form action="{{route('relatorios.financeiro_receber')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="col s6">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="lctoini_2" name="lctoini">
                                    <label for="lctoini_2">Lançamentos De:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="lctofin_2" name="lctofin">
                                    <label for="lctofin_2">Até:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="vencini_2" name="vencini">
                                    <label for="vencini_2">Vencimentos De:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="vencfin_2" name="vencfin">
                                    <label for="vencfin_2">Até</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="pgtoini" name="pgtoini">
                                    <label for="pgtoini">Pagamentos De:</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">date_range</i>
                                    <input type="date" id="pgtofin_2" name="pgtofin">
                                    <label for="pgtofin_2">Até:</label>
                                </div>
                            </div>

                            <div class="col s6">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">bookmark</i>
                                    <input id="documento_2" type="text" name="documento">
                                    <label for="documento_2">Documento</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">assignment</i>
                                    <input id="categoria_2" type="text" name="categoria">
                                    <label for="categoria_2">Categoria</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">assignment_ind</i>
                                    <input id="fornecedor_5" type="text" name="fornecedor">
                                    <label for="fornecedor_5">Fornecedor</label>
                                </div>
                                <div class="col s12 right">
                                    <button type="submit" class="btn green right">Gerar Relatório</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
