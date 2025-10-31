<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias', ['categorias' => $categorias]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nome' => 'required|min:3'
        ]);

        Categoria::create([
            'nome' => $request->nome
        ]);

        return redirect('/categorias')->with('sucesso', 'Categoria cadastrada com sucesso!');
    }
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return redirect('/categorias')->with('sucesso', 'Categoria apagada com sucesso!');
    }
}