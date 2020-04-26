<?php

use Illuminate\Support\Facades\Route;

//Auth::routes();
// Authentication Routes...

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'tabelas'], function(){
    Route::get('/fornecedor', 'Tabelas\FornecedorController@index')->name('fornecedor.index');
    Route::get('/fornecedor/add', 'Tabelas\FornecedorController@showFormFornecedor')->name('fornecedor.showformfornecedor');
    Route::get('/fornecedor/edit/{id}', 'Tabelas\FornecedorController@showFormFornecedorForEdit')->name('fornecedor.showFormFornecedorForEdit');
    Route::get('/fornecedor/delelete/{id}', 'Tabelas\FornecedorController@delete')->name('fornecedor.delete');
    Route::post('/fornecedor/add', 'Tabelas\FornecedorController@save')->name('fornecedor.save');

    Route::get('/vacina', 'Tabelas\VacinaController@index')->name('vacina.index');
    Route::get('/vacina/add', 'Tabelas\VacinaController@showFormVacina')->name('vacina.showformVacina');
    Route::get('/vacina/edit/{id}', 'Tabelas\VacinaController@showFormVacinaForEdit')->name('vacina.showformVacinaForEdit');
    Route::get('/vacina/delelete/{id}', 'Tabelas\VacinaController@delete')->name('vacina.delete');
    Route::post('/vacina/add', 'Tabelas\VacinaController@save')->name('vacina.save');

    Route::get('/cliente', 'Tabelas\ClienteController@index')->name('cliente.index');
    Route::get('/cliente/add', 'Tabelas\ClienteController@showFormCliente')->name('cliente.showformcliente');
    Route::get('/cliente/edit/{id}', 'Tabelas\ClienteController@showFormClienteForEdit')->name('fornecedor.showFormClienteForEdit');
    Route::get('/cliente/delelete/{id}', 'Tabelas\ClienteController@delete')->name('cliente.delete');
    Route::post('/cliente/add', 'Tabelas\ClienteController@save')->name('cliente.save');

    Route::get('/lote', 'Tabelas\LoteController@index')->name('lote.index');
    Route::get('/lote/add', 'Tabelas\LoteController@showFormLote')->name('lote.showFormLote');
    Route::get('/lote/edit/{id}', 'Tabelas\LoteController@showFormLoteForEdit')->name('lote.showFormLoteForEdit');
    Route::get('/lote/delelete/{id}', 'Tabelas\LoteController@delete')->name('lote.delete');
    Route::post('/lote/add', 'Tabelas\LoteController@save')->name('lote.save');

    Route::get('/lote/{id}/vacinas', 'Tabelas\LoteController@indexVacina')->name('lote.indexVacina');
    Route::get('/lote/vacinas/add/{id}', 'Tabelas\LoteController@showFormVacina')->name('lote.showFormVacina');
    Route::get('/lote/vacinas/edit/{id}', 'Tabelas\LoteController@showFormVacinaForEdit')->name('lote.showFormVacinaForEdit');
    Route::get('/lote/vacinas/delelete/{id}', 'Tabelas\LoteController@deleteVacina')->name('lote.deleteVacina');
    Route::post('/lote/vacinas/add{id}', 'Tabelas\LoteController@saveVacina')->name('lote.saveVacina');

    Route::get('/raca', 'Tabelas\RacasController@index')->name('raca.index');
    Route::get('/raca/add', 'Tabelas\RacasController@showFormRaca')->name('raca.showFormRaca');
    Route::get('/raca/edit/{id}', 'Tabelas\RacasController@showFormRacaForEdit')->name('raca.showFormRacaForEdit');
    Route::get('/raca/delelete/{id}', 'Tabelas\RacasController@delete')->name('raca.delete');
    Route::post('/raca/add', 'Tabelas\RacasController@save')->name('raca.save');

    Route::get('/tipopesos', 'Tabelas\TiposPesosController@index')->name('tipopeso.index');
    Route::get('/tipopesos/add', 'Tabelas\TiposPesosController@showFormTipoPeso')->name('tipopeso.showFormTipoPeso');
    Route::get('/tipopesos/edit/{id}', 'Tabelas\TiposPesosController@showFormTipoPesosForEdit')->name('tipopeso.showFormTipoPesosForEdit');
    Route::get('/tipopesos/delelete/{id}', 'Tabelas\TiposPesosController@delete')->name('tipopeso.delete');
    Route::post('/tipopesos/add', 'Tabelas\TiposPesosController@save')->name('tipopeso.save');

    Route::get('/tipobaixas', 'Tabelas\TipoBaixasController@index')->name('tipobaixa.index');
    Route::get('/tipobaixas/add', 'Tabelas\TipoBaixasController@showformTipoBaixa')->name('tipobaixa.showformTipoBaixa');
    Route::get('/tipobaixas/edit/{id}', 'Tabelas\TipoBaixasController@showFormTipoBaixaForEdit')->name('tipobaixa.showFormTipoBaixaForEdit');
    Route::get('/tipobaixas/delelete/{id}', 'Tabelas\TipoBaixasController@delete')->name('tipobaixa.delete');
    Route::post('/tipobaixas/add', 'Tabelas\TipoBaixasController@save')->name('tipobaixa.save');
});

