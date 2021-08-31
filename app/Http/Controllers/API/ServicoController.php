<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Servico;
use App\Imagem;



class ServicoController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imagem_id' => 'required|integer',
            'servico' => 'required|max:255',
            'descricao' => 'required|max:500', 
            
        ]);

        if ($validator->fails()){
            return $this::enviarRespostaErro('Erros de validação', $validator->errors());
        };
        $servico = new Servico;
           $servico->servico = $request->servico; 
           $servico->descricao = $request->descricao;
           
        $imagem = Imagem::find($request->imagem_id);
        if (!$imagem)
        {
            return $this::enviarRespostaErro('Imagem não encontrada');
        }

       

        $servico->imagem()->associate($imagem)->save();
        return $this->enviarRespostaSucesso($servico, 'Servico criado com sucesso!', 200);
    }

    public function update(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'servico' => 'required|max:225',
            'descricao' => 'required|max:500',
            'imagem_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this::enviarRespostaErro('Erro de validação'. $validator->errors());
        }

        $servico = Servico::find($request->id);
        if (!$servico){
            return $this::enviarRespostaErro('Servico não encontrado', 201);
        };
        $imagem = Imagem::find($request->imagem_id);
        if (!$imagem)
        {
            return $this::enviarRespostaErro('Imagem não encontrada');
        }
        
        $servico->update($request->all());
        $servico->imagem()->associate($imagem)->save();

        return $this::enviarRespostaSucesso($servico, 'Serviço atualizado com sucesso!', 201);

    }
    public function index()
    {
        $servico = Servico::all();
            return $this::enviarRespostaSucesso($servico,'Serviço cadastrado', 200);
        
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this::enviarRespostaErro('Erro de validação'. $validator->errors());
        }

        $servico = Servico::find($request->id);
        if(!$servico)
        {
            return $this::enviarRespostaErro('Serviço não encontrado', $validator->errors());
        }

        return $this::enviarRespostaSucesso($servico, 'Serviço encontrado', 201);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer', 
        ]);

        if ($validator->fails()) {
            return $this::enviarRespostaErro('Erro de validação'. $validator->errors());
        }

        $servico = Servico::find($request->id);
        if(!$servico)
        {
            return $this::enviarRespostaErro('Serviço não encontrado', $validator->errors());
        }

        $servico->delete();
        return $this::enviarRespostaSucesso($servico, 'Servico deletado com sucesso!', 200);
        
    }
}
