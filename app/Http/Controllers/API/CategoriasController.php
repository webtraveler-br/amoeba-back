<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Categoria;
use App\Portfolio;

class CategoriasController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'nome' => 'required|max:500', 
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Campo Incorreto', $validator->errors());
        }

        $categoria = Categoria::Create([
            'nome' => $request->nome,
        ]);
        
        $categoria->save();
        return $this->enviarRespostaSucesso($categoria, 'Categoria Criada com sucesso!', 201);
    }
 
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);
        
        if($validator->fails())
        {
            return $this::enviarRespostaErro('Campo Incorreto', $validator->errors());
        }

        $categoria = Categoria::find($request->id);
        if(!$categoria)
        {
            return $this::enviarRespostaErro('Categoria não encontrada', $validator->errors());
        }

        return $this::enviarRespostaSucesso($categoria, 'Categoria Mostrada com Sucesso', 201); 
    }

    public function update(Request $request)
    {
        $validator   = Validator::make($request->all(),[
            'id' => 'required|integer',
            'nome' => 'required|max:500',
        ]);
        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Campo Incorreto', $validator->errors());
        }

        $categoria = Categoria::find($request->id);

        if(!$categoria)
        {
            return $this::enviarRespostaErro('Categoria não Encontrada', $validator->errors());
        }

        $categoria->delete();

        $categoria->nome = $request->nome;
        $categoria->save();

        return $this->enviarRespostaSucesso($categoria, 'Categoria Atualizada com Sucesso', 200);
    }

    public function index(Request $request)
    {
        $categoria = Categoria::all();
            return $this::enviarRespostaSucesso($categoria, 'Categorias cadastradas com sucesso', 200);
        

    
    }  
    
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);
        
        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Campo Incorreto', $validator->errors());
        }

        $categoria = Categoria::find($request->id);
        if(!$categoria)
        {
            return $this::enviarRespostaErro('Categoria Não Encontrada');
        }

        if ($categoria->portfolios()->first())
        {
            return $this::enviarRespostaErro('Categoria Esta sendo utilizada');
        }

        $categoria->delete();

        return $this::enviarRespostaSucesso($categoria, 'Categoria deletada com sucesso'); 
    }
}

