@extends('layouts.app')

@section('content')
    <div class="row ">
        <div class="col s12 m5">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Dados da Tabela</span>
                    <div class="row">
                        <div class="col s12">
                            <form id="formexcel" method="POST" action="{{route('animal.importarDados')}}">
                                @csrf
                                <input hidden name="dados" value="{{json_encode($dados)}}">
                                <div class="col s12">
                                    <label>Brinco<span class="red-text">*</span></label>
                                    <select class="browser-default" name="brinco" required>
                                        <option value="" disabled selected>Escolha a Coluna</option>
                                        <?php $indexCollumn = 0 ?>
                                        @foreach($dados[0] as $collumn)
                                            <option value="{{$indexCollumn}}">Coluna {{$indexCollumn + 1}}</option>
                                            <?php $indexCollumn++ ?>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col s12">
                                    <label>Nome</label>
                                    <select class="browser-default" name="nome">
                                        <option value=""  selected>Escolha a Coluna</option>
                                        <?php $indexCollumn = 0 ?>
                                        @foreach($dados[0] as $collumn)
                                            <option value="{{$indexCollumn}}">Coluna {{$indexCollumn + 1}}</option>
                                            <?php $indexCollumn++ ?>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col s12">
                                    <label>Lote</label>
                                    <select class="browser-default" name="lote">
                                        <option value=""  selected>Escolha a Coluna</option>
                                        <?php $indexCollumn = 0 ?>
                                        @foreach($dados[0] as $collumn)
                                            <option value="{{$indexCollumn}}">Coluna {{$indexCollumn + 1}}</option>
                                            <?php $indexCollumn++ ?>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col s12">
                                    <label>Raca</label>
                                    <select class="browser-default" name="raca">
                                        <option value=""  selected>Escolha a Coluna</option>
                                        <?php $indexCollumn = 0 ?>
                                        @foreach($dados[0] as $collumn)
                                            <option value="{{$indexCollumn}}">Coluna {{$indexCollumn + 1}}</option>
                                            <?php $indexCollumn++ ?>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col s12">
                                    <label>Fornecedor</label>
                                    <select class="browser-default" name="fornecedor">
                                        <option value=""  selected>Escolha a Coluna</option>
                                        <?php $indexCollumn = 0 ?>
                                        @foreach($dados[0] as $collumn)
                                            <option value="{{$indexCollumn}}">Coluna {{$indexCollumn + 1}}</option>
                                            <?php $indexCollumn++ ?>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col s12 right">
                                    <button type="submit" class="btn btnSubmit blue right">Importar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m7">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Dados da Tabela</span>
                    <div class="row">
                        <div class="col s12">
                            @if(count($dados) > 0 and count($dados[0]) > 0)
                                <table>
                                    <thead>
                                    <tr>
                                        <?php $indexCollumn = 1 ?>
                                        @foreach($dados[0] as $collumn)
                                            <th>Coluna <?php echo $indexCollumn ?></th>
                                            <?php $indexCollumn++ ?>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($dados as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td>{{$cell}}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('.btnSubmit').on('click', () =>{
                const form = document.getElementById("formexcel");
                if(form.checkValidity()){
                    $('#divcarregando').css("display", "flex");
                }
            });

        });
    </script>
@endsection