Route::group(['prefix' => 'animais'], function(){
    Route::get('/', 'AnimalController@index')->name('animal.index');
    Route::get('/api/verify/{brinco}', 'AnimalController@verifyAnimalByBrinco')->name('api.verifyAnimalByBrinco');
    Route::get('/add', 'AnimalController@showFormAnimal')->name('animal.showFormAnimal');
    Route::post('/add', 'AnimalController@save')->name('animal.save');
    Route::get('/add/carregardados', 'AnimalController@showFormcarregarDados')->name('animal.showFormcarregarDados');
    Route::post('/add/carregardados', 'AnimalController@carregarDados')->name('animal.carregarDados');
    Route::post('/add/importardados', 'AnimalController@importarDados')->name('animal.importarDados');
    Route::get('/edit/{id}', 'AnimalController@showFormAnimalForEdit')->name('animal.showFormAnimalForEdit');
    Route::get('/delelete/{id}', 'AnimalController@delete')->name('animal.delete');
    Route::get('/buscar/bois/autocomplete' , 'AnimalController@autocomplete')->name('animal.autocomplete');
});

Route::group(['prefix' => 'pesagem'], function(){
    Route::get('/', 'PesagemController@index')->name('pesagem.index');
    Route::get('/listAnimais', 'PesagemController@listAnimais')->name('pesagem.listAnimais');
    Route::get('/cadastroPeso', 'PesagemController@cadastroPeso')->name('pesagem.cadastroPeso');
    Route::post('/listAnimais', 'PesagemController@listAnimaisRequest')->name('pesagem.listAnimaisRequest');
    Route::post('/add', 'PesagemController@save')->name('pesagem.save');
    Route::post('/salvar', 'PesagemController@salvar')->name('pesagem.salvar');
    Route::get('/delelete/{id}', 'PesagemController@delete')->name('pesagem.delete');

    Route::get('/add/carregardados', 'PesagemController@showFormcarregarDados')->name('pesagem.showFormcarregarDados');
    Route::post('/add/carregardados', 'PesagemController@carregarDados')->name('pesagem.carregarDados');
    Route::post('/add/importardados', 'PesagemController@importarDados')->name('pesagem.importarDados');
});

