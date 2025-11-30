<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;

class ProdutoController extends Controller
{
    /**
     * Exibe a lista de produtos.
     */
    public function index(Request $request)
    {
        $request->session()->put('last_accessed_page', 'Produtos');
        $theme = Cookie::get('user_theme', 'light');

        $produtos = Produto::with('categorias')->get();
        $categorias = Categoria::all();

        return view('produtos', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'theme' => $theme,
        ]);
    }

    /**
     * Exibe o formulário de edição de produto.
     */
    public function edit(Produto $produto)
    {
        $theme = Cookie::get('user_theme', 'light');
        $categorias = Categoria::all();

        return view('edit_produto', [
            'produto' => $produto,
            'categorias' => $categorias,
            'theme' => $theme,
        ]);
    }

    /**
     * Salva um novo produto no banco de dados (CRUD - Create).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3',
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categorias_ids' => 'nullable|array', 
            'categorias_ids.*' => 'exists:categorias,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('produtos', 'public');
        }

        $produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'image_path' => $imagePath,
        ]);

        if ($request->has('categorias_ids')) {
            $produto->categorias()->attach($request->categorias_ids);
        }

        return redirect('/produtos')->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    /**
     * Atualiza o produto no banco de dados (CRUD - Update).
     */
    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|min:3',
            'preco' => 'nullable|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categorias_ids' => 'nullable|array',
            'categorias_ids.*' => 'exists:categorias,id',
        ]);

        $data = $request->only('nome', 'descricao', 'preco');

        if ($request->hasFile('imagem')) {
            if ($produto->image_path) {
                Storage::disk('public')->delete($produto->image_path);
            }
            $data['image_path'] = $request->file('imagem')->store('produtos', 'public');
        }

        $produto->update($data);

        $produto->categorias()->sync($request->categorias_ids ?? []);

        return redirect('/produtos')->with('sucesso', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove o produto do banco de dados (CRUD - Delete).
     */
    public function destroy(Produto $produto)
    {
        if ($produto->image_path) {
            Storage::disk('public')->delete($produto->image_path);
        }
        $produto->delete();

        return redirect('/produtos')->with('sucesso', 'Produto apagado com sucesso!');
    }
}