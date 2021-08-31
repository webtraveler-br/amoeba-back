<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Portfolio;

class Categoria extends Model
{

    Protected $fillable = ['nome'];

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }

}