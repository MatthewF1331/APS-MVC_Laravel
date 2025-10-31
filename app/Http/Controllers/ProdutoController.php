<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto; 

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos', ['produtos' => $produtos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3',
            'preco' => 'nullable|numeric|min:0'
        ]);

        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco
        ]);

        return redirect('/produtos')->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id); 
        $produto->delete(); 
        return redirect('/produtos')->with('sucesso', 'Produto apagado com sucesso!');
    }
}