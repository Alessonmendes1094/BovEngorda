<?php

namespace App\Http\Controllers\Tabelas;

use App\Http\Controllers\Controller;
use App\Repository\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $clienteRepository;
    public function __construct()
    {
        $this->clienteRepository = new ClienteRepository();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clientes = $this->clienteRepository->findAll($request);
        return view('tabelas.cliente.index', compact('clientes'));
    }

    public function showFormCliente(){
        return view('tabelas.cliente.cliente');
    }

    public function save(Request $request){
        $this->clienteRepository->save($request);
        session()->flash('status', 'Cliente Salvo');
        return redirect()->route('cliente.index');
    }

    public function showFormClienteForEdit($id){
        $cliente = $this->clienteRepository->findById($id);
        return view('tabelas.cliente.cliente', compact('cliente'));
    }

    public function delete($id){
        $this->clienteRepository->deleteById($id);
        session()->flash('status', 'Cliente Apagado');
        return redirect()->route('cliente.index');
    }
}