Route::group(['prefix' => 'manejo'], function(){
    Route::get('/', 'ManejoController@index')->name('manejo.index');
    Route::get('/novo/venda', 'ManejoController@novaVendaShowAnimais')->name('manejo.novaVendaShowAnimais');
    Route::post('/novo/venda/form', 'ManejoController@novaVendaShowForm')->name('manejo.novaVendaShowForm');
    Route::get('/novo/compra', 'ManejoController@novaCompra')->name('manejo.novaCompra');
    Route::get('/edit/manejo/{id}', 'ManejoController@edit')->name('manejo.edit');
    Route::post('/novo/manejo', 'ManejoController@save')->name('manejo.save');
    Route::get('/delete/{id}', 'ManejoController@delete')->name('manejo.delete');
    Route::get('/{id}', 'ManejoController@edit')->name('manejo.edit');

    Route::get('/add/carregardados', 'ManejoController@showFormcarregarDados')->name('manejo.showFormcarregarDados');
    Route::post('/add/carregardados', 'ManejoController@carregarDados')->name('manejo.carregarDados');
    Route::post('/add/importardados', 'ManejoController@importarDados')->name('manejo.importarDados');
});

Route::group(['prefix' => 'financeiro'], function() {
    Route::get('/', 'FinanceiroController@index')->name('financeiro.index');
    Route::get('/novaentrada', 'FinanceiroController@showFormEntrada')->name('financeiro.showFormEntrada');
    Route::get('/novasaida', 'FinanceiroController@showFormSaida')->name('financeiro.showFormSaida');
    Route::post('/save', 'FinanceiroController@save')->name('financeiro.save');
    Route::get('/edit/{id}', 'FinanceiroController@edit')->name('financeiro.edit');
    Route::get('/delete/{id}', 'FinanceiroController@delete')->name('financeiro.delete');
});

Route::group(['prefix' => 'relatorios'], function() {
    Route::get('/', 'RelatoriosControlller@index')->name('relatorios.index');
    Route::post('/gmdadnimal', 'RelatoriosControlller@gmdAnimal')->name('relatorios.gmdAnimal');
    Route::get('/gmdadnimal/excel/{request}/{req2}/{req3}', 'RelatoriosControlller@gmdAnimalExcel')->name('relatorios.gmdAnimal.excel');

    Route::post('/gmdadnimal/baixados', 'RelatoriosControlller@gmdAnimalBaixados')->name('relatorios.gmdAnimal-baixados');
    Route::get('/gmdadnimal-baixados/excel/{request}/{req2}/{req3}', 'RelatoriosControlller@gmdAnimalExcelBaixados')->name('relatorios.gmdAnimal-baixados.excel');

    Route::post('/custo_Animal', 'RelatoriosControlller@custo_Animal')->name('relatorios.custo_Animal');
    Route::get('/custo_Animal/excel/{request}/{req2}/{req3}', 'RelatoriosControlller@custo_AnimalExcel')->name('relatorios.custo_Animal.excel');

    Route::post('/compras_Animal', 'RelatoriosControlller@compras_Animal')->name('relatorios.compras_Animal');
    Route::get('/compra_Animal/excel/{request}/{req2}/{req3}/{req4}/{req5}', 'RelatoriosControlller@compras_AnimalExcel')->name('relatorios.compras_Animal.excel');

    Route::post('/venda_Animal', 'RelatoriosControlller@vendas_Animal')->name('relatorios.vendas_Animal');
    Route::get('/venda_Animal/excel/{request}/{req2}/{req3}/{req4}/{req5}', 'RelatoriosControlller@vendas_AnimalExcel')->name('relatorios.vendas_Animal.excel');

    Route::post('/financeiro_pagar', 'RelatoriosControlller@financeiro_pagar')->name('relatorios.financeiro_pagar');
    Route::post('/financeiro_pagar/excel/', 'RelatoriosControlller@financeiro_pagarExcel')->name('relatorios.financeiro_pagar.excel');

    Route::post('/financeiro_receber', 'RelatoriosControlller@financeiro_receber')->name('relatorios.financeiro_receber');
    Route::get('/financeiro_receber/excel/{request}/{req2}', 'RelatoriosControlller@financeiro_receberExcel')->name('relatorios.financeiro_receber.excel');

});
