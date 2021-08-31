<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Imagem;

class Servico extends Model
{
    protected $fillable = ['servico','descricao'];

    protected $with = ['imagem'];

    public function imagem()
    {
        return $this->belongsTo(Imagem::class);
    }
}
