<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categoria;
use App\Imagem;

class Portfolio extends Model
{

    protected $fillable = ['imagem_id', 'link'];

    protected $with = ['imagem', 'categorias'];

    public function imagem()
    {
        return $this->belongsTo(Imagem::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class);
    }
}
