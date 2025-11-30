<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;

/*
--------------------------------------------------------------------------
            Web Routes
-------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/produtos', [ProdutoController::class, 'index']);
Route::post('/produtos', [ProdutoController::class, 'store']);

Route::get('/categorias', [CategoriaController::class, 'index']);
Route::post('/categorias', [CategoriaController::class, 'store']); 

Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);