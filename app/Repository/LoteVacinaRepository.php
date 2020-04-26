<?php


namespace App\Repository;

use App\Vacina;
use App\loteVacina;
use App\Lote;
use Illuminate\Http\Request;

class LoteVacinaRepository
{
    public function save(Request $request, $id)
    {
        $vacina = loteVacina::find($request->input('id'));
        if (!isset($vacina)) {
            $vacina = new loteVacina();
        }
        $vacina->vacina_id = $request->input('vacina');
        $vacina->lote_id = $id;
        $vacina->dosagem = $request->input('dosagem');
        $vacina->save();
    }

    public function validaVacina(Request $request)
    {
        $dosagem = $request->all();
        $valid = [
            'dosagem' => 'required|numeric|min:0.0001|max:2',
            'vacina' => 'required|numeric|min:1',
        ];
        $messages = [
            'required' => 'O campo é de preenchimento obrigatório!',
            'min' => 'Quantidade Incorreta!, Valor minimo 0,0001 Lt',
            'max' => 'Quantidade Incorreta!, Valor maximo 2 Lt',
        ];

        $validacao = Validator($dosagem, $valid, $messages)->validate();

    }

    public function findAll($id)
    {
        return Lote::find($id)->vacinas()->get();
    }

    public function All()
    {
        return Lote::all();
    }

    public function findById($id)
    {
        return loteVacina::find($id);
    }

    public function deleteById($id)
    {
        loteVacina::destroy($id);
    }

    public function findWithOutPaginate()
    {
        return Lote::select('id', 'nome')->get();
    }

    public function findHistoricoByAnimal($animal)
    {
        return HistoricoLotes::
        join('lotes', 'id_lote', '=', 'lotes.id')
            ->where('id_animal', '=', $animal->id)->get();
    }
}
