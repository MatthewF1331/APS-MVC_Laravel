<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    // Adicionado 'image_path' para o requisito de Upload de Arquivos
    protected $fillable = ['nome', 'descricao', 'preco', 'image_path'];

    /**
     * Relação N:M com Categoria
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class);
    }
}