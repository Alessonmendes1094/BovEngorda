<?php


namespace App\Repository;


use App\Animal;
use App\Fornecedor;
use App\Lote;
use App\Raca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalRepository
{

    public function findAll(Request $request)
    {
        return Animal::where($this->buildFiltro($request))
            ->with('raca')
            ->with('lote')
            ->paginate(250);
    }

    public function All()
    {
        return Animal::all();
    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $animal = Animal::find($id);
        if (!isset($animal)) {
            $animal = new Animal();
        }
        $animal->brinco = $request->input('brinco');
        $animal->nome = $request->input('nome');
        $animal->sexo = $request->input('sexo');
        $animal->id_lote = $request->input('lote');
        $animal->id_raca = $request->input('raca');
//        $animal->id_tipobaixa = $request->input('tipobaixa');
        $animal->save();
    }

    public function findById($id)
    {
        return Animal::find($id);
    }

    public function deleteById($id)
    {
        Animal::destroy($id);
    }

    private function buildFiltro(Request $request)
    {
        $filtro = array();
        $brinco = $request->input("brinco");
        if (isset($brinco)) {
            array_push($filtro, ['brinco', 'like', '%' . $brinco . '%']);
        }
        $lote = $request->input("lote");
        if (isset($lote)) {
            array_push($filtro, ['id_lote', '=', $lote]);
        }
        $raca = $request->input("raca");
        if (isset($raca)) {
            array_push($filtro, ['id_raca', '=', $raca]);
        }
        $tipoBaixa = $request->input("tipoBaixa");
        if (isset($tipoBaixa)) {
            if($tipoBaixa != 'todos'){
                array_push($filtro, ['id_tipobaixa', '=', $tipoBaixa]);
            }
        }else{
            array_push($filtro, ['id_tipobaixa', '=', NULL]);
        }
        $sexo = $request->input("sexo");
        if (isset($sexo)) {
            array_push($filtro, ['sexo', '=', $sexo]);
        }

        return $filtro;
    }

    public function importByPlanilha($dados, Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($dados as $row) {
                $animal = Animal::where('brinco', '=', $row[$request->input('brinco')])->first();
                $animal = is_null($animal) ? new Animal() : $animal;
                $animal->brinco = $row[$request->input('brinco')];

                $nome = $request->input('nome');
                if (isset($nome)) {
                    $animal->nome = $row[$request->input('nome')];
                }

                // verefica se existe o lote se não existe cadastro um novo
                $colunaLote = $request->input('lote');
                if (isset($colunaLote)) {
                    $lote = Lote::where('nome', '=', $row[$colunaLote])->first();
                    $lote = is_null($lote) ? new Lote() : $lote;
                    $lote->nome = $row[$colunaLote];
                    $lote->save();
                    $animal->id_lote = $lote->id;
                }

                // verefica se existe o raca se não existe cadastro uma nova
                $colunaRaca = $request->input('raca');
                if (isset($colunaRaca)) {
                    $raca = Raca::where('nome', '=', $row[$colunaRaca])->first();
                    $raca = is_null($raca) ? new Raca() : $raca;
                    $raca->nome = $row[$colunaRaca];
                    $raca->save();
                    $animal->id_raca = $raca->id;
                }

                // verefica se existe o Fonecedor se não existir ele cadastro um novo
                $colunaFornecedor = $request->input('fornecedor');
                if (isset($colunaFornecedor)) {
                    $fornecedor = Fornecedor::where('nome', '=', $row[$colunaFornecedor])->first();
                    $fornecedor = is_null($fornecedor) ? new Fornecedor() : $fornecedor;
                    $fornecedor->nome = $row[$colunaFornecedor];
                    $fornecedor->save();
                    $animal->id_fornecedor = $fornecedor->id;
                }

                $animal->save();
            }
            DB::commit();
            return array(true, 'Importação Realziada com Sucesso');
        } catch (\Exception $exception) {
            DB::rollBack();
            return array(true, 'Ocorreu um erro: ' . $exception->getMessage());
        }
    }

    public function findAllByCheck($animaisCheckded)
    {
        $ids = array_keys($animaisCheckded);
        return Animal::whereIn('id', $ids)->get();
    }

    public function getTotalAnimais()
    {
        return DB::table('animais')->count();
    }

    public function getTotalAnimaisPorRaca()
    {
        return Animal::join('racas', 'animais.id_raca', '=', 'racas.id')
            ->select('racas.nome', DB::raw('count(*) as total'))
            ->groupBy('racas.nome')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['nome'] => $item['total']];
            });
    }

    public function getTotalAnimaisPorLote()
    {
        return Animal::join('lotes', 'animais.id_lote', '=', 'lotes.id')
            ->select('lotes.nome', DB::raw('count(*) as total'))
            ->groupBy('lotes.nome')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['nome'] => $item['total']];
            });
    }

    public function findByBrinco($brinco)
    {
        return Animal::where('brinco', '=', $brinco)->first();
    }

    public function validacaoAnimal(Request $request){
        $dados = $request->all();
        
        //Validação Formulário
        $valid = [
            'brinco' => 'required|unique:animais|min:0|max:5',
            'peso'       => 'required|numeric|min:1|max:1100',
        ];
        $messages = [
            'unique' => 'Brinco já cadastrado, verifique!',
            'required' => 'O campo é de preenchimento obrigatório!',
            'min'      => 'Valor menor que o permitido!',
            'max'      => 'Valor maior que o permitido!',
        ];
        $validacao = Validator($dados, $valid, $messages)->validate();
    }
}
