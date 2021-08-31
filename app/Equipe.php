<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Imagem;


class Equipe extends Model
{
    protected $fillable = ['nome', 'cargo', 'descricao', 'facebook', 'twitter', 'linkedin', 'instagram', 'imagem_id'];
  
    public $timestamps = false;

    protected $with = ['imagem'];

    public function imagem()
    {
        return $this->belongsTo(Imagem::class);
    }
}    