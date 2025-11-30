<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CategoriaController extends Controller
{
    /**
     * Exibe a lista de categorias.
     */
    public function index(Request $request)
    {
        $request->session()->put('last_accessed_page', 'Categorias');
        $theme = Cookie::get('user_theme', 'light');

        $categorias = Categoria::all();
        return view('categorias', [
            'categorias' => $categorias,
            'theme' => $theme,
        ]);
    }

    /**
     * Exibe o formulário de edição de categoria.
     */
    public function edit(Categoria $categoria)
    {
        $theme = Cookie::get('user_theme', 'light');
        return view('edit_categoria', [
            'categoria' => $categoria,
            'theme' => $theme,
        ]);
    }

    /**
     * Salva uma nova categoria no banco de dados (CRUD - Create).
     */
    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|min:3']);

        Categoria::create(['nome' => $request->nome]);

        return redirect('/categorias')->with('sucesso', 'Categoria cadastrada com sucesso!');
    }

    /**
     * Atualiza a categoria no banco de dados (CRUD - Update).
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate(['nome' => 'required|min:3']);

        $categoria->update(['nome' => $request->nome]);

        return redirect('/categorias')->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove a categoria do banco de dados (CRUD - Delete).
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect('/categorias')->with('sucesso', 'Categoria apagada com sucesso!');
    }

    /**
     * Define o cookie de tema e redireciona de volta.
     */
    public function set_theme(Request $request)
    {
        $theme = $request->input('theme', 'light');
        return back()->cookie('user_theme', $theme, 60);
    }
}