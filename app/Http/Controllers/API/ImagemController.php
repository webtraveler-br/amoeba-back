<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Storage;
use App\Imagem;


class ImagemController extends BaseController
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|max:500',
            'descricao' => 'required|max:500',
            'imagem' => 'required|image',
        ]);
        if($validator->fails())
        {
            return $this->enviarRespostaErro('Campo Incorreto', $validator->errors());
        }

        $caminho = Storage::disk('public')->put('imagens',$request->file('imagem'));
        /*
        $caminho = request()->file('imagem');
        $caminho->store('imagens', ['disk' => 'my_files']);
        */
        $imagem = Imagem::Create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'caminho' => $caminho,
        ]);

        return $this->enviarRespostaSucesso($imagem, 'Imagem criada com sucesso!', 201);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);
        if($validator->fails())
        {
            return $this->enviarRespostaErro('campo incorreto', $validator->errors());
        }

        $imagem = Imagem::find($request->id);
        if(!$imagem)
        {
            return $this::enviarRespostaErro('Imagem não encontrada', $validator->errors());
        }

        return $this::enviarRespostaSucesso($imagem, 'Imagem mostrada com sucesso', 200);
    }

    public function index()
    {
        $imagens = Imagem::all();
            return $this::enviarRespostaSucesso($imagens, 'Imagens cadastradas com sucesso', 200);
    }


    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'titulo' => 'required|max:500',
            'descricao' => 'required|max:500',
            'imagem' => 'required|image',
        ]);
        if ($validator->fails()){
            return $this->enviarRespostaErro('Campo Incorreto', $validator->errors());
        }
        
        $imagem = Imagem::find($request->id);
        if(!$imagem)
        {
            return $this::enviarRespostaErro('Imagem não encontrada', $validator->errors());
        }

        Storage::delete($imagem->caminho);
        $caminho = Storage::disk('public')->put('imagens',$request->file('imagem'));
        $imagem->caminho = $caminho;

        $imagem->titulo = $request->titulo;
        $imagem->descricao = $request->descricao;
        $imagem->save();

        return $this::enviarRespostaSucesso($imagem, 'Imagem Atualizada com Sucesso', 200);
    }


    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return $this->enviarRespostaErro('campo incorreto', $validator->errors());
        }

        $imagem = Imagem::find($request->id);
        if(!$imagem)
        {
            return $this::enviarRespostaErro('Imagem não encontrada', $validator->errors());
        }

        if($imagem->servicos()->first())
        {
            return $this::enviarRespostaErro('Imagem está sendo utilizada');
        }

        if ($imagem->portfolios()->first())
        {
            return $this::enviarRespostaErro('Imagem está sendo utilizada');
        }

        if ($imagem->equipes()->first())
        {
            return $this::enviarRespostaERro('Imagem está sendo utilizada');
        }

        Storage::delete($imagem->caminho);
         $imagem->delete();

         return $this::enviarRespostaSucesso($imagem, 'Imagem deletada com sucesso', 200);
    }
}
