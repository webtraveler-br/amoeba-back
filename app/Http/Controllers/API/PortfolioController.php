<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Portfolio;
use Illuminate\Support\Facades\Storage;
use App\Imagem;
use App\Categoria;

class PortfolioController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imagem_id'=>'required|integer',
            'categoria_id'=>'required|array',
            'link' => 'required|max:300',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de validação', $validator->errors());
        };
        
        $imagem = Imagem::find($request->imagem_id);
        if(!$imagem)
        {
            return $this::enviarRespostaErro('imagem não encontrada', $validator->errors());
        }

        foreach($request->categoria_id as $categoria_id)
        {
            $categoria = Categoria::find($categoria_id);
            if(!$categoria)
            {
                return $this::enviarRespostaErro('Categoria não encontrada');
            }
        }

        $Portfolio = new Portfolio;
        $Portfolio->link = $request->link;
        $Portfolio->imagem()->associate($imagem)->save();
        $Portfolio->categorias()->attach($request->categoria_id);
        $Portfolio->save();

        return $this::enviarRespostaSucesso($Portfolio, 'Portfolio criado com sucesso', 200);
    }


    public function show(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Campo Incorreto', $validator->errors());
        }
        
        $Portfolio = Portfolio::find($request->id);
        if(!$Portfolio)
        {
            return $this::enviarRespostaErro('Portfolio não encontrado', $validator->errors());
        }

        return $this::enviarRespostaSucesso($Portfolio, 'Portfolio mostrado com Sucesso!', 200);
    }

    public function index(Request $request)
    {
        $Portfolio = Portfolio::all();
            return $this::enviarRespostaSucesso($Portfolio, 'Portfolios encontrados com sucesso', 200);
        
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required|integer',
            'link'=>'required|max:300',
            'categoria_id'=>'required|array',
            'imagem_id'=>'required|integer',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de validação', $validator->errors());
        };

        $Portfolio = Portfolio::find($request->id);
        if(!$Portfolio)
        {
            return $this::enviarRespostaErro($Portfolio, 'Item não encontrado', 201);
        }

        $imagem = Imagem::find($request->imagem_id);
        if(!$imagem)
        {
            return $this::enviarRespostaErro('imagem não encontrada');
        }

        foreach($request->categoria_id as $categoria_id)
        {
            $categoria = Categoria::find($categoria_id);
            if(!$categoria)
            {
                return $this::enviarRespostaErro('Categoria Não encontrada');
            }
        }

        $Portfolio->update($request->all());
        $Portfolio->imagem()->associate($imagem)->save();
        $Portfolio->categorias()->sync($request->categoria_id);
        $Portfolio->save();
        
        return $this::enviarRespostaSucesso($Portfolio, 'Item atualizado com sucesso', 200);


    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required|integer',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de validação', $validator->errors());
        };

        $Portfolio = Portfolio::find($request->id);
        if(!$Portfolio)
        {
            return $this::enviarRespostaErro($Portfolio, 'Item não encontrado', 201);
        }

        $Portfolio->categorias()->detach();
        $Portfolio->delete();

        return $this::enviarRespostaSucesso($Portfolio, 'Item deletado', 200);
    }



}
